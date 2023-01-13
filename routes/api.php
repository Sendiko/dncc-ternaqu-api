<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//!! PUBLIC ROUTE
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::get('recipe', 'RecipeController@index');
Route::get('recipe/{id}', 'RecipeController@show');

Route::get('store', 'StoreController@index');
Route::get('store/{id}', 'StoreController@show');

Route::get('product', 'ProductController@index');
Route::get('product/{id}', 'ProductController@show');

Route::get('topics', 'TopicController@index');
Route::get('topics/{id}', 'TopicController@show');

Route::get('image/{path}', 'ImageController@show')->name('image.show')->where('path', '.*');

//!! PRIVATE ROUTE
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', 'UserController@index');
    Route::post('logout', 'UserController@logout');
    Route::get('upgrade/{id}', 'PremiumController@update');

    Route::resources([
        'recipe' => 'RecipeController',
        'store' => 'StoreController',
        'product' => 'ProductController',
        'topics' => 'TopicController'
    ], ['except' => ['index', 'show']]);
});
