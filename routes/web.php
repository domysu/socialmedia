<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
->middleware(['auth', 'verified'])->name('home');

 Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile');


Route::middleware('auth')->group(function () {
    Route::post('/profile/update-image', [ProfileController::class,'updateImage'])
    ->name('profile.updateCover');
 
});





require __DIR__.'/auth.php';
