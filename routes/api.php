<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EnpointContactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Inicio de sesión de usuario
Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('throttle:api');
// Crear un nuevo usuario
Route::post('/create-user', [UserController::class, 'create'])->name('create-user')->middleware('throttle:api');

// rutas protegidas por sanctum
Route::prefix('/user')->middleware('auth:sanctum', 'throttle:api')->group(function () {
    // Obtener información del usuario autenticado
    Route::get('/get-user', [UserController::class, 'getUserOnly']);
    // Obtener todos los usuarios
    Route::get('/users/all', [UserController::class, 'getUsers'])->name('get-users')->middleware('ability:create-user');
    // Cerrar sesión de usuario
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});


Route::resource('/customers', CustomerController::class)->except(['create', 'edit'])->middleware('auth:sanctum', 'throttle:api');


// Ruta para el endpoint de contacto
Route::post('/contact', EnpointContactController::class)->name('contact')->middleware('throttle:api');