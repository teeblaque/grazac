<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1/'], function () {
    //authentication route for task 1
    Route::group(['prefix' => 'auth/'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@signup');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::get('loans', 'LoanController@index');
        Route::post('createLoan', 'LoanController@store');
    });

    //TASK 2
    Route::post('invest', 'InvestorController@index');
    //verify payment
    Route::get('payment/verify/{reference}', 'InvestorController@verify');
});



