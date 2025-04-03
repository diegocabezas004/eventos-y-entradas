<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

Route::prefix('v1')->group(function () {

    // Authentication routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');

    // Event routes
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store'])
        ->middleware('auth:sanctum');
    Route::put('/events/{id}', [EventController::class, 'update'])
        ->middleware('auth:sanctum');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])
        ->middleware('auth:sanctum');

    // Event category routes
    Route::get('/categories', [EventCategoryController::class, 'index']);
    Route::post('/categories', [EventCategoryController::class, 'store'])
        ->middleware('auth:sanctum');
    Route::put('/categories/{id}', [EventCategoryController::class, 'update'])
        ->middleware('auth:sanctum');
    Route::delete('/categories/{id}', [EventCategoryController::class, 'destroy'])
        ->middleware('auth:sanctum');

    // Ticket routes
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])
        ->middleware('auth:sanctum');
    Route::get('/my-events', [TicketController::class, 'userEvents'])
        ->middleware('auth:sanctum');
    Route::post('/tickets/buy', [TicketController::class, 'buy'])
        ->middleware('auth:sanctum');
    Route::post('/check-in', [TicketController::class, 'checkIn']);

    // User routes
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('auth:sanctum');
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('auth:sanctum');
    Route::put('/users/{id}', [UserController::class, 'update'])
        ->middleware('auth:sanctum');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->middleware('auth:sanctum');
});


