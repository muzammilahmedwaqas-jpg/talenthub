<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/clients');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('clients', ClientController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('invoices', InvoiceController::class);

    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store'])
    ->name('invoices.payments.store');

    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])
    ->name('invoices.pdf');

});