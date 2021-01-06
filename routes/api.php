<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneController;

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



Route::post('/register', 'App\Http\Controllers\OneController@register');
Route::post('/login', 'App\Http\Controllers\OneController@login');
Route::get('/logout', 'App\Http\Controllers\OneController@logout')->middleware('auth:api');

Route::patch('/users/{user}', 'App\Http\Controllers\OneController@update')->middleware('auth:api');
