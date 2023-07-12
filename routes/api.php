<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;


Route::post('/login' , [AuthController::class , 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::apiResource('users' , UserController::class);

