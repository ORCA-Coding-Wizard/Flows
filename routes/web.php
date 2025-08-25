<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BuketController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BungaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FlowerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('kelola-admin', AdminController::class)
        ->parameters(['kelola-admin' => 'admin']);

    Route::resource('bunga', BungaController::class);

    Route::resource('kategori', KategoriController::class)
        ->parameters(['kategori' => 'category']);

    Route::resource('buket', BuketController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::patch('/transactions/{transaction}/status', [LaporanController::class, 'updateStatus'])->name('transactions.updateStatus');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/flowers', [FlowerController::class, 'index'])->name('flowers.index');
    Route::post('/flowers/{flower}/add', [FlowerController::class, 'addToCart'])->name('flowers.addToCart');


    Route::get('/favorit', function () {
        return view('user.favorit');
    })->name('favorit');
    Route::get('/buketmu', function () {
        return view('user.buketmu');
    })->name('buketmu');
    Route::get('/transaksi', function () {
        return view('user.transaksi');
    })->name('transaksi');
});


// Default route "dashboard" tetap ada → redirect ke sesuai role
Route::middleware('auth')->get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();

    return $user->role === 'Admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
