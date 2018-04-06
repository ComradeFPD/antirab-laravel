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

Route::get('/', function () {
    return view('app');
});

Route::get('register', 'RegistrationController@register');
Route::post('register', 'RegistrationController@postRegister');

Route::get('register/confirm/{token}', 'RegistrationController@confirmEmail');

Route::get('login', 'SessionController@login')->middleware('guest');
Route::post('login', 'SessionController@postLogin')->middleware('guest');
Route::get('logout', 'SessionController@logout');

Route::get('user/edit/{id}', 'UserController@edit');

Route::get('user/search', 'UserController@skillsAjax');
Route::post('user/update/{id}', 'UserController@update');

Route::get('dashboard', ['middleware' => 'auth', function () {
    return 'Welcome, '. Auth::user()->name. '!';
}]);