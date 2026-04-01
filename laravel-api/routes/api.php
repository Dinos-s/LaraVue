<?php

use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Veiculos\VeiculoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota com autenticação
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rota sem autenticação
// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

// Retorna todos os usuários
Route::get('/users', [UserController::class, 'index']);


// Retorna todos os veiculos
Route::get('/veiculos', [VeiculoController::class, 'index']);