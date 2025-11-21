<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Inicio de sesión de usuario
Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('throttle:api');


// rutas protegidas por sanctum
Route::prefix('/user')->middleware('auth:sanctum', 'throttle:api')->group(function () {
    // Obtener información del usuario autenticado
    Route::get('/get-user', [UserController::class, 'getUserOnly']);
    // Obtener todos los usuarios
    Route::get('/users/all', [UserController::class, 'getUsers'])->name('get-users');
    // Crear un nuevo usuario
    Route::post('/create-user', [UserController::class, 'create'])->name('create-user')->middleware('ability:create-user');
    // Cerrar sesión de usuario
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
