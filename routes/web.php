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

Route::get('{path}', function () {
    return view('welcome');
})->where('path', '([A-z\d-\/_.]+)?');
Route::get('/home', 'HomeController@index')->name('home')->where('path', '([A-z\d-\/_.]+)?');
Auth::routes();
