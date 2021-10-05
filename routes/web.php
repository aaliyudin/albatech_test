<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register','UserController@register');
$router->post('/login','UserController@login');

$router->group(['middleware' => 'auth'], function () use ($router) {

  $router->group(['prefix' => 'post'], function () use ($router) {
    $router->get('/', 'PostController@index');
    $router->get('/{id}', 'PostController@show');
    $router->post('/create', 'PostController@create');
    $router->put('/{id}', 'PostController@update');
  	$router->delete('/{id}', 'PostController@delete');
  });

  $router->group(['prefix' => 'category'], function () use ($router) {
    $router->get('/', 'CategoryController@index');
    $router->get('/{id}', 'CategoryController@show');
    $router->post('/', 'CategoryController@create');
    $router->put('/{id}', 'CategoryController@update');
  	$router->delete('/{id}', 'CategoryController@delete');
  });

  $router->group(['prefix' => 'tag'], function () use ($router) {
    $router->get('/', 'TagController@index');
    $router->get('/{id}', 'TagController@show');
    $router->post('/', 'TagController@create');
    $router->put('/{id}', 'TagController@update');
  	$router->delete('/{id}', 'TagController@delete');
  });

  $router->post("/payment", "PaymentController@getSnapUrl");

});
