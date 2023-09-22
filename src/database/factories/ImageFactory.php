<?php

namespace Database\Factories;

use App\Http\Controllers\ImageController;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subdirectory' => ImageController::$postImagesSubdirectory,
            'filename' => $this->faker->word(),
        ];
    }
}
