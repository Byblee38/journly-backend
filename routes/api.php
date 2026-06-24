<?php


use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ReportController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/user-check', [AuthController::class, 'userCheck']);
    Route::post('/users/activate', [AuthController::class, 'activateUser']);

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/users', [AuthController::class, 'createUser']);
            Route::get('/me', [AuthController::class, 'me']);
        });
    });

    Route::prefix('user')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
        });
        Route::get('/teachers', [UserController::class, 'getTeachers']);
        Route::get('/students', [UserController::class, 'getStudents']);
    });

    Route::prefix('report')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [ReportController::class, 'index']); //Read
            Route::post('/create', [ReportController::class, 'store']); //Create
            Route::put('/update/{id}', [ReportController::class, 'update']); //update
            Route::delete('/delete/{id}', [ReportController::class, 'destroy']); //Delete
        });
    });
});
