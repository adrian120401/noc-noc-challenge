<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskAttachmentController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('signup', 'signup');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

    Route::controller(TaskController::class)->group(function () {
        Route::get('tasks', 'getAll');
        Route::post('tasks', 'create');
        Route::delete('tasks/{id}', 'delete');
        Route::patch('tasks/{id}/user', 'updateUser');
        Route::patch('tasks/{id}/status', 'updateStatus');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/task/{id}/comments', 'create');
    });


    Route::controller(TaskAttachmentController::class)->group(function () {
        Route::post('/task/{id}/file', 'create');
        Route::delete('/file/{id}', 'delete');
    });

 });

