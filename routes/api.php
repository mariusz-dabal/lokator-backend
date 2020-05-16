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

Route::post('/login', 'Auth\ApiAuthController@login');
Route::post('/register', 'Auth\ApiAuthController@register');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', 'Auth\ApiAuthController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

//flat
Route::post('/flat', 'FlatController@store');
