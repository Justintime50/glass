<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'post_id' => 1,
        'comment' => $faker->sentence,
    ];
});
