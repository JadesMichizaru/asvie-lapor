<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix' => 'report'], function () {
    Route::get('/', 'App\Http\Controllers\Api\ReportController@index');
    Route::post('/', 'App\Http\Controllers\Api\ReportController@store');
    Route::get('/{id}', 'App\Http\Controllers\Api\ReportController@show');
    Route::put('/{id}', 'App\Http\Controllers\Api\ReportController@update');
    Route::delete('/{id}', 'App\Http\Controllers\Api\ReportController@destroy');
});
