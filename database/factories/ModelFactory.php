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
        'api_token' =>  str_random(60),
        'api_only'  =>  true
    ];
});

$factory->define(App\Person::class, function (Faker\Generator $faker) {

    $birthDate = \Carbon\Carbon::now()->subYears($faker->randomNumber(3));

    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'birth_date' => $birthDate,
        'death_date' => $birthDate->addYears($faker->randomNumber(2)),
        'is_organization' => $faker->boolean(20),
    ];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {

    if($faker->boolean(80)) {
        $v = rand(1, 7);
        $v_i = null;
    } else {
        $v = null;
        $v_i = rand(1, 7);
    }

    $title = $faker->sentence(4);

    return [
        'title' => $title,
        'short_title' => str_slug($title),
        'volume' => $v,
        'volume_irregular' => $v_i,
        'edition' => $faker->boolean(20),
        'year' => rand(1500, 2000),
    ];
});
