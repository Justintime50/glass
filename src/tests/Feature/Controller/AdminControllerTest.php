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

    public static function setUpBeforeClass(): void
    {
        self::$controller = new AdminController();
    }

    /**
     * Tests that we return the admin page and data correctly.
     *
     * @return void
     */
    public function testShowAdminDashboard()
    {
        Category::factory()->create();
        Post::factory()->create();

        $request = Request::create('/admin', 'GET');
        $response = self::$controller->showAdminDashboard($request);

        $viewData = $response->getData();

        $this->assertGreaterThanOrEqual(1, count($viewData['users']));
        $this->assertEquals('Blog', $viewData['settings']['title']);
        $this->assertGreaterThanOrEqual(1, count($viewData['posts']));
        $this->assertEquals('Uncategorized', $viewData['categories'][0]['category']);
    }

    /**
     * Tests that we can update settings correctly.
     *
     * @return void
     */
    public function testUpdateSettings()
    {
        $request = Request::create('/settings', 'PATCH', [
            'title' => 'new title',
            'comments' => 0,
            'theme' => 2,
        ]);
        $response = self::$controller->updateSettings($request);

        $this->assertDatabaseHas('settings', ['title' => 'new title']);
        $this->assertDatabaseHas('settings', ['comments' => 0]);
        $this->assertDatabaseHas('settings', ['theme' => 2]);
        $this->assertEquals('Settings updated.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can update a user's role correctly.
     *
     * @return void
     */
    public function testUpdateUserRole()
    {
        $request = Request::create('/settings', 'PATCH', [
            'role' => 3,
        ]);
        $response = self::$controller->updateUserRole($request, 1);

        $this->assertDatabaseHas('users', ['role' => 3]);
        $this->assertEquals('User role updated.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
