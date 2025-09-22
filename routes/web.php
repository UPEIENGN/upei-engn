<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\SocietyMemberController;
use Illuminate\Support\Facades\Route;

Route::get('', [SocietyController::class, 'home'])->name('home');
Route::get('about', [SocietyController::class, 'about'])->name('about');
Route::get('events', [SocietyController::class, 'events'])->name('events');

Route::middleware('verified')
    ->middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('societies', SocietyController::class)->only(['edit', 'update']);
        Route::resource('societies.society-members', SocietyMemberController::class);
        Route::resource('societies.events', EventController::class);
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
