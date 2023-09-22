<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ImageController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public static function setUpBeforeClass(): void
    {
        self::$controller = new ImageController();
    }

    /**
     * Tests that we return the images page and data correctly.
     *
     * @return void
     */
    public function testShowImages()
    {
        $request = Request::create('/images', 'GET');
        self::$controller->showImagesPage($request);

        // TODO: Is there a better assertion here since we return an empty view?
        $this->assertTrue(true);
    }

    /**
     * Tests that we can upload a post image correctly.
     *
     * @return void
     */
    public function testUploadPostImage()
    {
        // TODO: Finish writing this test asserting an image got uploaded
        $this->doesNotPerformAssertions();

        // $request = Request::create("/images", 'POST');
        // $response = self::$controller->uploadPostImage($request);

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

        // $request = Request::create("/images", 'DELETE');
        // $response = self::$controller->deletePostImage($request);

        // $this->assertEquals('Image deleted.', $response->getSession()->get('message'));
        // $this->assertEquals(302, $response->getStatusCode());
    }
}
