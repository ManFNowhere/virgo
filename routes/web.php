<?php

use App\Http\Controllers\AddMovieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

// public middleware
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/category',[CategoryController::class,'index'])->name('category');
Route::get('/search/',[MovieController::class,'search'])->name('search');

// breezer middleware
Route::get('/dashboard', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/delete-user', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/subscription', [SubscriptionController::class, 'subscription'])->name('post.subscription');
    Route::get('/subscription/cancel/{id}', [SubscriptionController::class, 'cancel'])->name('cancel.subscription');
    Route::get('/subscription/cancel-subscription/{id}', [SubscriptionController::class, 'cancelSubscription'])->name('post.cancel.subscription');
    Route::get('/subscription/succes/{type}', [SubscriptionController::class, 'success'])->name('success.subscription');
});

 

require __DIR__.'/auth.php';

// subscriber middleware
Route::get('watch/{slug}', [MovieController::class,'watch'])->name('watch')->middleware(['auth', 'verified']);
Route::get('stream/{type}/{filename}', [MovieController::class,'stream'])->name('stream')->middleware(['auth', 'verified']);

// auth Middleware
Route::get('/movie/{slug}', [MovieController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/show/{slug}', [MovieController::class, 'show'])->middleware(['auth', 'verified']);

// admin middleware
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Movie
    Route::get('add', [AddMovieController::class, 'index'])->name('add.movie');
    Route::post('add', [AddMovieController::class, 'get'])->name('get.movie');
    Route::post('store', [AddMovieController::class, 'store'])->name('store.movie');
    Route::get('admin/movies/{movie}/edit', [AdminController::class, 'editMovie'])->name('admin.movie.edit');
    Route::patch('admin/movies/{movie}', [AdminController::class, 'updateMovie'])->name('admin.movie.update');
    Route::delete('admin/movies/{movie}', [AdminController::class, 'destroyMovie'])->name('admin.movie.destroy');

    // Genre
    Route::post('admin/genres', [AdminController::class, 'storeGenre'])->name('admin.genre.store');
    Route::patch('admin/genres/{genre}', [AdminController::class, 'updateGenre'])->name('admin.genre.update');
    Route::delete('admin/genres/{genre}', [AdminController::class, 'destroyGenre'])->name('admin.genre.destroy');

    // Pricing
    Route::post('admin/pricing', [AdminController::class, 'updatePricing'])->name('admin.pricing.update');
});

// Stripe webhook is only enabled when a signing secret is configured
if (config('cashier.webhook.secret')) {
    Route::post('/webhook', [WebhookController::class, 'handleWebhook']);
}