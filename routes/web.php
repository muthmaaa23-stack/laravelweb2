<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route mahasiswa - wajib login
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa',      [MahasiswaController::class, 'index']);
    Route::post('/mahasiswa',     [MahasiswaController::class, 'store']);
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);

    // Delete hanya admin
    Route::middleware(['admin'])->group(function () {
        Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);
    });
});