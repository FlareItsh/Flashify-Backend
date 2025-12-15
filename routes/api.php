<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FlashcardController;
use Illuminate\Http\Request;

// Public routes - registration and login
Route::post('register', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    // User routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::patch('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::get('users/username/{username}', [UserController::class, 'getByUsername']);
    Route::post('users/email', [UserController::class, 'getByEmail']);

    // Collection routes
    Route::get('collections', [CollectionController::class, 'index']);
    Route::post('collections', [CollectionController::class, 'store']);
    Route::get('collections/{id}', [CollectionController::class, 'show']);
    Route::put('collections/{id}', [CollectionController::class, 'update']);
    Route::patch('collections/{id}', [CollectionController::class, 'update']);
    Route::delete('collections/{id}', [CollectionController::class, 'destroy']);

    // Flashcard routes (nested under collections)
    Route::get('collections/{collectionId}/flashcards', [FlashcardController::class, 'index']);
    Route::post('collections/{collectionId}/flashcards', [FlashcardController::class, 'store']);
    Route::get('collections/{collectionId}/flashcards/{id}', [FlashcardController::class, 'show']);
    Route::put('collections/{collectionId}/flashcards/{id}', [FlashcardController::class, 'update']);
    Route::patch('collections/{collectionId}/flashcards/{id}', [FlashcardController::class, 'update']);
    Route::delete('collections/{collectionId}/flashcards/{id}', [FlashcardController::class, 'destroy']);
});
