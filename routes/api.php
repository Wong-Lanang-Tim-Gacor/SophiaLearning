<?php

use App\Http\Controllers\Auth\{
    EditProfileController,
    LoginController,
    LogoutController,
    RegisterController
};
use App\Http\Controllers\{
    AnswerController,
    ClassroomController,
    AssignmentChatController,
    MaterialController,
    ResourceController,
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
    Route::get('/profile', [EditProfileController::class, 'showProfile'])->middleware('auth:sanctum');
    Route::post('/profile', [EditProfileController::class, 'updateProfile'])->middleware('auth:sanctum');
});

// Route::apiResource('classrooms', ClassroomController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('classrooms', ClassroomController::class);
    Route::post('/classrooms/{classroomCode}/join', [ClassroomController::class, 'joinClass']);
    Route::post('/classrooms/{classroom_id}/leave', [ClassroomController::class, 'leaveClass']);
    Route::get('/classrooms/user/joined', [ClassroomController::class, 'getJoinedClasses']);

    Route::apiResource('materials', MaterialController::class);

    Route::prefix('resources')->group(function () {
        Route::apiResource('/data', ResourceController::class);
        Route::apiResource('/chat', AssignmentChatController::class)->except(['index', 'show']);
        Route::apiResource('/answer', AnswerController::class);
        Route::apiResource('/announcements', [ResourceController::class, 'getAnnouncements']);
        Route::apiResource('/materials', [ResourceController::class, 'getMaterials']);
        Route::apiResource('/assignments', [ResourceController::class, 'getAssignments']);
        Route::get('/chat/{assignmentId}', [AssignmentChatController::class, 'getChatByAssignmentId']);

        Route::get('/average-point/{id}', [ResourceController::class, 'getAveragePoint']);
        Route::get('/class/{class_id}', [ResourceController::class, 'getResourceByClassId']);
    });
});
