<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Team;
use App\User;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    $userId = Factory(User::class)->create()->id;

    return [
        'owner_id' => $userId, 
        'name' => $faker->name(),
        'description' => $faker->text(2000),
        'banner' => null,
        'logo' => null,
    ];
});
