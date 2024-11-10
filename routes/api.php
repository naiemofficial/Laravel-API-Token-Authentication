<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;

Route::get('/user', UserController::class)->middleware('auth:sanctum');
Route::get('/dashboard', DashboardController::class)->middleware(['auth:sanctum', 'verified']);