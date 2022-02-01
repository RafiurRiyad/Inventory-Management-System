<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CatagoryController;
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

//Salary Routes
Route::post('/salary/paid/{id}', [SalaryController::class, 'Paid']);
Route::get('/salary', [SalaryController::class, 'AllSalary']);
Route::get('/salary/view/{id}', [SalaryController::class, 'ViewSalary']);
Route::get('/edit/salary/{id}', [SalaryController::class, 'EditSalary']);
Route::post('/salary/update/{id}', [SalaryController::class, 'UpdateSalary']);

//Stock Routes
Route::post('/stock/update/{id}', [ProductController::class, 'StockUpdate']);

