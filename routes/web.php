<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BranchTransactionController;
use App\Http\Controllers\WalletTransactionController;
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
            Route::get('/', [BranchTransactionController::class, 'index'])->name('branch.transactions.index');
            Route::post('/store', [BranchTransactionController::class, 'store'])->name('branch.transactions.store');
            Route::post('/update/{id}', [BranchTransactionController::class, 'update'])->name('branch.transactions.update');
        });
    });

    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallets.index');
        Route::post('/store', [WalletController::class, 'store'])->name('wallets.store');

        Route::prefix('{wallet_code}/transactions')->group(function () {
            Route::get('/', [WalletTransactionController::class, 'index'])->name('wallet.transactions.index');
            Route::post('/store', [WalletTransactionController::class, 'store'])->name('wallet.transactions.store');
        });
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
    });
});

