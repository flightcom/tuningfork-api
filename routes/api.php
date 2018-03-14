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
//
//  API ROUTES
//
//////////////////////////////////////////////////////
Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'middleware' => ['cors']], function () {
    //////////////////////////////////////////////////////
    //
    //  SYSTEM ROUTES
    //
    //////////////////////////////////////////////////////
    Route::post('error/log', [
        'as' => 'error.log',
        'uses' => 'ErrorsController@store',
    ]);

    //////////////////////////////////////////////////////
    //
    //  AUTH API ROUTES
    //
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

        Route::get('whoami', [
            'as' => 'auth.whoami',
            'uses' => 'AuthController@whoAmI',
        ]);

        Route::get('logout', [
            'as' => 'auth.logout',
            'uses' => 'AuthController@logout',
        ]);

        Route::post('register', [
            'as' => 'auth.register',
            'uses' => 'AuthController@register',
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

    // Route::group(['middleware' => 'jwt.auth'], function () {
    Route::group(['middleware' => 'api'], function () {
        //////////////////////////////////////////////////////
        //
        //  RESOURCE API ROUTES
        //
        //////////////////////////////////////////////////////
        Route::put('users/{id}', 'UsersController@update');
        Route::resource('users', 'UsersController', [
            'except' => ['index'],
        ]);

        Route::resource('posts', 'PostsController', [
            'except' => ['create', 'edit'],
        ]);

        //////////////////////////////////////////////////////
        //
        //  ADMIN API ROUTES
        //
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
        //
        //  DEVICES ROUTES
        //
        //////////////////////////////////////////////////////
        Route::resource('devices', 'DevicesController', [
            'except' => ['create', 'edit'],
        ]);
    });
});
