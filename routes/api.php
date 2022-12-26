<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('admin/register', [AdminController::class, 'register']);
Route::post('admin/login', [AdminController::class, 'login']);

//!! PRIVATE ROUTE
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('admin/logout', [AdminController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
