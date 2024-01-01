<?php


// Route::get('/ping', function () {
//     return response()->json(['message' => 'pong']);
// });

Route::get('categories', 'Categories\CategoryController@index');
Route::resource('products', 'Products\ProductController');


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'Auth\RegisterController');
    Route::post('/login', 'Auth\LoginController');
    Route::get('/me', 'Auth\MeController');
});

Route::post('cart', 'Cart\CartController@store');
Route::patch('cart/{productVariation}', 'Cart\CartController@update');
Route::delete('cart/{productVariation}', 'Cart\CartController@destroy');
