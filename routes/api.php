<?php


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

//////////////////////////////////////////////////////
//  API ROUTES
//////////////////////////////////////////////////////
Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'middleware' => ['cors']], function () {
    //////////////////////////////////////////////////////
    //  SYSTEM ROUTES
    //////////////////////////////////////////////////////
    Route::post('error/log', [
        'as' => 'error.log',
        'uses' => 'ErrorsController@store',
    ]);

    //////////////////////////////////////////////////////
    //  AUTH API ROUTES
    //////////////////////////////////////////////////////
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth',
        'namespace' => 'Auth',
    ], function () {
        Route::post('login', [
            'as' => 'auth.login',
            'uses' => 'AuthController@login',
        ]);

        Route::get('me', [
            'as' => 'auth.me',
            'uses' => 'AuthController@me',
        ]);

        Route::get('logout', [
            'as' => 'auth.logout',
            'uses' => 'AuthController@logout',
        ]);

        Route::get('refresh', [
            'as' => 'auth.refresh',
            'uses' => 'AuthController@refresh',
        ]);

        Route::post('password/email', [
            'as' => 'password.email',
            'uses' => 'PasswordController@sendResetLinkEmail',
        ]);

        Route::post('password/reset', [
            'as' => 'password.reset',
            'uses' => 'PasswordController@reset',
        ]);
    });

    //////////////////////////////////////////////////////
    //////////////  RESOURCE API ROUTES  /////////////////
    //////////////////////////////////////////////////////

    Route::group(['middleware' => 'api'], function () {
        //////////////////////  USER  ///////////////////////
        Route::put('users/{user}', 'UsersController@update');
        Route::get('users/{user}', 'UsersController@show');
        Route::resource('users', 'UsersController', [
            'except' => ['show', 'update'],
        ]);

        ///////////////////  INSTRUMENT  ////////////////////
        Route::put('instruments/{instrument}', 'InstrumentsController@update');
        Route::get('instruments/{instrument}', 'InstrumentsController@show');
        Route::resource('instruments', 'InstrumentsController');

        //////////////////////  LOAN  ///////////////////////
        Route::resource('loans', 'LoanssController');

        ///////////////////  BRANDS  ////////////////////////
        Route::resource('brands', 'BrandsController');

        ///////////////////  MAP  ///////////////////////////
        Route::resource('map', 'MapController');

        ///////////////////  STATIONS  //////////////////////
        Route::resource('stations', 'StationsController');

        ///////////////////  STORES  ////////////////////////
        Route::resource('stores', 'StoresController');

        ///////////////////  CATEGORIES  ////////////////////
        Route::resource('categories', 'CategoriesController');
        Route::get('subcategories/{categorie}', 'CategoriesController@sub');

        ///////////////////  ROLE  //////////////////////////
        Route::resource('roles', 'RolesController');

        //////////////////////  POST  ///////////////////////
        // Route::resource('posts', 'PostsController', [
        //     'except' => ['create', 'edit'],
        // ]);

        //////////////////////////////////////////////////////
        //  ADMIN API ROUTES
        //////////////////////////////////////////////////////

        Route::group([
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => 'Admin',
            'middleware' => 'auth',
        ], function () {
            Route::resource('users', 'UsersController');
        });

        // END OF RESOURCE API - DO NOT REMOVE/MODIFY THIS COMMENT

        //////////////////////////////////////////////////////
        //  DEVICES ROUTES
        //////////////////////////////////////////////////////
        Route::resource('devices', 'DevicesController', [
            'except' => ['create', 'edit'],
        ]);
    });

    //////////////////////////////////////////////////////
    /////////////////  NON-AUTH ROUTES  //////////////////
    //////////////////////////////////////////////////////

    Route::resource('users', 'UsersController', [
        'only' => ['store'],
    ]);

    Route::resource('instruments', 'InstrumentsController', [
        'only' => ['index', 'show'],
    ]);
});
