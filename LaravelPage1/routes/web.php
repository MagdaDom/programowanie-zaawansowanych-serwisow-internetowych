<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternalEventController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"]);
Route::get("/internal-events", [InternalEventController::class, "index"]);
Route::get("/internal-events/create", [InternalEventController::class, "create"]);
Route::post("/internal-events/create", [InternalEventController::class, "store"]);
