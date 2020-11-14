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

Route::view('/', 'welcome');

Route::view('/design', 'design');

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

    Route::name('admin.')->group(function() {
        Route::name('farmer.')->group(function() {
            // Farmer
            Route::group(['prefix' => 'farmer'], function () {
                Route::get('/', 'AdminController@farmer_index')->name('index');
                Route::get('/create', 'AdminController@farmer_create')->name('create');
                Route::post('/store', 'AdminController@farmer_store')->name('store');
                Route::get('/show', 'AdminController@farmer_show')->name('show');
            });
        });

        // Farming
        Route::group(['prefix' => 'farming'], function () {
            Route::get('/', 'AdminController@farming_index');
            Route::get('/create', 'AdminController@farming_create');
            Route::post('/store', 'AdminController@farming_store');
            Route::get('/show', 'AdminController@farming_show');
        });
        
        // Weather
        Route::get('/weather', 'AdminController@weather_index');
    });
});

// Farmer Dashboard
Route::group(['prefix' => 'farmer'], function () {

    Route::get('/', 'FarmerController@index')->name('farmer');
    Route::get('/profile', 'FarmerController@profile');

    Route::name('farmer.')->group(function() {
        // Farming
        Route::group(['prefix' => 'farming'], function () {
            Route::get('/', 'FarmerController@farming_index');
            Route::get('/show', 'FarmerController@farming_show');
        });

        // Weather
        Route::get('/weather', 'FarmerController@weather_index');
    });
});