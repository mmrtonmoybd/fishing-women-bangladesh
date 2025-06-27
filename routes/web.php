<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'] );

Route::get('/post/view/{id}/show', [App\Http\Controllers\Frontend\HomeController::class, 'postShow'] )->name('post.id');
Route::get('/page/view/{id}/show', [App\Http\Controllers\Frontend\HomeController::class, 'pageShow'] )->name('page.id');

// web.php
Route::get('/post/guest/create', [App\Http\Controllers\Frontend\HomeController::class, 'create'])->name('posts.create');
Route::post('/post/guest/store', [App\Http\Controllers\Frontend\HomeController::class, 'store'])->name('posts.store');
// In web.php
// web.php
Route::post('/upload-file', [App\Http\Controllers\Frontend\HomeController::class, 'uploadFile'])
     ->name('markdown.upload'); // Changed from 'markdown.image.upload'

Route::group(['prefix' => '/user', 'as' => 'user.'], function() {
    Route::get('register', [App\Http\Controllers\Frontend\AuthController::class, 'registerform'])->name('register');
    Route::post('register', [App\Http\Controllers\Frontend\AuthController::class, 'register']);

    // login
    Route::get('login', [App\Http\Controllers\Frontend\AuthController::class, 'loginform'])->name('login');
    Route::post('login', [App\Http\Controllers\Frontend\AuthController::class, 'login']);

    Route::middleware(['ifnotauth'])->group(function() {
        Route::get('/logout', [App\Http\Controllers\Frontend\AuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [App\Http\Controllers\Frontend\AuthController::class, 'profile'])->name('profile');
        Route::get('/post/delete/{id}/delete', [App\Http\Controllers\Frontend\AuthController::class, 'postdelete'])->name('post.delete');

        Route::get('/post/edit/{id}/edit', [App\Http\Controllers\Frontend\AuthController::class, 'posteditshow'])->name('post.edit');
        Route::post('/post/edit/{id}/edit', [App\Http\Controllers\Frontend\AuthController::class, 'postedit']);

        Route::get('/profile/edit/edit', [App\Http\Controllers\Frontend\AuthController::class, 'editprofileshow'])->name('profile.edit');
        Route::post('/profile/edit/edit', [App\Http\Controllers\Frontend\AuthController::class, 'editprofile']);
    });
});

Route::get('test', function() {
    return Illuminate\Support\Facades\Hash::make('12345678');
});

Route::get('/clear', function () {
        $exitCode = Artisan::call('optimize:clear');
        // return what you want
    });

    Route::get('/cache', function () {
        $exitCode = Artisan::call('optimize');
        // return what you want
    });

    Route::get('/storagelink', function () {
        $exitCode = Artisan::call('storage:link');
        // return what you want
    });

    Route::get('/migration', function () {
    $exitCode = Artisan::call('migrate');
    // return what you want
});


