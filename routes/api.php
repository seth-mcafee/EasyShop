<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User routes
Route::post("/user/login", [UserController::class, 'login']);
Route::post("/user/register", [UserController::class, 'register']);

//Category routes
Route::get("/categories", [CategoryController::class, 'index']);
Route::get("/categories/{id}", [CategoryController::class, 'show']);

//Protected routes
Route::group(["middleware"=> "auth:sanctum"],function(){
    Route::post("/categories", [CategoryController::class, 'store']);
    Route::post("/categories/{id}", [CategoryController::class, 'update']);
    Route::delete("/categories/{id}", [CategoryController::class, 'destroy']);


    Route::post("/user/logout", [UserController::class, 'logout']);

    //test rutas va mal, 
    Route::get("/cart", [CartController::class, 'index']);
    Route::post("/cart", [CartController::class, 'addProduct']);
    Route::post("/cart/remove",[CartController::class,'removeProduct']);
    Route::post("/cart/clear",[CartController::class,'clearAndDelete']);


    //addresses
    Route::get('/addresses', [AddressController::class, 'index']); // Obtener todas las direcciones
    Route::post('/addresses', [AddressController::class, 'store']); // Crear una nueva dirección
    Route::get('/addresses/{id}', [AddressController::class, 'show']); // Obtener una dirección específica
    Route::put('/addresses/{id}', [AddressController::class, 'update']); // Actualizar una dirección
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']); // Eliminar una dirección


    //Orders
    Route::post('/checkout', [OrderController::class, 'checkout']); // CREAR PEDIDO E INICIAR EL PAGO
});


//Product routes
Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::post("/products", [ProductController::class, 'store']);
Route::post("/products/{id}", [ProductController::class, 'update']);
Route::delete("/products/{id}", [ProductController::class, 'destroy']);

