<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('home');

Route::get('/groups', [GroupController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('groups');



Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile');


Route::middleware('auth')->group(function () {

    Route::post('/profile/update-cover', [ProfileController::class, 'updateImage'])
        ->name('profile.updateCover');

    Route::post('/profile/update-avatar', [ProfileController::class, 'updateImage'])
        ->name('profile.updateAvatar');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('post.create');

    Route::delete('/posts/{post}', [PostController::class,  'destroy'])->name('post.delete');

    Route::get('/edit', [ProfileController::class, 'edit_index'])
        ->name('profile.updateIndex');

    Route::put('/posts/{post}', [PostController::class,'update'])->name('post.update');
    Route::post('/posts/{post}/like', [PostController::class, 'postReaction'])->name('post.reaction');
    Route::post('/posts/{post}/comment', [PostController::class, 'postComment'])->name('post.comment');
    Route::put('/{comment}/comment', [PostController::class, 'updateComment'])->name('comment.update');
    Route::delete('/{comment}/comment', [PostController::class, 'deleteComment'])->name('comment.delete');
    Route::post('/comment/{comment}/reaction', [PostController::class, 'commentReaction'])->name('comment.reaction');
    Route::post('/groups', [GroupController::class, 'store'])->name('group.store');
    Route::get('/g/{group:slug}', [GroupController::class, 'index'])->name('group');
    Route::post('/groups/join/{group}', [GroupController::class, 'joinGroup'])->name('group.join');
    Route::delete('/groups/leave/{group}', [GroupController::class, 'leaveGroup'])->name('group.leave');
    Route::get('/{group}/users', [GroupController::class, 'getUsers'])->name('group.users');
   
});




require __DIR__ . '/auth.php';
