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


 Route::get('/group-invite/{token}', [GroupController::class,'accept'])->name('group.accept');
Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile');


    Route::middleware('auth')->group(function () {

    Route::patch('profile/user-edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/edit', [ProfileController::class, 'edit_index'])->name('profile.updateIndex');

    Route::post('/profile/update-cover', [ProfileController::class, 'updateImage'])
        ->name('profile.updateCover');

    Route::post('/profile/update-avatar', [ProfileController::class, 'updateImage'])
        ->name('profile.updateAvatar');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('post.create');

    Route::delete('/posts/{post}', [PostController::class,  'destroy'])->name('post.delete');

    

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
    Route::post('group/update-cover/{group}', [GroupController::class, 'saveImage'])->name('group.cover.save');
    Route::post('group/update-avatar/{group}', [GroupController::class, 'saveImage'])->name('group.avatar.save');
    Route::post('/follow', [ProfileController::class, 'followUser'])->name('user.follow');
    Route::post('/groups/{group}/invite', [GroupController::class, 'inviteUser'])->name('group.invite');
    Route::get('/groups', [GroupController::class, 'AllGroups'])->name('group.allGroups');
    Route::patch('/group/update/{group}', [GroupController::class, 'update'])->name('group.update');
    Route::get('/group/edit/{group}', [GroupController::class, 'edit'])->name('group.edit');
    Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
    
   
   
});




require __DIR__ . '/auth.php';
