<?php

use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'quantity' => rand(20, 100)
    ];
});
