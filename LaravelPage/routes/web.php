<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InternalEventController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"])->name('home.index');
Route::resource('tasks', TaskController::class);
Route::resource('internalevents', InternalEventController::class);
