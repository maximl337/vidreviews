<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'video_url' => 'https://via.placeholder.com/300x250',
        'thumbnail' => 'https://via.placeholder.com/300x250'
    ];
});
