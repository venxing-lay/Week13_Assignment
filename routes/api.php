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
Route::get('categories','API\CategoryApiController@index')->name('api.category.index');
Route::post('categories','API\CategoryApiController@store')->name('api.category.store');
Route::put('categories/{category}/update','API\CategoryApiController@update')->name('api.category.update');
Route::delete('categories/{category}/delete','API\CategoryApiController@delete')->name('api.category.delete');

Route::resource("/posts", "API\PostApiController");

