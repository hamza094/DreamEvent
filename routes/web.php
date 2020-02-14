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

//backend admin access
Route::get('/api/users',"UsersController@index")->middleware('admin');
Route::get('/api/findUsers',"UsersController@search")->middleware('admin');
Route::delete('/api/users/{id}',"UsersController@destroy")->middleware('admin');
Route::resource('api/topics','TopicsController')->middleware('admin');    
Route::get("/api/allevents",'EventsController@allevents')->middleware('admin');
Route::get("/api/eventscount",'EventsController@eventscount')->middleware('admin');
Route::get('/api/findAllEvents',"EventsController@admineventsearch")->middleware('admin');
Route::get('/api/tickets',"TicketController@index")->middleware('admin');
Route::get('/api/ticketscount',"TicketController@ticketcount")->middleware('admin');
Route::get('/api/ticketsdelivered',"TicketController@delivered")->middleware('admin');
Route::delete('/api/ticket/{ticket}',"TicketController@destroy")->middleware('admin');
Route::get('/api/findtickets',"TicketController@search")->middleware('admin');
Route::post('/api/ticket/deliver/{ticket}',"TicketController@deliver")->middleware('admin');
Route::get('/ticket/show',"TicketController@showme");

//Route::post('/event-create','EventsController@store');

Route::resource('events','EventsController');
Route::get('/events/{event}/delete','EventsController@delete');
Route::get('/events/{event}/draftdelete','EventsController@draftdelete');
Route::get('/events/{event}/undrafted','EventsController@undrafted');


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

Route::post('/subscribe','FrontEndController@subscribe');

Route::post('/buy/{event}',"FrontEndController@buy");

Route::post('/discussion/{reply}','DiscussionReplyController@store');
Route::patch('/discussionreply/{discussionreply}', 'DiscussionReplyController@update');
Route::delete('/discussionreply/{discussionreply}', 'DiscussionReplyController@destroy');
Route::post('/mail/{event}','FrontEndController@mail');

Route::post('/events/{event}/follow','FollowerController@follow');
Route::delete('/events/{event}/follow','FollowerController@unfollow');

Route::get('myevents','UsersController@myevents')->name('myevents');

Route::get('/fullcalender','FullCalender@view');

Route::get('api/calender','FullCalender@index');

Route::delete('/profile/{user}/notifications/{notification}','NotificationsController@destroy');

Route::get('/profile/{user}/notifications','NotificationsController@index');

Route::get('{path}',"HomeController@index")->where( '/path', '([A-z\d-\/_.]+)?' );







