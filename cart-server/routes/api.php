<?php
use App\Models\Category;

Route::get('/', function () {
    return Category::parents()->ordered()->get();
});
