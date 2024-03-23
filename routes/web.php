<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/api/health', function () {
    return response()->json(['message' => 'API is running'], 200);
});
Route::post('/api/auth/signup', [AuthController::class, 'signup']);
Route::post('/api/auth/login', [AuthController::class, 'login']);
