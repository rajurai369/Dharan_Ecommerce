<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('/category',CategoryController::class);
Route::apiResource('/product',ProductController::class);
// Auth section
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
// End of auth section


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart', [CartController::class, 'addItem']);
    Route::get('/cart', [CartController::class, 'viewCart']);
});

Route::get('api','');
