<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we create a category correctly.
     *
     * @return void
     */
    public function testCreate()
    {
        $controller = new CategoryController();

        $request = Request::create('/categories', 'POST', [
            'category' => 'new category'
        ]);
        $response = $controller->create($request);

        $this->assertDatabaseHas('categories', ['category' => 'new category']);
        $this->assertEquals('Category created.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we re-enable a soft-deleted category correctly.
     *
     * @return void
     */
    public function testReenableSoftDeleted()
    {
        $controller = new CategoryController();
        $category = Category::factory(['category' => 'existing category'])->create();

        // Delete the category so we can later re-enable it
        $deleteRequest = Request::create("/categories/$category->id", 'DELETE');
        $controller->delete($deleteRequest, $category->id);

        $request = Request::create('/categories', 'POST', [
            'category' => 'existing category'
        ]);
        $response = $controller->create($request);

        $this->assertNotSoftDeleted('categories', ['category' => 'existing category']);
        $this->assertEquals('Category created.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can update a category correctly.
     *
     * @return void
     */
    public function testUpdate()
    {
        $controller = new CategoryController();
        $category = Category::factory()->create();

        $request = Request::create("/categories/$category->id", 'PATCH', [
            'category' => 'updated category',
        ]);
        $response = $controller->update($request, $category->id);

        $this->assertDatabaseHas('categories', ['category' => 'updated category']);
        $this->assertEquals('Category updated.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a category correctly.
     *
     * @return void
     */
    public function testDelete()
    {
        $controller = new CategoryController();
        $category = Category::factory(['category' => 'deleted category'])->create();

        $request = Request::create("/categories/$category->id", 'DELETE');
        $response = $controller->delete($request, $category->id);

        $this->assertSoftDeleted('categories', ['category' => 'deleted category']);
        $this->assertEquals('Category deleted.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
