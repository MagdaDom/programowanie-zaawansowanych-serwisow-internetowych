<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternalEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\TaskController;

Route::get("/tasks", [TaskController::class, "index"]);
Route::get("/tasks/create", [TaskController::class, "create"]);
Route::post("/tasks/add-to-db", [TaskController::class, "addToDB"]);
Route::get("/tasks/edit/{id}", [TaskController::class, "edit"]);
Route::post("/tasks/update/{id}", [TaskController::class, "update"]);
Route::get("/tasks/delete/{id}", [TaskController::class, "delete"]);

Route::get("/attachments", [AttachmentController::class, "index"]);
Route::get("/attachments/create", [AttachmentController::class, "create"]);
Route::post("/attachments/add-to-db", [AttachmentController::class, "addToDB"]);
Route::get("/attachments/edit/{id}", [AttachmentController::class, "edit"]);
Route::post("/attachments/update/{id}", [AttachmentController::class, "update"]);
Route::get("/attachments/delete/{id}", [AttachmentController::class, "delete"]);
Route::get(
    '/internal-events/add-attachment/{id}',
    [InternalEventController::class, 'addAttachment']
);

Route::post(
    '/internal-events/add-attachment/{id}',
    [InternalEventController::class, 'addAttachmentToDB']
);

Route::get("/", [HomeController::class, "index"]);
Route::get("/internal-events", [InternalEventController::class, "index"]);
//Route::get("/internal-events/create", [InternalEventController::class, "create"]);
//Route::post("/internal-events/create", [InternalEventController::class, "store"]);
Route::post("/internal-events/add-to-db", [InternalEventController::class, "addToDB"]);

Route::get("/internal-events/edit/{id}", [InternalEventController::class, "edit"]);
Route::post("/internal-events/update/{id}", [InternalEventController::class, "update"]);
Route::get("/internal-events/create", [InternalEventController::class, "create"]);

Route::get("/internal-events/delete/{id}", [InternalEventController::class, "delete"]);
