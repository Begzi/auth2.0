<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/films', 'FilmapiController')->middleware('token');
Route::get('/films', 'FilmapiController@index');
Route::get('/show/{films}', 'FilmapiController@show');
Route::get('/login', 'FilmapiController@loginForm')->name('apiloginForm');
Route::post('/login', 'FilmapiController@login')->name('apilogin');
Route::get('/access_token', 'FilmapiController@access_token')->name('access_token');

Route::get('/endpoint', 'FilmapiController@endpoint')->name('endpoint')->middleware('token');