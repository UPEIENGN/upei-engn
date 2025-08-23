<?php

use App\Http\Controllers\SocietyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [SocietyController::class, 'show'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', []);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/society_member.php';
