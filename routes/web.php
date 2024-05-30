<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('posts.comments', \App\Http\Controllers\CommentController::class)->shallow()->only(['store', 'update', 'destroy']);

});

Route::get('posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
//Route::get('test', function (){
////    return \App\Http\Resources\UserResource::make(\App\Models\User::find(11));
//    return [
//      \App\Http\Resources\UserResource::make(\App\Models\User::find(11)),
//      \App\Http\Resources\PostResource::make(\App\Models\Post::find(1)),
//      \App\Http\Resources\CommentResource::make(\App\Models\Comment::find(1))
//    ];
//});
