<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'keywords' => $this->faker->word(),
            'category_id' => '1',
            'user_id' => 1,
            'post' => $this->faker->paragraph(),
            'banner_image_url' => null,
            'published' => 1,
        ];
    }
}
