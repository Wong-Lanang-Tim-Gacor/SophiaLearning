<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClassroomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'handle']);
    Route::post('/register', [RegisterController::class, 'handle']);
    Route::post('/logout', [LogoutController::class, 'handle'])->middleware('auth:sanctum');
});


Route::apiResource('classrooms', ClassroomController::class)->middleware('auth:sanctum');
