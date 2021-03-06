<?php

use Faker\Generator as Faker;
use App\Models\ProductVariationType;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->word . ' ' . $faker->word,
        'slug' => str_slug($name),
    ];
});

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->word . ' ' . $faker->word,
        'slug' => str_slug($name),
        'price' => $faker->numberBetween(100, 6000),
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Models\ProductVariation::class, function (Faker $faker) {
    return [
        // 'product_id' => function () {
        //     return factory('App\Models\Product')->create()->id;
        // },
        'name' => $faker->word,
        // 'product_variation_type_id' =>  factory(ProductVariationType::class)->create()->id
    ];
});

$factory->define(App\Models\ProductVariationType::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Models\Stock::class, function (Faker $faker) {
    return [
        'quantity' => 1
    ];
});
