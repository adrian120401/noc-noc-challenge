<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/health', function () {
    return response()->json(['message' => 'API is running'], 200);
});
