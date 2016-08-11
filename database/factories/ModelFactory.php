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

use App\Core\Authorization\Permission\Permission;
use App\Core\Authorization\Role\Role;
use App\User;
use Faker\Generator;


$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'account' => $faker->userName,
        'email' => $faker->safeEmail,
        'openid' => $faker->sha1,
        'unionid' => $faker->optional()->sha1,
        'password' => bcrypt(str_random(10)),
        'api_token' => str_random(32),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Role::class, function(Generator $faker) {
    return [
        'name' => $faker->unique()->sentence(2),
        'label' => $faker->sentence,
    ];
});

$factory->define(Permission::class, function(Generator $faker) {
    return [
        'name' => $faker->unique()->sentence(2),
        'label' => $faker->sentence,
    ];
});
