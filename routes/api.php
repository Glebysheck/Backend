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

Route::post('/save_changes', 'EquipmentController@change_child');

Route::post('/add_equipment_child', 'EquipmentController@create_child');

Route::post('/change_image', 'EquipmentController@save_image');

Route::post('/change_name', 'EquipmentController@save_name');

Route::post('/add_position_equipment', 'PositionEquipmentController@create');

Route::get('/position_equipment', 'PositionEquipmentController@index');

Route::post('/add_to_location', 'PositionEquipmentController@add_to_location');

Route::get('/show_by_location', 'PositionEquipmentController@show_by_location');

Route::get('/show_by_equipment', 'PositionEquipmentController@show');

Route::post('/remove_from_location', 'PositionEquipmentController@remove_from_location');

Route::post('/change_position', 'PositionEquipmentController@change');

Route::delete('/delete_position', 'PositionEquipmentController@delete');

Route::post('/add_location', 'LocationController@create');

Route::post('/split_location', 'LocationController@split_location');

Route::post('/change_location', 'LocationController@change');

Route::get('/location', 'LocationController@index');

Route::delete('/delete_location', 'LocationController@delete');

Route::get('/parent_location', 'LocationController@show');

Route::get('/check_token', 'CheckController@index');

Route::get('/create_user', 'UserController@create');

Route::get('/create_role', 'RoleController@create');

Route::get('/create_status_equipment', 'StatusEquipmentController@create');

Route::get('/equipment', 'EquipmentController@index');

Route::get('/equipment_child', 'EquipmentController@show');

Route::get('/equipment_data', 'EquipmentController@show_parent');

Route::delete('/delete_equipment', 'EquipmentController@delete');

Route::get('/file', 'EquipmentController@show_image');


