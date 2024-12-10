<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EbookController;
use Illuminate\Support\Facades\Route;

// Default redirect to login page
Route::get('/', function () {
    return redirect('/login');
});

// Routes that require user to be authenticated
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route, accessible only for authenticated and verified users
    Route::get('/dashboard', [EbookController::class, 'index'])->name('dashboard');
    Route::get('/ebook/{id}', [EbookController::class, 'show'])->name('ebook.show');
    Route::get('/ebook/delete/{id}', [EbookController::class, 'destroy'])->name('ebook.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
