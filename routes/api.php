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

    //logout
    Route::post('/logout', 'Auth\ApiAuthController@logout');

    //roles
    Route::post('/admin/users/{user}/roles', 'UserController@assignRole');

    //users
    Route::get('/user', 'UserController@get');
    Route::get('/users', 'UserController@index');
    Route::get('users/{user}', 'UserController@show');
    Route::patch('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');

    //avatars
    Route::prefix('avatars')->group(function () {
        Route::get('/', 'AvatarController@index');
        Route::get('/{avatar}', 'AvatarController@show');
        Route::post('/{avatar}', 'AvatarController@update');
        Route::post('/', 'AvatarController@store');
        Route::delete('/{avatar}', 'AvatarController@destroy');
    });

    //flats
    Route::prefix('flats')->group(function () {
        Route::post('/', 'FlatController@store');
        Route::get('/{flat}', 'FlatController@show');
        Route::patch('/{flat}', 'FlatController@update');
        Route::delete('/{flat}', 'FlatController@destroy');
    });

});




