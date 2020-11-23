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

// // ! DEV MODE ONLY \/
// Route::get('/forcelogout', function() {
//     Auth::logout();
//     return redirect()->route('welcome');
// });
// // ! DEV MODE ONLY /\

// Guest Route
Route::view('/', 'welcome')->name('welcome');

// Auth Route
Route::get('login', 'AuthController@showLoginForm')->middleware('guest')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');

// Admin Route
Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:admin']], function() {
    Route::name('admin')->group(function() {
        ///-----------------------------------------------------------------------------------------------------

        Route::get('/', 'AdminController@index');

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'profile'], function() {

            Route::get('/', 'AdminController@profile')->name('.profile');
            Route::get('/edit', 'AdminController@edit')->name('.edit');
            Route::get('/password', 'AdminController@password')->name('.password');
            Route::put('/update', 'AdminController@update')->name('.update');
            Route::put('/updatePassword', 'AdminController@updatePassword')->name('.updatePassword');

        });

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'broadcast'], function() {
            Route::name('.broadcast')->group(function() {

                Route::get('/', 'AdminController@broadcast_index');
                Route::get('/create', 'AdminController@broadcast_create')->name('.create');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'farming'], function() {
            Route::name('.farming')->group(function() {

                Route::get('/', 'AdminController@farming_index');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'plant'], function() {
            Route::name('.plant')->group(function() {

                Route::get('/', 'AdminController@plant_index');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'farmer'], function() {
            Route::name('.farmer')->group(function() {

                Route::get('/', 'AdminController@farmer_index');
                Route::get('/create', 'AdminController@farmer_create')->name('.create');
                Route::post('/store', 'AdminController@farmer_store')->name('.store');
                Route::get('/{id}', 'AdminController@farmer_show')->name('.show');
                Route::get('/{id}/edit', 'AdminController@farmer_edit')->name('.edit');
                Route::put('/{id}', 'AdminController@farmer_update')->name('.update');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'soilmoisture'], function() {
            Route::name('.soilmoisture')->group(function() {

                Route::get('/', 'AdminController@soilmoisture_index');
                Route::get('/{id}', 'AdminController@soilmoisture_show')->name('.show');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::get('/weather', 'AdminController@weather_index')->name('.weather');

        ///-----------------------------------------------------------------------------------------------------
    });
});

// Farmer Route
Route::group(['prefix' => 'farmer', 'middleware' => ['auth','role:farmer']], function() {
    Route::name('farmer')->group(function() {
        ///-----------------------------------------------------------------------------------------------------

        Route::get('/', 'FarmerController@index');

        ///-----------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'profile'], function() {

            Route::get('/', 'FarmerController@profile')->name('.profile');
            Route::get('/edit', 'FarmerController@edit')->name('.edit');
            Route::get('/password', 'FarmerController@password')->name('.password');
            Route::put('/update', 'FarmerController@update')->name('.update');
            Route::put('/updatePassword', 'FarmerController@updatePassword')->name('.updatePassword');
            
        });
        
        ///-----------------------------------------------------------------------------------------------------

        
        Route::group(['prefix' => 'farmer'], function() {
            Route::name('.farmer')->group(function() {

                Route::get('/', 'FarmerController@farmer_index');

            });
        });

        ///-----------------------------------------------------------------------------------------------------
        
        Route::group(['prefix' => 'soilmoisture'], function() {
            Route::name('.soilmoisture')->group(function() {

                Route::get('/', 'FarmerController@soilmoisture_index');
                Route::get('/{id}', 'FarmerController@soilmoisture_show')->name('.show');

            });
        });

        ///-----------------------------------------------------------------------------------------------------

        Route::get('/weather', 'FarmerController@weather_index')->name('.weather');

        ///-----------------------------------------------------------------------------------------------------
    });
});

// API Route
Route::group(['prefix' => 'api'], function() {

    Route::post('/soilmoisture', 'APIController@post');

});

// Fallback
Route::fallback(function() { return redirect()->route('login'); });