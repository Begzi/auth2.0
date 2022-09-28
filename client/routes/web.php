<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/', 'FilmController@home')->name('home');
Route::resource('/films', 'FilmController')->middleware('token');
Route::get('/films/{film}', 'FilmController@show')->name('films.show');

Route::get('/login', 'FilmController@login')->name('login');
Route::get('/logout', 'FilmController@logout')->name('logout')->middleware('token');
Route::get('/endpoint', 'FilmController@endpoint')->name('endpoint')->middleware('token');
Route::get('/loginForm', 
    function(){
        return Redirect::to('http://php-laravel-server.com/api/login?request_uri=http://php-laravel-client.com/login');
    })->name('loginForm');
