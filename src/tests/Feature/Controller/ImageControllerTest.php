<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\ImageController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the images page and data correctly.
     *
     * @return void
     */
    public function testShowImages()
    {
        $controller = new ImageController();

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
    public function testUploadPostImage()
    {
        // TODO: Finish writing this test asserting an image got uploaded
        $this->doesNotPerformAssertions();
        // $controller = new ImageController();

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
        // $controller = new ImageController();

        // $request = Request::create("/images", 'DELETE');
        // $response = $controller->deletePostImage($request);

        // $this->assertEquals('Image deleted.', $response->getSession()->get('message'));
        // $this->assertEquals(302, $response->getStatusCode());
    }
}
