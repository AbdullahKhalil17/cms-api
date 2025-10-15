<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CommetsController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
  });
