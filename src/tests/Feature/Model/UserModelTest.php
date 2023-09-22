<?php

namespace Tests\Feature\Model;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests Image relationships are setup correctly.
     *
     * @return void
     */
    public function testImageRelationships()
    {
        $user = User::find(1);
        $image = Image::factory()->create();
        $user->image_id = $image->id;

        $this->assertInstanceOf(Image::class, $user->image);
    }
}
