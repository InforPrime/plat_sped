<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\AuthController;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'clientes' => Cliente::all()
    ]);
})->middleware('auth:sanctum');

Route::post('/login', AuthController::class);

Route::controller(ArquivoController::class)
    ->group(function () {
        Route::post('/arquivo-upload', 'store')
        ->middleware('auth:sanctum');
    });
