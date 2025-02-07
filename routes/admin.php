

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AdminController::class, 'index'])->name('login');
    Route::post('authenticate', [AdminController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class,'index'])->name('products');
        Route::get('create', [ProductController::class,'create'])->name('products.create');
        Route::post('/', [ProductController::class,'store'])->name('products.store');
        Route::get('{id}/edit', [ProductController::class,'edit'])->name('products.edit');
        Route::match(['PUT','PATCH'],'{id}', [ProductController::class,'update'])->name('products.update');
        Route::delete('{id}', [ProductController::class,'destroy'])->name('products.delete');
    });
});
