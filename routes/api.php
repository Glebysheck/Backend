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

Route::post('/user', 'AuthenticationController@index');

Route::get('/check_token', 'CheckController@index');

Route::get('/create_user', 'UserController@create');

Route::get('/create_role', 'RoleController@create');


