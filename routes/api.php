<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CatagoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('employee', EmployeeController::class);
Route::apiResource('supplier', SupplierController::class);
Route::apiResource('catagory', CatagoryController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('expense', ExpenseController::class);
Route::apiResource('customer', CustomerController::class);

//Salary Routes
Route::post('/salary/paid/{id}', [SalaryController::class, 'Paid']);
Route::get('/salary', [SalaryController::class, 'AllSalary']);
Route::get('/salary/view/{id}', [SalaryController::class, 'ViewSalary']);
Route::get('/edit/salary/{id}', [SalaryController::class, 'EditSalary']);
Route::post('/salary/update/{id}', [SalaryController::class, 'UpdateSalary']);

//Stock Routes
Route::post('/stock/update/{id}', [ProductController::class, 'StockUpdate']);

Route::get('/getting/product/{id}', [PosController::class, 'GetProduct']);
Route::get('/add-to-cart/{id}', [CartController::class, 'AddToCart']);
Route::get('/cart/product/', [CartController::class, 'CartProduct']);
Route::get('/remove/cart/{id}', [CartController::class, 'CartRemove']);
Route::get('/increment/{id}', [CartController::class, 'CartIncrement']);
Route::get('/decrement/{id}', [CartController::class, 'CartDecrement']);

//vat route
Route::get('/vat', [CartController::class, 'Vat']);

//order routes
Route::post('/orderdone', [PosController::class, 'OrderDone']);
Route::get('/orders', [OrderController::class, 'TodayOrder']);
Route::get('/order/details/{id}', [OrderController::class, 'OrderDetails']);
Route::get('/order/order-details/{id}', [OrderController::class, 'OrderDetailsAll']);
Route::post('/search/order', [PosController::class, 'SearchOrderDate']);

//Admin Dashboard
Route::post('/today/sell', [PosController::class, 'TodaySell']);
Route::post('/today/income', [PosController::class, 'TodayIncome']);
Route::post('/today/due', [PosController::class, 'TodayDue']);
Route::post('/today/expense', [PosController::class, 'TodayExpense']);
Route::post('/stockout', [PosController::class, 'StockOut']);
