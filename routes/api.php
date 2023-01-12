<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::get('recipe', [RecipeController::class, 'index']);
Route::get('recipe/{id}', [RecipeController::class, 'show']);

Route::get('store', [StoreController::class, 'index']);
Route::get('store/{id}', [StoreController::class, 'show']);

Route::get('product', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show']);

Route::get('topics', [TopicController::class, 'index']);
Route::get('topics/{id}', [TopicController::class, 'show']);

//!! PRIVATE ROUTE
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('upgrade/{id}', [UserController::class, 'upgradeToPremium']);
    Route::resource('recipe', RecipeController::class)->except([
        'index', 'show'
    ]);
    Route::resource('store', StoreController::class)->except([
        'index', 'show'
    ]);
    Route::resource('product', ProductController::class)->except([
        'index', 'show'
    ]);
    Route::resource('topics', TopicController::class)->except([
        'index', 'show'
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
