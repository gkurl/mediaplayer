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


Route::post('/login', 'HomeController@index');
Route::get('/register', 'HomeController@index');

Route::get('/login/spotify', 'SpotifyAuth@spotifyLogin');
Route::get('/denied', 'SpotifyAuth@denied');
Route::get('/mystats', 'SpotifyAuth@retrieveTokens');

Auth::routes();

Route::get('/', function (){return view('auth.login');});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
