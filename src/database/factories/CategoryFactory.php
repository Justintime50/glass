<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'category' => $faker->word,
    ];
});
