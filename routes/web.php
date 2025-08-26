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
    Route::get('/transaction/session', [TransactionController::class, 'showSession'])
        ->name('transaction.showSession');

    Route::post('/transaction/session/{index}/update', [TransactionController::class, 'updateSessionItem'])
        ->name('transaction.session.update');

    Route::post('/transaction/session/{index}/update-papan', [TransactionController::class, 'updatePapanExtra'])
        ->name('transaction.session.updatePapan');

    Route::post('/transaction/session/checkout', [TransactionController::class, 'checkoutSession'])
        ->name('transaction.session.checkout');

    // Route untuk add item ke session
    Route::post('/flowers/add-session/{flower}', [TransactionController::class, 'addToSessionFlower'])->name('flowers.addSession');
    Route::post('/bouquets/add-session/{package}', [TransactionController::class, 'addToSessionBouquet'])->name('bouquets.addSession');
    Route::post('/papan/add-session', [TransactionController::class, 'addToSessionPapan'])->name('papan.addSession');
     Route::get('/add-cart/{cartId}', [TransactionController::class, 'addToSessionCart'])->name('addToSessionCart');
    Route::get('/add-all-cart', [TransactionController::class, 'addAllCartToSession'])->name('addAllCartToSession');

    Route::post('/transaksi/{transaction}/cancel', [TransactionController::class, 'cancel'])
        ->name('transaksi.cancel');
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
