<?php

use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
    RegisterController
};
use App\Http\Controllers\{
    ClassroomController,
    AssignmentController,
    AssignmentChatController,
    TopicController
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

Route::apiResource('classrooms', ClassroomController::class);
Route::apiResource('topics', TopicController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResource('classrooms', ClassroomController::class);

    Route::prefix('assignments')->group(function () {
        Route::apiResource('/data', AssignmentController::class);
        Route::apiResource('/chat', AssignmentChatController::class)->except(['index','show']);
        Route::get('/chat/{assignmentId}', [AssignmentChatController::class, 'getChatByAssignmentId']);

        Route::get('/average-point/{id}', [AssignmentController::class, 'getAveragePoint']);
        Route::get('/class/{class_id}', [AssignmentController::class, 'getAssignmentByClassId']);
        Route::get('/topic/{topic_id}', [AssignmentController::class, 'getAssignmentByTopicId']);

    });
});
