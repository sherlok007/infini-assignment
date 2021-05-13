<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index']);

Route::post('/create', [App\Http\Controllers\CustomerController::class, 'addCustomer'])->name('customer.add');

Route::get('/customers/{id}', [App\Http\Controllers\CustomerController::class, 'getCustomerById']);

Route::post('/update', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('customer.update');

Route::delete('/customers/{id}', [App\Http\Controllers\CustomerController::class, 'deleteCustomer'])->name('customer.delete');