<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence(5),
        'notes' => $faker->sentence(5),
        'owner_id' => function(){
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});
