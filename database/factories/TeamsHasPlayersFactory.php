<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GamePosition;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $teamId = Factory(Team::class)->create()->id;
    $userId = Factory(User::class)->create()->id;
    $positionId = GamePosition::inRandomOrder()->first()->id;

    return [
        'team_id' => $teamId,
        'user_id' => $userId,
        'position_id' => $positionId,
        'name' => $faker->name(),
        'nickname' => null,
        'number' => rand(1,99),
    ];
});
