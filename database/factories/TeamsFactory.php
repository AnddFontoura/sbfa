<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Team;
use App\User;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    $userId = Factory(User::class)->create()->id;
    $headers = [
        'headers/1.jpg',
        'headers/2.jpg',
        'headers/3.jpg',
    ];

    $logos = [
      'logos/1.jpg',
      'logos/2.jpeg',
      'logos/3.png',
    ];

    return [
        'owner_id' => $userId,
        'name' => $faker->name(),
        'can_player_join' => rand(0,1),
        'description' => $faker->text(2000),
        'header' => $headers[rand(0,2)],
        'logo' => $logos[rand(0,2)],
    ];
});
