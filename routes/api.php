<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('store',[UserController::class,'storeUser']);
Route::get('users',[UserController::class,'index']);
Route::get('edit/{id}',[UserController::class,'editUser']);
Route::post('update/{id}',[UserController::class,'update']);
Route::get('delete/{id}',[UserController::class,'deleteUser']);