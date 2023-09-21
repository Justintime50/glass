<?php

namespace Tests\Unit;

use App\Http\Controllers\PostController;
use App\Models\Post;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * Tests that we generate the reading time correctly.
     *
     * @return void
     */
    public function testGenerateReadingTime()
    {
        $controller = new PostController();
        $post = Post::factory()->create();

        $readingTime = $controller::generateReadingTime($post);

        $this->assertEquals(1, $readingTime);
    }
}
