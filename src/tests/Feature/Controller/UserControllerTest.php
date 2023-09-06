<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that we return the admin page and data correctly.
     *
     * @return void
     */
    public function testShowProfile()
    {
        $controller = new UserController();

        $request = Request::create('/profile', 'GET');
        $controller->showProfile($request);

        // TODO: Is there a better assertion here since we return an empty view?
        $this->assertTrue(true);
    }

    /**
     * Tests that we update a user correctly.
     *
     * @return void
     */
    public function testUpdate()
    {
        $controller = new UserController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory()->create();

        $request = Request::create('/users', 'POST', [
            'name' => 'updated name',
            'bio' => 'test bio',
        ]);
        $response = $controller->update($request);

        $this->assertDatabaseHas('users', ['name' => 'updated name']);
        $this->assertEquals('Profile updated.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we update a password correctly.
     *
     * @return void
     */
    public function testUpdatePassword()
    {
        $controller = new UserController();
        $authedUser = User::find(1);
        $this->actingAs($authedUser);

        $password = 'new_password';

        $request = Request::create('/users', 'POST', [
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response = $controller->updatePassword($request);

        $user = User::find($authedUser->id);

        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals('Your password was updated successfully.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can update a profile picture correctly.
     *
     * @return void
     */
    public function testUpdateProfilePic()
    {
        // TODO: Finish writing this test asserting an image got uploaded
        $this->doesNotPerformAssertions();
        // $controller = new UserController();

        // $request = Request::create("/update-profile-pic", 'POST');
        // $response = $controller->updateProfilePic($request);

        // $this->assertEquals('Avatar updated successfully.', $response->getSession()->get('message'));
        // $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a user correctly.
     *
     * @return void
     */
    public function testDelete()
    {
        $controller = new UserController();
        $user = User::find(1);

        $request = Request::create("/users/$user->id", 'DELETE');
        $response = $controller->delete($request, $user->id);

        $this->assertSoftDeleted('users', ['id' => 1]);
        $this->assertEquals('User deleted.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
