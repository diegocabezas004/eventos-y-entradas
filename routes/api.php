<?php

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

// Rutas públicas o para todos los roles autenticados
Route::get('/events', [EventController::class, 'index'])->name('events.index'); // ver todos
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show'); // ver detalles

// Gestión de eventos (Admin de organización y Admin general)
Route::middleware(['auth:sanctum', 'role:1,2'])->group(function () {
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Ejemplo de filtrado por query params: /api/events?category_id=2&start_date=2024-04-01&end_date=2024-04-10
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware(['auth:sanctum', 'role:1'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


// Comprar/ver tickets del usuario autenticado
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])->name('user.tickets');
    Route::get('/my-events', [TicketController::class, 'userEvents'])->name('user.events.purchased');
    Route::post('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');
});


Route::post('/check-in', [TicketController::class, 'checkIn'])->name('tickets.checkin');

