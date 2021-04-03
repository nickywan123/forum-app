<?php

use Illuminate\Support\Facades\Route;

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

// Return all threads
Route::get('/threads','ThreadsController@index');

//Show a thread
Route::get('/threads/{channel}/{thread}','ThreadsController@show');

//Post favourite to a thread
Route::post('/threads/{thread}/favorites','FavoritesController@storeThreads');

//Delete a favourited thread
Route::delete('/threads/{thread}/favorites','FavoritesController@destroyThreads');

//Delete a thread
Route::delete('/threads/{channel}/{thread}','ThreadsController@destroy');

//Create a thread
Route::get('/threads/create','ThreadsController@create');

//Create a new thread
Route::post('/threads','ThreadsController@store');

//Return threads associated with channel
Route::get('/threads/{channel}','ThreadsController@index');

//Show edit thread
Route::get('/threads/{channel}/{thread}/edit','ThreadsController@edit')->name('threads.edit');

//Update the thread
Route::patch('/threads/{thread}','ThreadsController@update')->name('threads.update');

//Post reply to a thread
Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');

//Post favourite to a reply
Route::post('/replies/{reply}/favorites','FavoritesController@store');

//Delete a favourited reply
Route::delete('/replies/{reply}/favorites','FavoritesController@destroy');


//Show reply to a thread
Route::get('/replies/{reply}/edit','RepliesController@edit')->name('reply.edit');

//Update reply
Route::put('/replies/{reply}','RepliesController@update')->name('reply.update');

//Delete a reply
Route::delete('/replies/{reply}','RepliesController@destroy');

//Get user's activity feed
Route::get('/activities/{user}','ProfilesController@activity')->name('activity.user');

// Get user profile information
Route::get('/profile/{user}','ProfilesController@show')->name('profile.show');

//Update user profile information
Route::patch('/profile/{user}','ProfilesController@update')->name('profile.update');

//Route::resource('threads','ThreadsController');

// Auth login and register
Auth::routes(['verify' => true]);

//Auth social for facebook

Route::get('/auth/facebook/redirect','Auth\SocialController@redirect');

Route::get('/auth/facebook/callback','Auth\SocialController@callback');

Route::get('/home', 'HomeController@index')->name('home');

//Create a new subscription
Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionsController@store')->name('subscription.store');


//Delete subscription
Route::delete('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionsController@destroy')->name('subscription.delete');

//Get notification for user
Route::get('/profiles/{user}/notifications','UserNotificationsController@index')->name('notification.index');

//Delete notification
Route::delete('/profiles/{user}/notifications/{notification}','UserNotificationsController@destroy')->name('notifcation.destroy');

Route::post('/threads/search','SearchController@search')->name('thread.search');

//Chat room
Route::get('/chat','MessageController@index')->name('chat.room');

//broadcast message
Route::post('/message', 'MessageController@broadcast');

//Change password
Route::post('/changePassword','Auth\ChangePasswordController@changePassword')->name('changePassword');