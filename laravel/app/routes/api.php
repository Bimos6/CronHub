<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ExecutionController;


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::get('/jobs/due', [JobController::class, 'dueJobs']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('jobs', JobController::class);

    Route::post('/executions', [ExecutionController::class, 'store']);
});
