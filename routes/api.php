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
    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@get');
    });

    //flat
    Route::prefix('flats')->group(function () {
        Route::post('/', 'FlatController@store');
        Route::get('/{flat}', 'FlatController@show');
        Route::patch('/{flat}', 'FlatController@update');
        Route::delete('/{flat}', 'FlatController@destroy');
    });

});

Route::post('/avatars', 'AvatarController@store');
