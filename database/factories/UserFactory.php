<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\Art::class, function (Faker $faker) {
    $title = $faker->word;
    $user = factory(App\User::class)->create();
    $path = storage_path() . '/app/public'  . '/' . preg_replace('/\s+/', '_', $user->name);
    File::makeDirectory($path);
    $image = $faker->image($path, 400, 400);
    
    return [
        'title' => $title,
        'description' => $faker->sentence,
        'src' => 'http://cofi.test/storage' . substr($image, 32),
        'summary' => $faker->text,
        'likes' => 0,
        'owner_id' => $user->id
    ];
});