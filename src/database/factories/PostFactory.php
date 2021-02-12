<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence;
    $slug = Str::slug($title, '-');
    return [
        'title' => $title,
        'slug' => $slug,
        'reading_time' => $faker->randomNumber($nbDigits = 1),
        'keywords' => $faker->word,
        'category_id' => '1',
        'user_id' => 1,
        'post' => $faker->paragraph,
        'banner_image_url' => null,
        'published' => 1,
    ];
});
