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

Route::post('/add_equipment', 'EquipmentController@create');

Route::post('/save_changes', 'EquipmentController@save_changes');

Route::post('/add_equipment_child', 'EquipmentController@create_child');

Route::post('/change_image', 'EquipmentController@save_image');

Route::post('/change_name', 'EquipmentController@save_name');

Route::post('/add_position_equipment', 'PositionEquipmentController@create');

Route::get('/check_token', 'CheckController@index');

Route::get('/create_user', 'UserController@create');

Route::get('/create_role', 'RoleController@create');

Route::get('/create_status_equipment', 'StatusEquipmentController@create');

Route::get('/equipment', 'EquipmentController@index');

Route::get('/equipment_child', 'EquipmentController@show');

Route::get('/equipment_data', 'EquipmentController@show_parent');




