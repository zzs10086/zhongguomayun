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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('/feed', 'Api\FeedController@index');
Route::get('/detail', 'Api\FeedController@detail');
Route::get('/foucs', 'Api\FeedController@foucs');
Route::post('/agree', 'Api\IndexController@agree');

Route::get('/es/query', 'Api\EsController@query');