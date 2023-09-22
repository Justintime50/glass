<?php

namespace Tests\Unit;

use App\Http\Controllers\ImageController;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        self::$controller = new ImageController();
    }

    /**
     * Tests that we get the image asset path correctly.
     *
     * @return void
     */
    public function testGetImageAssetPath()
    {
        $assetPath = self::$controller->getImageAssetPath(ImageController::$postImagesSubdirectory, 'mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }

    /**
     * Tests that we get the public image path correctly.
     *
     * @return void
     */
    public function testGetImagePublicPath()
    {
        $assetPath = self::$controller->getImagePublicPath(ImageController::$postImagesSubdirectory, 'mock-image.png');

        $this->assertStringContainsString('storage/images/posts/mock-image.png', $assetPath);
    }
}
