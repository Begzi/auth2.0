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

Route::resource('/films', 'FilmController');
Route::get('/', 'FilmController@home')->name('home')->middleware('auth');
Route::get('/favorite', 'FilmController@favoriteShow')->name('favorite')->middleware('auth');
Route::post('/ajax_post', 'FilmController@ajax')->middleware('auth');


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'UserController@create')->name('register.create');
    Route::post('/register', 'UserController@store')->name('register.store');
    Route::get('/login', 'UserController@loginForm')->name('login.create');
    Route::post('/login', 'UserController@login')->name('login');
});

Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');

// Route::group(['middleware' => 'guest'], function () {
//     Route::get('/register', [ UserController::class, 'create'])->name('register.create');
//     Route::post('/register', [ UserController::class, 'store'])->name('register.store');
//     Route::get('/login', [ UserController::class, 'loginForm'])->name('login.create');
//     Route::post('/login', [ UserController::class, 'login'])->name('login');
// });