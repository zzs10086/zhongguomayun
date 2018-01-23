<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('article', 'ArticleController');
   /* $router->get('article', 'ArticleController@index');
    $router->get('article/{id}/edit', 'ArticleController@edit');
    $router->any('article/{id}', 'ArticleController@edit');*/

});
