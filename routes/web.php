<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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
    Route::post('/profile/update-cover', [ProfileController::class,'updateImage'])
    ->name('profile.updateCover');
 
});


Route::middleware('auth')->group(function () {
    Route::post('/profile/update-avatar', [ProfileController::class,'updateImage'])
    ->name('profile.updateAvatar');

    Route::post('/posts', [PostController::class,'store'])
    ->name('post.create');


 
});

    Route::middleware('auth')->group(function () {
        Route::get('/edit', [ProfileController::class,'edit_index'])->name('profile.updateIndex');
    

    });




require __DIR__.'/auth.php';
