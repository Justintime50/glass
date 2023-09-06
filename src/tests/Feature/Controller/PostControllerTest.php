<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the posts page and data correctly.
     *
     * @return void
     */
    public function testShowPosts()
    {
        $controller = new PostController();
        $category = Category::factory()->create();
        Post::factory(['category_id' => $category->id])->create();

        $request = Request::create('/posts', 'GET');
        $response = $controller->showPosts($request);

        $viewData = $response->getData();

        $this->assertGreaterThanOrEqual(1, count($viewData['posts']));
        $this->assertGreaterThanOrEqual(1, count($viewData['categories']));
    }

    /**
     * Tests that we return the posts page and data correctly.
     *
     * @return void
     */
    public function testShowPostsByCategory()
    {
        $controller = new PostController();
        $category = Category::factory()->create();
        Post::factory(['category_id' => $category->id])->create();

        $request = Request::create("/posts/$category->category", 'GET');
        $response = $controller->showPostsByCategory($request, $category->category);

        $viewData = $response->getData();

        $this->assertEquals($category->category, $viewData['categoryRecord']['category']);
        $this->assertGreaterThanOrEqual(1, count($viewData['posts']));
        $this->assertGreaterThanOrEqual(1, count($viewData['categories']));
    }

    /**
     * Tests that we return a single post page and data correctly.
     *
     * @return void
     */
    public function testShowPost()
    {
        $controller = new PostController();
        $authorUser = User::find(1);
        $post = Post::factory([
            'user_id' => $authorUser->id,
            'published' => 1,
        ])->create();
        Comment::factory(['post_id' => $post->id])->create();

        $request = Request::create("/$authorUser->name/$post->slug", 'GET');
        $response = $controller->showPost($request, $authorUser->name, $post->slug);

        $viewData = $response->getData();

        $this->assertEquals($post->post, $viewData['post']['post']);
        $this->assertGreaterThanOrEqual(1, count($viewData['comments']));
    }

    /**
     * Tests that we return a single post page that is unpublished for admins to see.
     *
     * @return void
     */
    public function testShowPostAdmin()
    {
        $controller = new PostController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory([
            'user_id' => $authedUser->id,
            'published' => 0, // test that an unpublished post can be viewed by admins
        ])->create();
        Comment::factory(['post_id' => $post->id])->create();

        $request = Request::create("/$authedUser->name/$post->slug", 'GET');
        $response = $controller->showPost($request, $authedUser->name, $post->slug);

        $viewData = $response->getData();

        $this->assertEquals($post->post, $viewData['post']['post']);
        $this->assertGreaterThanOrEqual(1, count($viewData['comments']));
    }

    /**
     * Tests that we return the create post page and data correctly.
     *
     * @return void
     */
    public function testShowCreatePage()
    {
        $controller = new PostController();
        Category::factory()->create();

        $request = Request::create('/create-post', 'GET');
        $response = $controller->showCreatePage($request);

        $viewData = $response->getData();

        $this->assertGreaterThanOrEqual(1, count($viewData['categories']));
    }

    /**
     * Tests that we return the create post page and data correctly.
     *
     * @return void
     */
    public function testShowEditPage()
    {
        $controller = new PostController();
        $authorUser = User::find(1);
        $post = Post::factory()->create();
        Category::factory()->create();

        $request = Request::create("/$authorUser->name/$post->slug", 'GET');
        $response = $controller->showEditPage($request, $authorUser->name, $post->slug);

        $viewData = $response->getData();

        $this->assertEquals($post->post, $viewData['post']['post']);
        $this->assertGreaterThanOrEqual(1, count($viewData['categories']));
    }

    /**
     * Tests that we create a post correctly.
     *
     * @return void
     */
    public function testCreate()
    {
        $controller = new PostController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);

        $request = Request::create('/posts', 'POST', [
            'title' => 'new post',
            'slug' => 'new-post',
            'keywords' => 'keyword',
            'category' => 'category',
            'post' => 'mock content here',
            'published' => 1,
        ]);
        $response = $controller->create($request);

        $this->assertDatabaseHas('posts', ['post' => 'mock content here']);
        $this->assertEquals('Post created.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we update a post correctly.
     *
     * @return void
     */
    public function testUpdate()
    {
        $controller = new PostController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory()->create();

        $request = Request::create("/posts/$post->id", 'PATCH', [
            'title' => 'new post',
            'slug' => 'new-post',
            'keywords' => 'keyword',
            'category' => 'category',
            'post' => 'mock content here',
            'published' => 1,
        ]);
        $response = $controller->update($request, $post->id);

        $this->assertDatabaseHas('posts', ['post' => 'mock content here']);
        $this->assertEquals('Post updated.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a post correctly.
     *
     * @return void
     */
    public function testDelete()
    {
        $controller = new PostController();
        $post = Post::factory(['post' => 'deleted post'])->create();

        $request = Request::create("/posts/$post->id", 'DELETE');
        $response = $controller->delete($request, $post->id);

        $this->assertSoftDeleted('posts', ['post' => 'deleted post']);
        $this->assertEquals('Post deleted.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we return the images page and data correctly.
     *
     * @return void
     */
    public function testShowImages()
    {
        $controller = new PostController();

        $request = Request::create('/images', 'GET');
        $controller->showImagesPage($request);

        // TODO: Is there a better assertion here since we return an empty view?
        $this->assertTrue(true);
    }

    /**
     * Tests that we can upload a post image correctly.
     *
     * @return void
     */
    public function testUpdateProfilePic()
    {
        // TODO: Finish writing this test asserting an image got uploaded
        $this->doesNotPerformAssertions();
        // $controller = new PostController();

        // $request = Request::create("/images", 'POST');
        // $response = $controller->uploadPostImage($request);

        // $this->assertEquals('Image uploaded successfully.', $response->getSession()->get('message'));
        // $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a post image correctly.
     *
     * @return void
     */
    public function testDeletePostImage()
    {
        // TODO: Finish writing this test asserting an image got uploaded
        $this->doesNotPerformAssertions();
        // $controller = new PostController();

        // $request = Request::create("/images", 'DELETE');
        // $response = $controller->deletePostImage($request);

        // $this->assertEquals('Image deleted.', $response->getSession()->get('message'));
        // $this->assertEquals(302, $response->getStatusCode());
    }
}
