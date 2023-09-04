<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\RssFeedController;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class RssFeedControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the RSS feed correctly.
     *
     * @return void
     */
    public function testFeed()
    {
        $controller = new RssFeedController();
        Post::factory()->create();

        $request = Request::create('/feed', 'GET');
        $response = $controller->getFeed($request);

        $xml = simplexml_load_string($response->getContent());
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
    }
}
