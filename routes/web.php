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

Route::redirect('/', '/login');

// Auth
Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::get('register', 'AuthController@showRegisterForm')->name('register');
Route::post('register', 'AuthController@register');

// Admin Dashboard
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/profile', 'AdminController@profile');

    // Farmer
    Route::group(['prefix' => 'farmer'], function () {
        Route::get('/', 'AdminController@farmer_index');
        Route::get('/create', 'AdminController@farmer_create');
        Route::post('/store', 'AdminController@farmer_store')->name('farmer.store');
        Route::get('/show', 'AdminController@farmer_show');
        Route::get('/edit', 'AdminController@farmer_edit');
        Route::post('/update', 'AdminController@farmer_update');
        Route::post('/destroy', 'AdminController@farmer_destroy');
    });

    // Farming
    Route::group(['prefix' => 'farming'], function () {
        Route::get('/', 'AdminController@farming_index');
        Route::get('/create', 'AdminController@farming_create');
        Route::post('/store', 'AdminController@farming_store');
        Route::get('/show', 'AdminController@farming_show');
        Route::get('/edit', 'AdminController@farming_edit');
        Route::post('/update', 'AdminController@farming_update');
        Route::post('/destroy', 'AdminController@farming_destroy');
    });

    // Weather
    Route::get('/weather', 'AdminController@weather_index');

});

// Farmer Dashboard
Route::group(['prefix' => 'farmer'], function () {

    Route::get('/', 'FarmerController@index')->name('farmer');
    Route::get('/profile', 'FarmerController@profile');

    // Farming
    Route::group(['prefix' => 'farming'], function () {
        Route::get('/', 'FarmerController@farming_index');
        Route::get('/show', 'FarmerController@farming_show');
    });

    // Weather
    Route::get('/weather', 'FarmerController@weather_index');

});