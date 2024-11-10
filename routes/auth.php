<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\PasswordResetController;

Route::post('register', RegisterController::class)->middleware('guest');
Route::post('login', LoginController::class)->middleware('guest');
Route::get('logout', LogoutController::class)->middleware('auth:sanctum');
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->middleware(['guest', 'signed'])->name('password.reset');