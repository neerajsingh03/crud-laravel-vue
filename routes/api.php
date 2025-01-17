<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('store',[AuthController::class,'storeUser']);
Route::post('login',[AuthController::class,'login']);
Route::get('users',[AuthController::class,'index']);
Route::get('edit/{id}',[AuthController::class,'editUser']);
Route::post('update/{id?}',[AuthController::class,'update']);
Route::get('delete/{id}',[AuthController::class,'deleteUser']);
// Route::post('/logout',[AuthController::class,'logout']);
Route::post('store-post',[AuthController::class,'postStore']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
