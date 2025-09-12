<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Routes للـ Dashboard (CRUD للمنتجات)
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/create', [ProductController::class, 'create'])->name('dashboard.create');
Route::post('/dashboard', [ProductController::class, 'store'])->name('dashboard.store');
Route::get('/dashboard/{id}/edit', [ProductController::class, 'edit'])->name('dashboard.edit');
Route::put('/dashboard/{id}', [ProductController::class, 'update'])->name('dashboard.update');
Route::delete('/dashboard/{id}', [ProductController::class, 'destroy'])->name('dashboard.destroy');

// Routes لصفحة المنتجات (Frontend)
Route::get('/product', [ProductController::class, 'index'])->name('product.index');  // قائمة المنتجات
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');  // منتج فردي
Route::post('/product/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('product.addToCart');
