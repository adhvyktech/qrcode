<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DynamicQRCodeController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index']);
Route::post('/generate-static-qr', [HomeController::class, 'generateStaticQR']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dynamic-qr-codes/create', [DynamicQRCodeController::class, 'create'])->name('dynamic.create');
    Route::post('/dynamic-qr-codes', [DynamicQRCodeController::class, 'store'])->name('dynamic.store');
    Route::get('/dynamic-qr-codes/{dynamicQRCode}/edit', [DynamicQRCodeController::class, 'edit'])->name('dynamic.edit');
    Route::put('/dynamic-qr-codes/{dynamicQRCode}', [DynamicQRCodeController::class, 'update'])->name('dynamic.update');
    Route::delete('/dynamic-qr-codes/{dynamicQRCode}', [DynamicQRCodeController::class, 'destroy'])->name('dynamic.destroy');
});

Route::get('/qr/{key}', [DynamicQRCodeController::class, 'redirect'])->name('dynamic.redirect');

Auth::routes();