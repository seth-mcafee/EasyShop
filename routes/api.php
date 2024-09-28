<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Category routes
Route::get("/categories", [CategoryController::class, 'index']);
Route::get("/categories/{id}", [CategoryController::class, 'show']);
Route::post("/categories", [CategoryController::class, 'store']);
Route::post("/categories/{id}", [CategoryController::class, 'update']);
Route::delete("/categories/{id}", [CategoryController::class, 'destroy']);