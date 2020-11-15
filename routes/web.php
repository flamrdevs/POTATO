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

use App\User;

// ! DEV MODE ONLY
Route::get('/forcelogout', function () {
    Auth::logout();
    return redirect()->route('welcome');
});
// ! DEV MODE ONLY

Route::view('/', 'welcome')->middleware('guest')->name('welcome');

Route::view('/design', 'design', ['users' => User::where('role','farmer')->get()]);

// Auth
Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::get('register', 'AuthController@showRegisterForm')->name('register');
Route::post('register', 'AuthController@register');

// Admin Dashboard
Route::group(['prefix' => 'admin'], function () {
    Route::name('admin')->group(function() {

        // url : /admin
        Route::get('/', 'AdminController@index');
        Route::get('/profile', 'AdminController@profile')->name('.profile');

        Route::name('.farmer')->group(function() {
            // url : /admin/farmer
            Route::group(['prefix' => 'farmer'], function () {
                Route::get('/', 'AdminController@farmer_index');
                Route::get('/create', 'AdminController@farmer_create')->name('.create');
                Route::post('/store', 'AdminController@farmer_store')->name('.store');
                Route::get('/show', 'AdminController@farmer_show')->name('.show');
            });
        });

        // Route::name('.farming')->group(function() {
        //     // url : /admin/farming
        //     Route::group(['prefix' => 'farming'], function () {
        //         Route::get('/', 'AdminController@farming_index');
        //         Route::get('/create', 'AdminController@farming_create')->name('.create');
        //         Route::post('/store', 'AdminController@farming_store')->name('.store');
        //         Route::get('/show', 'AdminController@farming_show')->name('.show');
        //     });
        // });

        Route::name('.weather')->group(function() {
            // url : /admin/weather
            Route::get('/weather', 'AdminController@weather_index');
        });

    });
});

// Farmer Dashboard
Route::group(['prefix' => 'farmer'], function () {
    Route::name('farmer')->group(function() {

        // url : /farmer
        Route::get('/', 'FarmerController@index');
        Route::get('/profile', 'FarmerController@profile')->name('.profile');

        // Route::name('.farming')->group(function() {
        //     // url : /farmer/farming
        //     Route::group(['prefix' => 'farming'], function () {
        //         Route::get('/', 'FarmerController@farming_index')->name('.index');
        //         Route::get('/show', 'FarmerController@farming_show')->name('.show');
        //     });
        // });

        Route::name('.weather')->group(function() {
            // url : /farmer/weather
            Route::get('/weather', 'FarmerController@weather_index');
        });
    });
});