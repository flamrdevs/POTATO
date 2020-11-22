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
// Route::get('/forcelogout', function ()
// {
//     Auth::logout();
//     return redirect()->route('welcome');
// });
// // ! DEV MODE ONLY /\

Route::view('/', 'welcome')->middleware('guest')->name('welcome');

// Auth
Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');

// Admin Dashboard
Route::group(['prefix' => 'admin'], function ()
{
    Route::name('admin')->group(function()
    {

        // url : /admin
        Route::get('/', 'AdminController@index');

        // url : /admin/profile
        Route::group(['prefix' => 'profile'], function ()
        {
            Route::get('/', 'AdminController@profile')->name('.profile');
            Route::get('/edit', 'AdminController@edit')->name('.edit');
            Route::get('/password', 'AdminController@password')->name('.password');
            Route::put('/update', 'AdminController@update')->name('.update');
            Route::put('/updatePassword', 'AdminController@updatePassword')->name('.updatePassword');
        });

        // /___ A ++++

        Route::name('.broadcast')->group(function()
        {
            // url : /admin/broadcast
            Route::group(['prefix' => 'broadcast'], function ()
            {
                Route::get('/', 'AdminController@broadcast_index');
            });
        });

        Route::name('.farming')->group(function()
        {
            // url : /admin/farming
            Route::group(['prefix' => 'farming'], function ()
            {
                Route::get('/', 'AdminController@farming_index');
            });
        });

        Route::name('.plant')->group(function()
        {
            // url : /admin/plant
            Route::group(['prefix' => 'plant'], function ()
            {
                Route::get('/', 'AdminController@plant_index');
            });
        });

        // /___ A ----

        Route::name('.farmer')->group(function()
        {
            // url : /admin/farmer
            Route::group(['prefix' => 'farmer'], function ()
            {
                Route::get('/', 'AdminController@farmer_index');
                Route::get('/create', 'AdminController@farmer_create')->name('.create');
                Route::post('/store', 'AdminController@farmer_store')->name('.store');
                Route::get('/{id}', 'AdminController@farmer_show')->name('.show');
                Route::get('/{id}/edit', 'AdminController@farmer_edit')->name('.edit');
                Route::put('/{id}', 'AdminController@farmer_update')->name('.update');
            });
        });

        Route::name('.soilmoisture')->group(function()
        {
            // url : /admin/soilmoisture
            Route::group(['prefix' => 'soilmoisture'], function ()
            {
                Route::get('/', 'AdminController@soilmoisture_index');
                Route::get('/{id}', 'AdminController@soilmoisture_show')->name('.show');
            });
        });

        Route::name('.weather')->group(function()
        {
            // url : /admin/weather
            Route::get('/weather', 'AdminController@weather_index');
        });
    });

    // fallback url : /admin/any
    Route::fallback(function()
    {
        return redirect()->route('admin');
    });
});

// Farmer Dashboard
Route::group(['prefix' => 'farmer'], function ()
{
    Route::name('farmer')->group(function()
    {

        // url : /farmer
        Route::get('/', 'FarmerController@index');

        // url : /farmer/profile
        Route::group(['prefix' => 'profile'], function ()
        {
            Route::get('/', 'FarmerController@profile')->name('.profile');
            Route::get('/edit', 'FarmerController@edit')->name('.edit');
            Route::get('/password', 'FarmerController@password')->name('.password');
            Route::put('/update', 'FarmerController@update')->name('.update');
            Route::put('/updatePassword', 'FarmerController@updatePassword')->name('.updatePassword');
        });

        Route::name('.farmer')->group(function()
        {
            // url : /farmer/farmer
            Route::group(['prefix' => 'farmer'], function ()
            {
                Route::get('/', 'FarmerController@farmer_index');
            });
        });
        
        Route::name('.soilmoisture')->group(function()
        {
            // url : /farmer/soilmoisture
            Route::group(['prefix' => 'soilmoisture'], function ()
            {
                Route::get('/', 'FarmerController@soilmoisture_index');
                Route::get('/{id}', 'FarmerController@soilmoisture_show')->name('.show');
            });
        });

        Route::name('.weather')->group(function()
        {
            // url : /farmer/weather
            Route::get('/weather', 'FarmerController@weather_index');
        });
    });

    // fallback url : /farmer/any
    Route::fallback(function()
    {
        return redirect()->route('farmer');
    });
});

// API
Route::group(['prefix' => 'api'], function ()
{
    Route::post('/soilmoisture', 'APIController@post');
});

// fallback url : /any
Route::fallback(function()
{
    return redirect()->route('login');
});