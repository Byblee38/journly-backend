<?php


use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ReportController;
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

    Route::prefix('reports')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::post('/create', [ReportController::class, 'store']);
            Route::post('/{id}', [ReportController::class, 'show']);
            Route::put('/{id}', [ReportController::class, 'update']);
            Route::delete('/{id}', [ReportController::class, 'destroy']);
        });
    });
});

