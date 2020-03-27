<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([

    'middleware' => 'api',
    'namespace' => '\App\Http\Controllers',

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    // Route::post('create-user', 'AuthController@createUser');
    
    Route::group(['middleware' => 'jwt.auth'], function(){
        //User model
        Route::get('profile', 'UserController@profile');
        Route::post('user/update', 'UserController@update');

        //Role model
        Route::get('role', 'RoleController@index');
        Route::post('role/store', 'RoleController@store');
        Route::get('role/list', 'RoleController@list');
        Route::get('role/edit/{id}', 'RoleController@edit');
        Route::post('role/update/{id}', 'RoleController@update');
        Route::delete('role/destroy/{id}', 'RoleController@destroy');

        //TestCategory model
        Route::get('category', 'TestCategoryController@index');
        Route::post('category/store', 'TestCategoryController@store');
        Route::get('category/edit/{id}', 'TestCategoryController@edit');
        Route::get('category/list', 'TestCategoryController@list');
        Route::post('category/update/{id}', 'TestCategoryController@update');
        Route::delete('category/destroy/{id}', 'TestCategoryController@destroy');
        
        //Question model
        Route::get('question', 'QuestionController@index');
        Route::post('question/store', 'QuestionController@store');
        Route::get('question/edit/{id}', 'QuestionController@edit');
        Route::post('question/update/{id}', 'QuestionController@update');
        Route::delete('question/destroy/{id}', 'QuestionController@destroy');
    });


});

