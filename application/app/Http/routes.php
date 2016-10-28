<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Auth\AuthController@login');
Route::post('login', 'Auth\AuthController@loginAction');
Route::get('registration/{link?}', 'Auth\AuthController@registration');
Route::post('registration', 'Auth\AuthController@registrationAction');

Route::group(['middleware' => 'auth'], function (){
    Route::post('users/{users}/links', 'UsersController@addLinkAction');
    Route::resource('users', 'UsersController');
});
