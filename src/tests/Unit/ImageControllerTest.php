<?php

namespace Tests\Unit;

use App\Http\Controllers\ImageController;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    /**
     * Tests that we get the image asset path correctly.
     *
     * @return void
     */
    public function testGetImageAssetPath()
    {
        $controller = new ImageController();

        $assetPath = $controller->getImageAssetPath(ImageController::$postImagesSubdirectory, 'mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }

    /**
     * Tests that we get the public image path correctly.
     *
     * @return void
     */
    public function testGetImagePublicPath()
    {
        $controller = new ImageController();

        $assetPath = $controller->getImagePublicPath(ImageController::$postImagesSubdirectory, 'mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }
}
