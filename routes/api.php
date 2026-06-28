<?php

use App\Http\Controllers\api\v1\ActivateController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ReportController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/user-check', [ActivateController::class, 'checkAccount']);
    Route::post('/users/activate', [ActivateController::class, 'activateAccount']);
    Route::post('user/create-mentor-account', [UserController::class,'createMentorAccount']);


    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::prefix('user')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::middleware('role:administrator')->group(function () {
                Route::get('/create-mentor-token', [UserController::class, 'createMentorToken']);    
                Route::post('/create-user', [UserController::class, 'createUser']);
            });
            Route::get('/me', [AuthController::class, 'me']);
            Route::get('/teachers', [UserController::class, 'getTeachers']);
            Route::get('/students', [UserController::class, 'getStudents']);
        });
    });

    Route::prefix('report')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::post('/create', [ReportController::class, 'store']);
            Route::put('/update/{id}', [ReportController::class, 'update']);
            Route::delete('/delete/{id}', [ReportController::class, 'destroy']);
        });
    });
});
