<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Person::class, function (Faker\Generator $faker) {
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'birth_date' => $faker->date('Y-m-d'),
        'death_date' => $faker->date('Y-m-d'),
        'is_organization' => $faker->boolean(20),
    ];
});
