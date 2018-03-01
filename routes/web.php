<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::post('/login', 'HomeController@index')->name('login');
Route::get('/register', 'Auth\RegisterController@redirect')->name('register');

Route::get('/login/spotify', 'SpotifyAuth@spotifyLogin');
Route::get('/denied', 'SpotifyAuth@denied');
Route::get('/mystats', 'SpotifyAuth@retrieveTokens');

Auth::routes();

Route::get('/', 'HomeController@index');



