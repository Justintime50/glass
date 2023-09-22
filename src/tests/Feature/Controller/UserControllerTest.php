<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public static function setUpBeforeClass(): void
    {
        self::$controller = new UserController();
    }

    /**
     * Tests that we return the admin page and data correctly.
     *
     * @return void
     */
    public function testShowProfile()
    {
        $request = Request::create('/profile', 'GET');
        self::$controller->showProfile($request);

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
        $authedUser = User::find(1);
        $this->actingAs($authedUser);
        $post = Post::factory()->create();

        $request = Request::create('/users', 'POST', [
            'name' => 'updated name',
            'bio' => 'test bio',
        ]);
        $response = self::$controller->update($request);

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
        $authedUser = User::find(1);
        $this->actingAs($authedUser);

        $password = 'new_password';

        $request = Request::create('/users', 'POST', [
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response = self::$controller->updatePassword($request);

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
        Storage::fake('public');

        $authedUser = User::find(1);
        $this->actingAs($authedUser);

        $request = Request::create('/update-profile-pic', 'POST', [], [], [
            'image' => UploadedFile::fake()->image('image.jpg'),
        ]);
        $response = self::$controller->updateProfilePic($request);

        $this->assertEquals('Avatar updated successfully.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that we can delete a user correctly.
     *
     * @return void
     */
    public function testDelete()
    {
        $user = User::find(1);

        $request = Request::create("/users/$user->id", 'DELETE');
        $response = self::$controller->delete($request, $user->id);

        $this->assertSoftDeleted('users', ['id' => 1]);
        $this->assertEquals('User deleted.', $response->getSession()->get('message'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
