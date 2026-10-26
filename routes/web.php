<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/clients');

Route::resource('clients', ClientController::class);
Route::resource('services', ServiceController::class);
Route::resource('invoices', InvoiceController::class);