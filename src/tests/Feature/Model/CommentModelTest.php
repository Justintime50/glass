<?php

namespace Tests\Feature\Model;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests Comment relationships are setup correctly.
     *
     * @return void
     */
    public function testCommentRelationships()
    {
        // Seed necessary records for factory
        Post::factory()->create();

        $comment = Comment::factory()->create();

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertInstanceOf(Post::class, $comment->post);
    }
}
