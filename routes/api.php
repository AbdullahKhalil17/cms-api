<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CommetsController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
  Route::group(['middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
  });

  Route::middleware('jwt.auth')->group(function () {
    Route::prefix('category')->group(function () {
      Route::get('/', [CategoriesController::class, 'index']);
      Route::post('store', [CategoriesController::class, 'store']);
      Route::put('edit/{id}', [CategoriesController::class, 'update']);
      Route::delete('delete/{id}', [CategoriesController::class, 'destory']);
    });
    Route::prefix('news')->group(function () {
      Route::get('/', [NewsController::class, 'index']);
      Route::post('store', [NewsController::class, 'store']);
      Route::put('/update/{id}', [NewsController::class, 'update']);
      Route::delete('/delete/{id}', [NewsController::class, 'destroy']);
      Route::get('all-news', [NewsController::class, 'news']);
    });
    Route::prefix('comment')->group(function () {
      Route::post('store', [CommetsController::class, 'store']);
      Route::put('update/{id}', [CommetsController::class, 'update']);
      Route::delete('delete/{id}', [CommetsController::class, 'destroy']);
    });
  });
