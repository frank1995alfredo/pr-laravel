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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', 'UserController@store');
Route::post('login', 'UserController@login');

Route::group(['middleware' => 'auth:api'], function () {
    
    Route::apiResource('provincias', 'ProvinciaController');
    Route::apiResource('ciudades', 'CiudadController');
    Route::apiResource('discapacidades', 'DiscapacidadController');
    Route::apiResource('clientes', 'ClienteController');

    Route::post('logout', 'UserController@logout');
});
