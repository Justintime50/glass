<?php

namespace Tests\Feature\Model;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests Post relationships are setup correctly.
     *
     * @return void
     */
    public function testPostRelationships()
    {
        $image = Image::factory()->create();
        $post = Post::factory(['image_id' => $image->id])->create();

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertInstanceOf(Image::class, $post->image);
    }
}
