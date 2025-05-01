<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group([], function () {
   Route::group(['prefix' => 'orders' , 'as' => 'orders.'], function () {
       Route::get('/', [OrderController::class, 'index'])->name('index');
       Route::get('/create', [OrderController::class, 'create'])->name('create');
       Route::post('/', [OrderController::class, 'store'])->name('store');
       Route::get('/{id}/show', [OrderController::class, 'show'])->name('show');
       Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
       Route::put('/{id}', [OrderController::class, 'update'])->name('update');
       Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
   }) ;

   Route::group(['prefix' => 'order-products' , 'as' => 'order_products.'], function () {
       Route::get('/', [OrderController::class, 'index'])->name('index');
       Route::get('/create', [OrderController::class, 'create'])->name('create');
       Route::post('/', [OrderController::class, 'store'])->name('store');
       Route::get('/{id}/show', [OrderController::class, 'show'])->name('show');
       Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
       Route::put('/{id}', [OrderController::class, 'update'])->name('update');
       Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
   });
});