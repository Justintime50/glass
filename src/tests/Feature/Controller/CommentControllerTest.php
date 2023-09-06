<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\CommentController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the admin page and data correctly.
     *
     * @return void
     */
    public function testShowComments()
    {
        $controller = new CommentController();
        $post = Post::factory()->create();
        Comment::factory(['post_id' => $post->id])->create();

        $request = Request::create('/comments', 'GET');
        $response = $controller->showComments($request);

        $viewData = $response->getData();

        $this->assertGreaterThanOrEqual(1, count($viewData['comments']));
    }

    /**
     * Tests that we create a comment correctly.
     *
     * @return void
     */
    public function testCreate()
    {
        $controller = new CommentController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory()->create();

        $request = Request::create('/comments', 'POST', [
            'comment' => 'new comment',
            'post_id' => $post->id,
        ]);
        $response = $controller->create($request);

        $this->assertDatabaseHas('comments', ['comment' => 'new comment']);
        $this->assertEquals('Comment created.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a comment correctly.
     *
     * @return void
     */
    public function testDelete()
    {
        $controller = new CommentController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory()->create();
        $comment = Comment::factory([
            'comment' => 'deleted comment',
            'post_id' => $post->id,
        ])->create();

        $request = Request::create("/comments/$comment->id", 'DELETE');
        $response = $controller->delete($request, $comment->id);

        $this->assertSoftDeleted('comments', ['comment' => 'deleted comment']);
        $this->assertEquals('Comment deleted.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
