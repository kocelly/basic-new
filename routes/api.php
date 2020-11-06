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

Route::apiResource('directorio', 'Api\PostController');

Route::post('login', 'Api\AuthController@login');
Route::post('registro', 'Api\AuthController@registro');
Route::get('logout', 'Api\AuthController@logout');

//Posts
Route::post('posts/create', 'Api\ApiPost@create')->middleware('jwtAuth');