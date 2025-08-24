<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/index', function () {
        return view('admin.index');
    })->name('admin.index');
    Route::get('/admin/bunga', function () {
        return view('admin.bunga');
    })->name('admin.bunga');
    Route::get('/admin/kategori', function () {
        return view('admin.kategori');
    })->name('admin.kategori');
    Route::get('/admin/laporan', function () {
        return view('admin.laporan');
    })->name('admin.laporan');
    Route::get('/admin/buket', function () {
        return view('admin.buket');
    })->name('admin.buket');
    Route::get('/admin/laporan', function () {
        return view('admin.laporan');
    })->name('admin.laporan');

});

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

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

require __DIR__.'/auth.php';
