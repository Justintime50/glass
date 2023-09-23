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

    public static function setUpBeforeClass(): void
    {
        self::$controller = new RssFeedController();
    }

    /**
     * Tests that we return the RSS feed correctly.
     *
     * @return void
     */
    public function testFeed()
    {
        Post::factory()->create();

        $request = Request::create('/feed', 'GET');
        $response = self::$controller->getFeed($request);

        $xml = simplexml_load_string($response->getContent());
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
    }
}
