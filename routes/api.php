<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/api/auth/logout', [AuthController::class,'logout']);
Route::post('/api/auth/refresh', [AuthController::class,'refresh']);
