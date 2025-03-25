<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', AuthController::class);

Route::controller(ArquivoController::class)
->group(function() {
    Route::post('/arquivo', 'store');
});
