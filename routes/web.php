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

use Illuminate\Support\Facades\Input;

Route::get('/', 'AuthController@index')->name('index');
Route::get('/{user}/p/{param}/', 'AuthController@photo')->name('auth.photo');

Route::get('/api/search', 'HomeController@search')->name('search');
Route::post('/api/followers', 'HomeController@ajaxGetFollowers');
Route::post('/api/followings', 'HomeController@ajaxGetFollowings');
Route::post('/api/like', 'HomeController@like')->name('like');
Route::post('/api/likes', 'HomeController@getLikes')->name('likes');

//formulario
Route::get('/accounts/emailsignup', 'AuthController@form')->name('auth.register');
Route::post('/register', 'AuthController@register')->name('register');
Route::post('/login', 'AuthController@login')->name('login');

//rota para pesquisar
Route::get('/explore/tags/{param}', 'AuthController@search')->name('app.search');

//Route::get('/{user}', 'HomeController@user')->name('app.user')->parameters(['id' => 'id']);
Route::get('/accounts/logout', 'AuthController@logout')->name('logout');
Route::get('/accounts/edit', 'HomeController@edit')->name('app.edit');

/*=================APP HOME==============================*/
Route::get('/', 'HomeController@home');
Route::post('/message/submit', 'HomeController@handleMessage')->name('handleMessage')->middleware('auth');
Route::get('/post', 'HomeController@post')->name('app.post')->middleware('auth');
Route::post('/post/submit', 'HomeController@handleSubmit')->name('handleSubmit')->middleware('auth');

Route::post('/accounts/edit/uploadUser', 'UploadController@uploadUser')->name('uploadUser');
Route::post('/accounts/following', 'HomeController@following')->name('following');
Route::post('/accounts/unfollowing', 'HomeController@unfollowing')->name('unfollowing');
//rota para encontrar usuarios
Route::get('/{user}/', 'HomeController@user')->name('app.user');
Route::get('/{user}/p/', 'HomeController@user')->name('app.user');
