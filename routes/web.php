<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DownlineController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::get('/contact-us', [DashboardController::class, 'contact'])->name('contact-us');
    Route::get('deposit', [DepositController::class, 'index'])->name('deposit');
    Route::post('deposit', [DepositController::class, 'store'])->name('deposit.store');
    Route::get('cashout', [CashoutController::class, 'index'])->name('cashout');
    Route::post('cashout', [CashoutController::class, 'store'])->name('cashout.store');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('downlines', [DownlineController::class, 'index'])->name('downlines');
    Route::get('plan', [InvestmentController::class, 'index'])->name('plan');
    Route::post('plan', [InvestmentController::class, 'store'])->name('plan.store');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('grant', [GrantController::class, 'index'])->name('grant');
    Route::post('grant', [GrantController::class, 'store'])->name('grant.store');
    Route::get('release', [RentController::class, 'index'])->name('release');
    Route::post('release', [RentController::class, 'store'])->name('release.store');
    Route::get('task', [TaskController::class, 'index'])->name('task');
    Route::post('dailyTask', [TaskController::class, 'dailyTask'])->name('dailyTask');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    });
});

require __DIR__.'/auth.php';
