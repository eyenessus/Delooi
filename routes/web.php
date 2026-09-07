<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup',[AuthController::class, 'signup'])->name('signup');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProdutoController::class, 'index'])->name('dashboard');
    Route::post('/products', [ProdutoController::class, 'store'])->name('products.store');
    Route::post('/cart/{produto}', [ProdutoController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{produto}', [ProdutoController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [ProdutoController::class, 'checkout'])->name('checkout');
});
