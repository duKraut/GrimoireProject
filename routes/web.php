<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
    Route::get('/collection/search', [CollectionController::class, 'search'])->name('collection.search');
    Route::resource('decks', DeckController::class);
});

require __DIR__.'/auth.php';
