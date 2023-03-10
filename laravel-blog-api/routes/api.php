<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ProfileController;
use App\Http\Controllers\API\Admin\PostController as AdminPostController;
use App\Http\Controllers\API\Admin\CategoryController as AdminCategoryController;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::get('/profile', [ProfileController::class, 'index']);
    });
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // 

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::apiResource('/posts', AdminPostController::class)->except('destroy');
        Route::apiResource('/categories', AdminCategoryController::class)->except('destroy');
    });
});
