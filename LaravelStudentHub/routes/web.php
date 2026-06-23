<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\EventPhotoController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [EventController::class, 'home'])->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::resource('/admin/events', EventController::class)->except(['index', 'show']);
    Route::resource('/admin/news', NewsController::class)->except(['index', 'show']);

    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/photos', [EventPhotoController::class, 'store'])->name('photos.store');

    Route::get('/admin/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::delete('/admin/messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
});

require __DIR__.'/auth.php';
