<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\SocietyMember\ExecutiveMemberController;
use App\Http\Controllers\SocietyMember\SocietyMemberController;
use App\Http\Controllers\SocietyMember\SocietyMemberRenewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SocietyController::class, 'home'])->name('home');
Route::get('/about', [SocietyController::class, 'about'])->name('about');
Route::get('/events', [SocietyController::class, 'events'])->name('events');
Route::get('/store', [SocietyController::class, 'store'])->name('store');
Route::get('/products/{product}', [SocietyController::class, 'showProduct'])->name('products.show');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');

Route::permanentRedirect('/admin', '/admin/dashboard');

Route::middleware('verified')
    ->middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::resource('societies', SocietyController::class)
            ->only(['edit', 'update']);

        Route::resource('societies.events', EventController::class)
            ->except(['show']);

        Route::resource('societies.products', ProductController::class)
            ->except(['show']);

        Route::resource('societies.society-members', SocietyMemberController::class)
            ->except(['show']);

        Route::patch('/societies/{society}/society-members/{society_member}/renew', SocietyMemberRenewController::class)
            ->name('societies.society-members.renew');

        Route::patch('/societies/{society}/executive-members/reorder', ExecutiveMemberController::class)
            ->name('societies.executive-members.reorder');

    });

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
