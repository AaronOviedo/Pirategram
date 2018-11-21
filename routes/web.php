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
    return View("welcome");
});
//Extra routes for AJAX working
Route::get('/logout', 'myUserController@logout');
Route::post('newProfile', 'myUserController@newProfile');
Route::post('newCover', 'myUserController@newCover');
Route::post('usersChat', 'myUserController@usersChat');
Route::get('like', 'myUserController@like');
Route::get('unlike', 'myUserController@unlike');
Route::get('follow', 'myUserController@follow');
Route::get('unfollow', 'myUserController@unfollow');
Route::post('sendMessage', 'myUserController@sendMessage');
Route::post('fetchMessages', 'myUserController@fetchMessages');
Route::get('fetchComments', 'PublicationController@fetchComments');
Route::post('storeComment', 'PublicationController@storeComment');
Route::post('deletePost', 'PublicationController@deletePost');
Route::post('editPost', 'PublicationController@editPost');
Route::get('editPostValues', 'PublicationController@editPostValues');

//Restful routes
Route::resource('myUser', 'myUserController');
Route::get('/home', 'HomeController@index');
Route::resource('newPost', 'PublicationController');
Route::resource('profile', 'ProfileController');
Route::get('search', 'SearchController@index');
Route::resource('pvtMsg', 'PvtMsgController');