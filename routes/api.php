<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

    Route::get('/events', [EventController::class, 'index'])->name('api.events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('api.events.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events', [EventController::class, 'store'])->name('api.events.store');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('api.events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('api.events.destroy');
    });

    Route::get('/categories', [EventCategoryController::class, 'index'])->name('api.categories.index');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/categories', [EventCategoryController::class, 'store'])->name('api.categories.store');
        Route::put('/categories/{id}', [EventCategoryController::class, 'update'])->name('api.categories.update');
        Route::delete('/categories/{id}', [EventCategoryController::class, 'destroy'])->name('api.categories.destroy');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/users', [UserController::class, 'store'])->name('api.users.store');
        Route::get('/users', [UserController::class, 'index'])->name('api.users.index');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('api.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('api.users.destroy');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/tickets/buy', [TicketController::class, 'buy'])->name('api.tickets.buy');
        Route::get('/my-tickets', [TicketController::class, 'userTickets'])->name('api.user.tickets');
        Route::get('/my-events', [TicketController::class, 'userEvents'])->name('api.user.events');
    });

    Route::middleware('auth:sanctum')->get('/user/events/purchased', [UserController::class, 'purchasedEvents'])->name('user.events.purchased');

    Route::post('/check-in', [TicketController::class, 'checkIn'])->name('api.tickets.checkin');

    Route::post('/tickets', [TicketController::class, 'store']); // opcional
});
