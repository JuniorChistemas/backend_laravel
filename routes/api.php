<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Inicio de sesión de usuario
Route::post('/login', [UserController::class, 'login'])->name('login');

// Obtener información del usuario autenticado
Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');

// Obtener todos los usuarios
Route::get('/users/all', [UserController::class, 'getUsers'])->name('get-users');

// Crear un nuevo usuario
Route::post('/create-user', [UserController::class, 'create'])->name('create-user')->middleware([
    'auth:sanctum',
    'ability:create-user'
]);