<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
	$router->get('user', 'UserController@showAll');
	$router->get('user/{id}', 'UserController@showOne');
	$router->post('user', 'UserController@create');
	$router->delete('user/{id}', 'UserController@delete');
	$router->put('user/{id}', 'UserController@update');
	$router->get('user/{id}/articles', 'UserController@showArticles');

	$router->post('login','UserController@login');

	$router->get('article', 'ArticleController@showAll');
	$router->get('article/{id}','ArticleController@showOne');
	$router->post('article','ArticleController@create');
	$router->delete('article/{id}','ArticleController@delete');
	$router->put('article/{id}','ArticleController@update');
	$router->get('article/{id}/tags', 'ArticleController@showTags');

	$router->get('tag', 'TagController@showAll');
	$router->get('tag/{id}','TagController@showOne');
	$router->post('tag','TagController@create');
	$router->delete('tag/{id}','TagController@delete');
	$router->put('tag/{id}','TagController@update');
	$router->get('tag/{id}/articles','TagController@showArticles');
});