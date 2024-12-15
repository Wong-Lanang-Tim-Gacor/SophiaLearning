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
    Route::get('/classrooms/filter/is-archived', [ClassroomController::class, 'getArchivedClasses']);
    Route::get('/classrooms/user/joined', [ClassroomController::class, 'getJoinedClasses']);

    Route::apiResource('materials', MaterialController::class);

    Route::prefix('resources')->group(function () {
        Route::apiResource('/data', ResourceController::class);
        Route::post('/chat',[\App\Http\Controllers\ChatController::class,'store']);
        Route::get('/chat/{resourceid}', [\App\Http\Controllers\ChatController::class, 'getChatByResource']);
        Route::apiResource('/answer', AnswerController::class);
        Route::get('/announcements/{id}', [ResourceController::class, 'getAnnouncements']);
        Route::get('/materials/{id}', [ResourceController::class, 'getMaterials']);
        Route::get('/assignments/{id}', [ResourceController::class, 'getAssignments']);
        Route::get('/assignments/calendar/user', [ResourceController::class, 'getAssignmentsCalendar']);
    
        Route::get('/average-point/{id}', [ResourceController::class, 'getAveragePoint']);
        Route::get('/class/{class_id}', [ResourceController::class, 'getResourceByClassId']);
    });
});
