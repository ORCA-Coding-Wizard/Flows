<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BuketController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BungaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BouquetController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FlowerController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('dashboard');

    Route::resource('kelola-admin', AdminController::class)
        ->parameters(['kelola-admin' => 'admin']);

    Route::resource('bunga', BungaController::class);

    Route::resource('kategori', KategoriController::class)
        ->parameters(['kategori' => 'category']);

    Route::resource('buket', BuketController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('transactions.index');

    Route::patch('/laporan/{transaction}/update-status', [LaporanController::class, 'updateStatus'])
        ->name('transactions.updateStatus');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/flowers', [FlowerController::class, 'index'])->name('flowers.index');
    Route::post('/flowers/{flower}/add', [FlowerController::class, 'addToCart'])->name('flowers.addToCart');

    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::delete('cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/checkout-all', [CartController::class, 'checkoutAll'])->name('cart.checkoutAll');
    Route::post('cart/checkout-one/{cart}', [CartController::class, 'checkoutOne'])->name('cart.checkoutOne');
    Route::post('/cart/add/{flower}', [CartController::class, 'add'])->name('cart.add');

    Route::get('/bouquets', [BouquetController::class, 'index'])->name('bouquets.index');
    Route::post('/bouquets', [BouquetController::class, 'store'])->name('bouquets.store');
    Route::put('/bouquets/{package}', [BouquetController::class, 'update'])->name('bouquets.update');
    Route::delete('/bouquets/{package}', [BouquetController::class, 'destroy'])->name('bouquets.destroy');

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::patch('/user/transaksi/{transaction}/cancel', [\App\Http\Controllers\User\TransactionController::class, 'cancel'])
    ->name('transaksi.cancel');

    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/detail/{detail}/update', [TransactionController::class, 'updateDetail'])->name('transaksi.detail.update');
    Route::post('/transaksi/{transaction}/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/flowers/buy/{flower}', [TransactionController::class, 'buyFlower'])->name('flowers.buy');
    Route::post('/bouquets/buy/{package}', [TransactionController::class, 'buyBouquet'])
        ->name('bouquets.buy');

    Route::post('/transaksi/buy-from-cart/{cart}', [TransactionController::class, 'buyFromCart'])->name('transaksi.buyFromCart');
    Route::post('/transaksi/buy-all-from-cart', [TransactionController::class, 'buyAllFromCart'])->name('transaksi.buyAllFromCart');
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
