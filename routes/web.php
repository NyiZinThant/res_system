<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DishesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [OrderController::class, 'index'])->name("order.form");
Route::post('/', [OrderController::class, 'search']);
Route::post('order_submit', [OrderController::class, 'submit'])->name("order.submit");

Route::resource('dish', DishesController::class);
Route::get('order', [DishesController::class, 'order'])->name("kitchen.order");

Route::get('order/{order}/approve', [DishesController::class, 'approve']);
Route::get('order/{order}/ready', [DishesController::class, 'ready']);
Route::get('order/{order}/serve', [DishesController::class, 'serve']);
Route::get('order/{order}/cancel', [DishesController::class, 'cancel']);



Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'comfirm' => false,
]);
