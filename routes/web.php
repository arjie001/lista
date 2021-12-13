<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("login");
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::prefix('branches')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branches.index');
        Route::post('/store', [BranchController::class, 'store'])->name('branches.store');
        
        Route::prefix('{branch_code}/transactions')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
            Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
        });
    });

    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallets.index');
        Route::post('/store', [WalletController::class, 'store'])->name('wallets.store');
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('customers.index');
    });
});

