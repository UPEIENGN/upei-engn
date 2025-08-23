<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocietyController;
use Illuminate\Support\Facades\Route;

Route::get('', [SocietyController::class, 'home'])->name('home');
Route::get('about', [SocietyController::class, 'about'])->name('about');
Route::get('events', [SocietyController::class, 'events'])->name('events');

Route::middleware('auth')
    ->middleware('verified')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/society_member.php';
