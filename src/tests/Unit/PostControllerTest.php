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

    /**
     * Tests that we get the image asset path correctly.
     *
     * @return void
     */
    public function testGetImageAssetPath()
    {
        $controller = new PostController();

        $assetPath = $controller::getImageAssetPath('mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }

    /**
     * Tests that we get the public image path correctly.
     *
     * @return void
     */
    public function testGetImagePublicPath()
    {
        $controller = new PostController();

        $assetPath = $controller::getImagePublicPath('mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }
}
