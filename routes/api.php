<?php

use App\Http\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/userCheck', [AuthController::class, 'userCheck']);
    Route::post('/userActivate', [AuthController::class, 'userActivate']);
    
    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/createUser', [AuthController::class, 'createUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

