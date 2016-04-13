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

$factory->define(Grimm\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'api_only' => true
    ];
});

$factory->define(Grimm\Person::class, function (Faker\Generator $faker) {

    $birthDate = \Carbon\Carbon::now()->subYears($faker->randomNumber(3));

    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'birth_date' => $birthDate->format('Y'),
        'death_date' => $birthDate->addYears($faker->randomNumber(2))->format('Y'),
        'is_organization' => $faker->boolean(20),
    ];
});

$factory->define(Grimm\Book::class, function (Faker\Generator $faker) {

    if ($faker->boolean(80)) {
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

$factory->define(Grimm\PersonCode::class, function (Faker\Generator $faker) {

    return [
        'error_generated' => $faker->boolean(20),
        'internal' => $faker->boolean(20),
        'name' => str_slug($faker->sentence(3)),
    ];
});

$factory->define(Grimm\PersonInformation::class, function (Faker\Generator $faker) {

    $code = Grimm\PersonCode::orderByRaw('RAND()')->first();

    $person = Grimm\Person::orderByRaw('RAND()')->first();

    if (!$code || !$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_code_id' => $code->id,
        'person_id' => $person->id,
        'data' => $faker->paragraph,
    ];
});

$factory->define(Grimm\PersonPrint::class, function (Faker\Generator $faker) {

    $person = Grimm\Person::orderByRaw('RAND()')->first();

    if (!$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_id' => $person->id,
        'entry' => $faker->paragraph,
        'year'  => rand(12000, 20000)/10
    ];
});

$factory->define(Grimm\PersonInheritance::class, function (Faker\Generator $faker) {

    $person = Grimm\Person::orderByRaw('RAND()')->first();

    if (!$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_id' => $person->id,
        'entry' => $faker->paragraph,
    ];
});

$factory->define(Grimm\BookPersonAssociation::class, function (Faker\Generator $faker) {

    $book = Grimm\Book::orderByRaw('RAND()')->first();

    $person = Grimm\Person::orderByRaw('RAND()')->first();

    if (!$book || !$person) {
        throw new \Exception('no book or person found for association');
    }

    $page = rand(1, 999);
    $page_to = rand($page, $page + 25);

    return [
        'book_id' => $book->id,
        'person_id' => $person->id,
        'page' => $page,
        'page_to' => $page_to,
        'page_description' => $faker->paragraph,
        'line' => rand(1, 50),
    ];
});
