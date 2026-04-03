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

Route::post('/users', [UserController::class, 'store']);

Route::get('/users/{user}', [UserController::class, 'show']);

Route::put('/users/{user}', [UserController::class, 'update']);

Route::put('/users/{user}/password', [UserController::class, 'editPass']);

Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Retorna todos os veiculos
Route::get('/veiculos', [VeiculoController::class, 'index']);

Route::post('/veiculos', [VeiculoController::class, 'store']);

Route::get('/veiculos/{veiculo}', [VeiculoController::class, 'show']);

Route::put('/veiculos/{veiculo}', [VeiculoController::class, 'update']);

Route::delete('/veiculos/{veiculo}', [VeiculoController::class, 'destroy']);