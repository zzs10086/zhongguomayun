<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => config('app.domain'),'namespace' => 'Pc','prefix' => '/'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/contact.html', 'AboutController@contact');
    Route::get('/duanzi/{page}.html', 'IndexController@duanzi');
    Route::get('/duanzi/', 'IndexController@duanzi');
    Route::get('/yulu/{page}.html', 'IndexController@yulu');
    Route::get('/yulu', 'IndexController@yulu');
    Route::get('/search/{keywords}', 'IndexController@search');
    Route::get('/search', 'IndexController@search');
    Route::any('/wechat', 'WechatController@wechat');
    Route::get('/video/{time}/{id}.html', 'IndexController@video');
    Route::get('/video/{page}.html', 'IndexController@videoList');
    Route::get('/video', 'IndexController@videoList');
    Route::get('/{category}', 'IndexController@category');
    Route::get('/{category}/{page}.html', 'IndexController@category');
    Route::get('/news/{time}/{id}_{page}.html', 'IndexController@show');
    Route::get('/news/{time}/{id}.html', 'IndexController@show');



});

Route::group(['domain' => config('app.m_domain'),'namespace' => 'M','prefix' => '/'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/{category}', 'IndexController@category');
    Route::get('/{category}/{page}.html', 'IndexController@category');
    Route::get('/news/{time}/{id}_{page}.html', 'IndexController@show');
    Route::get('/news/{time}/{id}.html', 'IndexController@show');
    Route::get('/video/{time}/{id}.html', 'IndexController@video');
});