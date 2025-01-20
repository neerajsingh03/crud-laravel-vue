<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;

Route::post('store',[AuthController::class,'storeUser']);
Route::post('login',[AuthController::class,'login']);
Route::get('edit/{id}',[AuthController::class,'editUser']);
Route::post('update/{id?}',[AuthController::class,'update']);
Route::get('delete/{id}',[AuthController::class,'deleteUser']);
Route::get('/posts',[PostController::class,'fetchPosts']);
// Route::get('/users',[AuthController::class,'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{id}',[AuthController::class,'index']);
    Route::post('/store-post',[PostController::class,'postStore']);
    Route::get('/user-post/{id?}',[PostController::class,'userPosts']);
    // Route::get('/posts',[PostController::class,'fetchPosts']);

});