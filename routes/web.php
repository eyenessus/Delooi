<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup',[AuthController::class, 'signup'])->name('signup');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');