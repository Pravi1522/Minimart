<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('login', 'login')->name('login');
Route::view('signup', 'signup')->name('signup');

Route::post('authenticate', [UserController::class,'authenticate'])->name('authenticate');
Route::post('create_user', [UserController::class,'createUser'])->name('create_user');

Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [UserController::class,'logout'])->name('logout');
    Route::match(['GET','POST'],'/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('create_payment_intent');
    Route::post('/store_cart', [CheckoutController::class, 'storeCart'])->name('store_cart');
    Route::post('/complete_payment', [CheckoutController::class, 'processCheckout'])->name('complete_payment');
    Route::get('orders', [OrderController::class, 'getOrders'])->name('orders');
});

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

