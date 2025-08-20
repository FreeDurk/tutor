<?php

use App\Http\ApiResponse\ApiResponse;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', LoginController::class);
    Route::post('register', RegisterController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', LogoutController::class);
});

Route::apiResource('tasks', TaskController::class)->middleware(['auth:sanctum']);
