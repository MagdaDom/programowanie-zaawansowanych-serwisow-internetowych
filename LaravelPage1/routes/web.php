<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternalEventController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"]);
Route::get("/internal-events", [InternalEventController::class, "index"]);
Route::get("/internal-events/create", [InternalEventController::class, "create"]);
Route::post("/internal-events/create", [InternalEventController::class, "store"]);

Route::get("/internal-events/edit/{id}", [InternalEventController::class, "edit"]);
Route::post("/internal-events/update/{id}", [InternalEventController::class, "update"]);
Route::get("/internal-events/create", [InternalEventController::class, "create"]);
Route::post("/internal-events/add-to-db", [InternalEventController::class, "addToDb"]);

Route::delete("/internal-events/delete/{id}", [InternalEventController::class, "delete"]);
