<?php

namespace Tests\Feature\Model;

use App\Models\Category;
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
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertInstanceOf(Category::class, $post->category);
    }
}
