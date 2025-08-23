<?php


use App\Http\Controllers\SocietyMemberController;
use Illuminate\Support\Facades\Route;

Route::resource('society-member', SocietyMemberController::class);
