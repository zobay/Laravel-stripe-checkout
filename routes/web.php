<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {

});

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/confirm', [ProductController::class, 'confirmPurchase'])->name('confirm');
Route::post('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::post('/pay', [OrderController::class, 'pay'])->name('pay');

Route::get('/success', function () {
    return view('success');
})->name('success');
