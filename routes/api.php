<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('signup', 'signup');
});

Route::group(['middleware' => [\App\Http\Middleware\VerifyJWTToken::class]], function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

    Route::controller(TaskController::class)->group(function () {
        Route::post('tasks', 'create');
        Route::delete('/tasks/{id}', 'delete');
    });
 });

