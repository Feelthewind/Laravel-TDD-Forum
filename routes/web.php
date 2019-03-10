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

Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('api/users', 'Api\UsersController@index');

Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
