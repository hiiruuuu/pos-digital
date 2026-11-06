<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// otomatis mengarahkan ke halaman dashboard saat mengakses root URL
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
use App\Http\Controllers\Api\OrderController as ApiOrderController;

Route::get('/pos', [DashboardController::class, 'pos'])->name('pos.index');
Route::post('/pos/store', [ApiOrderController::class, 'store'])->name('pos.store');