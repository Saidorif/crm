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
        Route::post('change-password', 'UserController@changePasword');
        Route::post('user/update', 'UserController@update');
        

        //Employee CRUD
        Route::get('employee', 'EmployeeController@index');
        Route::post('checkemail', 'EmployeeController@checkemail');
        Route::post('employee/store', 'EmployeeController@store');
        Route::get('employee/list', 'EmployeeController@list');
        Route::get('employee/edit/{id}', 'EmployeeController@edit');
        Route::post('employee/update/{id}', 'EmployeeController@update');
        Route::delete('employee/destroy/{id}', 'EmployeeController@destroy');

        //Position Model
        Route::get('position/all','PositionController@index');
        Route::get('position/list','PositionController@list');
        Route::post('position/store','PositionController@store');
        Route::get('position/edit/{id}','PositionController@edit');
        Route::post('position/update/{id}','PositionController@update');
        Route::delete('position/destroy/{id}','PositionController@destroy');

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

        //Attestat Model
        Route::get('attestat/all','AttestatController@index');
        Route::get('attestat/user','AttestatController@userindex');
        Route::post('attestat','AttestatController@attestat');
        Route::post('attestat/complete/{id}','AttestatController@complete');
        Route::post('attestat/show/{id}','AttestatController@show');

        // Controllers
        Route::get('controller', 'ContsController@index');
        Route::post('controller/find', 'ContsController@find');
        Route::post('controller/store', 'ContsController@store');
        Route::post('controller/update/{id}', 'ContsController@update')->where('id', '[0-9]+');
        Route::get('controller/edit/{id}', 'ContsController@edit')->where('id', '[0-9]+');
        Route::get('all-controller-actions', 'ContsController@allContActions');

        // Actions
        Route::get('action', 'ActionController@index');
        Route::post('action/store', 'ActionController@store');
        Route::post('action/update/{id}', 'ActionController@update')->where('id', '[0-9]+');
        Route::get('action/edit/{id}', 'ActionController@edit')->where('id', '[0-9]+');
    });


});

