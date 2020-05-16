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

Route::post('/login', 'Auth\ApiAuthController@login');
Route::post('/register', 'Auth\ApiAuthController@register');

Route::middleware(['auth:sanctum'])->group(function () {

    //user
    Route::post('/logout', 'Auth\ApiAuthController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //flat
    Route::post('/flats', 'FlatController@store');
    Route::get('/flats/{flat}', 'FlatController@show');
    Route::patch('/flats/{flat}', 'FlatController@update');
    Route::delete('/flats/{flat}', 'FlatController@destroy');

});
