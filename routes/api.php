<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Card routes
    Route::apiResource('cards', CardController::class);
    Route::get('/cards/{card}/stats', [CardController::class, 'stats']);
    Route::post('/cards/{card}/share', [CardController::class, 'share']);
    
    // User profile routes
    Route::put('/profile', [UserController::class, 'update']);
    Route::post('/profile/photo', [UserController::class, 'updatePhoto']);
    Route::put('/profile/password', [UserController::class, 'updatePassword']);
});

// Public card view route
Route::get('/cards/{card}/view', [CardController::class, 'view']);