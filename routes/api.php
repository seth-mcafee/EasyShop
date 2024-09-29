<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

//Product routes
Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::post("/products", [ProductController::class, 'store']);
Route::post("/products/{id}", [ProductController::class, 'update']);
Route::delete("/products/{id}", [ProductController::class, 'destroy']);