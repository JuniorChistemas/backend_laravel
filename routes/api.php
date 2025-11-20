<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/create-user', [UserController::class, 'create'])->name('create-user')->middleware('create-user');


Route::post('/login', [UserController::class, 'login'])->name('login');