<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

Route::prefix('v1')->group(function () {

    // Authentication routes
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum')
        ->name('api.logout');

    // Event routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events', [EventController::class, 'store'])
        ->middleware('auth:sanctum')
        ->name('events.store');
    Route::put('/events/{id}', [EventController::class, 'update'])
        ->middleware('auth:sanctum')
        ->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('events.destroy');

    // Event category routes
    Route::get('/categories', [EventCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [EventCategoryController::class, 'store'])
        ->middleware('auth:sanctum')
        ->name('categories.store');
    Route::put('/categories/{id}', [EventCategoryController::class, 'update'])
        ->middleware('auth:sanctum')
        ->name('categories.update');
    Route::delete('/categories/{id}', [EventCategoryController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('categories.destroy');

    // Ticket routes
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])
        ->middleware('auth:sanctum')
        ->name('tickets.userTickets');
    Route::get('/my-events', [TicketController::class, 'userEvents'])
        ->middleware('auth:sanctum')
        ->name('tickets.userEvents');
    Route::post('/tickets/buy', [TicketController::class, 'buy'])
        ->middleware('auth:sanctum')
        ->name('tickets.buy');
    Route::post('/check-in', [TicketController::class, 'checkIn'])->name('tickets.checkIn');

    // User routes
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('auth:sanctum')
        ->name('users.store');
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('auth:sanctum')
        ->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])
        ->middleware('auth:sanctum')
        ->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('users.destroy');
});