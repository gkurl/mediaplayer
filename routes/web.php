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


Route::post('/login', 'Auth\LoginController@redirect');
Route::get('/register', 'Auth\RegisterController@redirect');

Route::get('/login/spotify', 'SpotifyAuth@spotifyLogin');
Route::get('/denied', 'SpotifyAuth@denied');
Route::get('/mystats', 'SpotifyAuth@retrieveTokens')->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index');

Auth::routes();

/*Route::get('/home', 'HomeController@index')->name('home');*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
