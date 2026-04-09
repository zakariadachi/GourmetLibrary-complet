<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookCopyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// CSRF protection is not applicable to API routes.
// These routes use Sanctum Bearer token authentication, not cookie-based sessions.
// Laravel excludes api.php from CSRF middleware by default.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Categories (public)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Books (public)
Route::get('/books', [BookController::class, 'index']);
Route::get('/categories/{category}/books', [BookController::class, 'byCategory']);
Route::get('/categories/{category}/books/{book}', [BookController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        Route::post('/categories/{category}/books', [BookController::class, 'store']);
        Route::put('/categories/{category}/books/{book}', [BookController::class, 'update']);
        Route::delete('/categories/{category}/books/{book}', [BookController::class, 'destroy']);

        Route::get('/books/{book}/copies', [BookCopyController::class, 'index']);
        Route::get('/books/{book}/copies/{copy}', [BookCopyController::class, 'show']);
        Route::post('/books/{book}/copies', [BookCopyController::class, 'store']);
        Route::put('/books/{book}/copies/{copy}', [BookCopyController::class, 'update']);
        Route::delete('/books/{book}/copies/{copy}', [BookCopyController::class, 'destroy']);

        Route::get('/stats', [StatController::class, 'index']);
    });
});