<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('docs', function(){
    return View::make('docs.api.v1.index');
});

Route::get('password/reset/{token?}', function($token){
    return View::make('auth.passwords.reset', array('token'=>$token));
});

//////////////////////////////////////////////////////
//
//  ADMIN ROUTES
//
//////////////////////////////////////////////////////

// Admin app authentication routes
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Auth',
], function() {
    Route::get('login', [
        'as' => 'admin.login.form',
        'uses' => 'AdminController@showLoginForm'
    ]);

    Route::post('login', [
        'as' => 'admin.login.request',
        'uses' => 'AdminController@postLogin'
    ]);

    Route::get('logout', [
        'as' => 'admin.logout.request',
        'uses' => 'AdminController@getLogout'
    ]);
});

// Admin app view routes
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => 'auth'
], function() {
    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'DashboardController@index'
    ]);

    //////////////////////////////////////////////////////
    //
    //  ACL ROUTES
    //
    //////////////////////////////////////////////////////
    Route::get('users/roles', [
        'as' => 'users.roles',
        'uses' => 'AuthorizationController@getSyncRoles'
    ]);

    Route::get('users/{user}/roles', [
        'as' => 'users.roles.show',
        'uses' => 'AuthorizationController@showUserRoles'
    ]);

    Route::post('users/{user}/roles', [
        'as' => 'users.roles.sync',
        'uses' => 'AuthorizationController@syncRoles'
    ]);

    Route::resource('roles', 'RolesController', [
        'except' => ['show']
    ]);

    Route::get('roles/permissions', [
        'as' => 'roles.permissions',
        'uses' => 'AuthorizationController@getSyncPermissions'
    ]);

    Route::get('roles/{role}/permissions', [
        'as' => 'roles.permissions.show',
        'uses' => 'AuthorizationController@showRolesPermissions'
    ]);

    Route::post('roles/{role}/permissions', [
        'as' => 'roles.permissions.sync',
        'uses' => 'AuthorizationController@syncPermissions'
    ]);

    Route::resource('permissions', 'PermissionsController', [
        'except' => ['show', 'create']
    ]);

    Route::post('permissions/missing', [
        'as' => 'permissions.sync.missing',
        'uses' => 'AuthorizationController@addMissingPermissions'
    ]);

    Route::post('permissions/deprecated', [
        'as' => 'permissions.sync.deprecated',
        'uses' => 'AuthorizationController@removeDeprecatedPermissions'
    ]);

    //////////////////////////////////////////////////////
    //
    //  USER ROUTES
    //
    //////////////////////////////////////////////////////
    Route::resource('users', 'UsersController');

    //////////////////////////////////////////////////////
    //
    //  RESOURCE SPECIFIC ROUTES
    //
    //////////////////////////////////////////////////////
    Route::resource('errors', 'ErrorsController', [
        'only' => ['index', 'show', 'destroy']
    ]);

	Route::resource('posts', 'PostsController');

	// END OF RESOURCE ROUTES - DO NOT REMOVE/MODIFY THIS COMMENT
});

//////////////////////////////////////////////////////
//
//  TEST ROUTES
//
//////////////////////////////////////////////////////
if (App::environment('local')) {
//    \Log::info(\Request::method().'-'.\Request::url(), \Request::all());

    Route::group(['prefix' => 'test'], function() {
        //////////////////////////////////////////////////////
        //
        //  TEST ROUTES
        //
        //////////////////////////////////////////////////////
        Route::post('notification', 'Notifications\NotificationsController@testNotification');
    });
}