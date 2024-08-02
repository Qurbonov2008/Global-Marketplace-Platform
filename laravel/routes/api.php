<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('user/all', [UserController::class, 'index']);
    Route::get('one/user', [UserController::class, 'show']);
    Route::put('user/update/{id}', [UserController::class, 'edit']);
});
