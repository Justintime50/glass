<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the admin page and data correctly.
     *
     * @return void
     */
    public function testShowAdminDashboard()
    {
        $controller = new AdminController();
        Category::factory()->create();
        Post::factory()->create();

        $request = Request::create("/admin", 'GET');
        $response = $controller->showAdminDashboard($request);

        $viewData = $response->getData();

        $this->assertGreaterThanOrEqual(1, count($viewData['users']));
        $this->assertEquals('Blog', $viewData['settings']['title']);
        $this->assertGreaterThanOrEqual(1, count($viewData['posts']));
        $this->assertEquals('Uncategorized', $viewData['categories'][0]['category']);
    }
}
