<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Team;
use App\User;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    $userId = Factory(User::class)->create()->id;
    $headers = [
        'headers/gremio_torcida.jpg',
        'headers/torcida_generica.jpg',
        'headers/torcida_generica_2.jpg',
    ];

    $logos = [
      'logos/lion.jpg',
      'logos/eagle.jpeg',
      'logos/random.png',
    ];

    return [
        'owner_id' => $userId,
        'name' => $faker->name(),
        'description' => $faker->text(2000),
        'header' => $headers[rand(0,2)],
        'logo' => $logos[rand(0,2)],
    ];
});
