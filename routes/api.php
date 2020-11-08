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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('users/login', 'App\Http\Controllers\UsersController@login');
Route::get('users/authorized', 'App\Http\Controllers\UsersController@isAuthorized');
Route::post('posts/get', 'App\Http\Controllers\PostsController@index');
Route::get('tags', 'App\Http\Controllers\TagsController@index');
Route::post('comments', 'App\Http\Controllers\CommentsController@index');
Route::post('users', 'App\Http\Controllers\UsersController@store');

Route::group(['middleware' => 'auth'], function () {
    Route::get('users', 'App\Http\Controllers\UsersController@index');
    Route::get('users/{user}', 'App\Http\Controllers\UsersController@show');
    Route::put('users/{user}', 'App\Http\Controllers\UsersController@update');
    Route::delete('users/{user}', 'App\Http\Controllers\UsersController@delete');
    Route::post('users/logout', 'App\Http\Controllers\UsersController@logout');
    
    Route::post('posts', 'App\Http\Controllers\PostsController@store');

    Route::put('comments', 'App\Http\Controllers\CommentsController@store');
});