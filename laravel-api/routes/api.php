<?php

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
Route::get('/users', function () {
    return \App\Models\User::get();
});