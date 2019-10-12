<?php

use Illuminate\Http\Request;
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
# Cadastrar novo usuario atraves da API
Route::post('register', 'Api\RegisterApiController@register');

Route::post('auth/login', 'Api\AuthController@login');
Route::post('auth/refresh', 'Api\AuthController@refresh');
Route::post('auth/logout', 'Api\AuthController@logout');

Route::group(['middleware' => 'jwt.auth', 'namespace' => 'Api\\'], function() {

    # Retorna dados do usuario autenticado
    Route::get('auth/me', 'AuthController@me');

    Route::resource('/post',    'PostController');
    Route::resource('/comment', 'CommentController');
    Route::resource('/album',   'AlbumController');
    Route::resource('/photo',   'PhotoController');

});