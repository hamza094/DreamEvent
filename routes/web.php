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

//login routes
Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

//profile routes
Route::get('/profile/{user}', 'UsersController@show');

Route::patch('/profile/{user}', 'UsersController@update');

Route::post("/api/profile/{user}/avatar","UsersController@avatar")->name('avatar');

Route::get('{path}',"HomeController@index")->where( '/path', '([A-z\d-\/_.]+)?' );







