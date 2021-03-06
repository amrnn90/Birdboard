<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->sentence(8),
        'notes' => $faker->sentence(8),
        'owner_id' => function() {
            return factory('App\User')->create()->id;
        }
    ];
});
