<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;


Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// route untuk halaman dashboard
Route::resource('dashboard', DashboardController::class);

// route untuk halaman transaksi
Route::resource('transactions', TransactionsController::class);
