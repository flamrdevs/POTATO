<?php

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

Route::get('/', 'PageController@welcome');

Auth::routes();

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', 'AdminController@index')->name('admin');

    Route::get('/profile', 'AdminController@profile');

    Route::get('/farmer', 'AdminController@farmer_index');

});

Route::group(['prefix' => 'farmer'], function () {

    Route::get('/', 'FarmerController@index')->name('farmer');

    Route::get('/profile', 'FarmerController@profile');

});