<?php

use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
    RegisterController
};
use App\Http\Controllers\{
    ClassroomController,
    AssignmentController
};

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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('classrooms', ClassroomController::class);

    Route::prefix('assignments')->group(function () {
        Route::apiResource('/data', AssignmentController::class);

        Route::get('/average-point/{id}', [AssignmentController::class, 'getAveragePoint']);
        Route::get('/class/{class_id}', [AssignmentController::class, 'getAssignmentByClassId']);
        Route::get('/topic/{topic_id}', [AssignmentController::class, 'getAssignmentByTopicId']);
//        Route::apiResource('/chat', \App\Models\AssignmentChat::class);
    });
});
