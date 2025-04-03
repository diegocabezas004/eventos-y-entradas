<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::middleware(['auth:sanctum', 'role:1'])->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/events', [EventController::class, 'index'])->name('events.index'); // ver todos
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show'); // ver detalles

Route::middleware(['auth:sanctum', 'role:1,2'])->group(function () {
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});

Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware(['auth:sanctum', 'role:1'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])->name('user.tickets');
    Route::get('/my-events', [TicketController::class, 'userEvents'])->name('user.events.purchased');
    Route::post('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');
});


Route::post('/check-in', [TicketController::class, 'checkIn'])->name('tickets.checkin');

