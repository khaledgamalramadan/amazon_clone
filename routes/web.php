<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('product.index');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear-all', [CartController::class, 'clearAll'])->name('cart.clear-all');

Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/create', [ProductController::class, 'create'])->name('dashboard.create');
Route::post('/dashboard', [ProductController::class, 'store'])->name('dashboard.store');
Route::get('/dashboard/{id}/edit', [ProductController::class, 'edit'])->name('dashboard.edit');
Route::put('/dashboard/{id}', [ProductController::class, 'update'])->name('dashboard.update');
Route::delete('/dashboard/{id}', [ProductController::class, 'destroy'])->name('dashboard.destroy');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('product.addToCart');
