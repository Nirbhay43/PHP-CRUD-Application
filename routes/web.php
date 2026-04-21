<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\subcategorycontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\productcontroller;
use App\Http\Controllers\SendMailController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('Home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::patch('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/subcategory', [subcategorycontroller::class, 'index'])->name('subcategory.index');
    Route::post('/subcategory/store', [subcategorycontroller::class, 'store'])->name('subcategory.store');
    Route::patch('/subcategory/{id}/edit', [subcategorycontroller::class, 'edit'])->name('subcategory.edit');
    Route::put('/subcategory/{id}/update', [subcategorycontroller::class, 'update'])->name('subcategory.update');
    Route::delete('/subcategory/{id}/delete', [subcategorycontroller::class, 'destroy'])->name('subcategory.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/product', [productcontroller::class, 'index'])->name('product.index');
    Route::post('/product/store', [productcontroller::class, 'store'])->name('product.store');
    Route::patch('/product/{id}/edit', [productcontroller::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [productcontroller::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [productcontroller::class, 'destroy'])->name('product.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/payment/success', function () {
        return view('payment-success');
    })->name('payment.success');

    Route::get('/payment/cancel', function () {
        return view('payment-cancel');
    })->name('payment.cancel');

    Route::get('/payment', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');

    Route::get('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscribe.index');
    Route::get('/subscribe/checkout', [\App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('subscribe.checkout');
    Route::get('/billing-portal', [\App\Http\Controllers\SubscriptionController::class, 'billingPortal'])->name('billing-portal');
});


Route::get('/send-mail', [SendMailController::class, 'index'])->name('send.mail');

require __DIR__.'/auth.php';
