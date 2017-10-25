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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user','UserController@index');

Route::get('verifyEmailFirst','Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');

Route::get('sendEmailDone/{email}/{verifyToken}','Auth\RegisterController@sendEmailDone')->name('sendEmailDone');

Route::get('/allusers', 'UserController@allusers')
    ->name('all');

Route::get('/allusersgrid', 'UserController@allusers')
    ->name('all');

Route::post('/getuser', 'UserController@getuser');

Route::post('/updateuserdata', 'UserController@updateuser');

Route::post('delete','UserController@deleteuser');
    
