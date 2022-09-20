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

Route::middleware('auth')->group(function (){
    Route::middleware('role.view')->group(function (){
        Route::resource('constructions', 'ConstructionController', ['only' => ['index', 'show']]);

        Route::get('/util/unique_people_names/{columnName}', 'UtilController@getUniqueNames');
        Route::get('/summary/profit', 'SummaryController@profit');
        Route::get('/summary/order', 'SummaryController@order');
    });

    Route::middleware('role.admin')->group(function (){
        Route::resource('constructions', 'ConstructionController', ['only' => ['store', 'update', 'destroy']]);
        Route::get('/constructions/number/validate/{year}/{number}', 'ConstructionController@numberValidate');
    });
});
