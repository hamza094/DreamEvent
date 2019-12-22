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



//Route::post('/event-create','EventsController@store');

Route::resource('events','EventsController');

Route::patch('/profile/{user}', 'UsersController@update');

Route::post("/api/profile/{user}/avatar","UsersController@avatar")->name('avatar');
Route::get("/api/events",'EventsController@events');
Route::get('/api/findEvents',"EventsController@eventsearch");

//Route::get('events/search', 'EventsController@search');

Route::get('/','FrontEndController@index');

Route::get('topic/{topic}','TopicsController@topic');

Route::get('/events/{event}/replies', 'ReplyController@index');

Route::post('/events/{event}/replies', 'ReplyController@store');

Route::patch('/replies/{reply}', 'ReplyController@update');

Route::delete('/replies/{reply}', 'ReplyController@destroy');

Route::get('{path}',"HomeController@index")->where( '/path', '([A-z\d-\/_.]+)?' );







