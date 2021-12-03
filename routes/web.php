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

$router->get('/', function () use ($router)
{
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router)
{
	$router->group(['namespace' => 'Auth'], function () use ($router)
	{
		//$router->post('register', 'AuthController@register');
		$router->post('login', 'AuthenticationController@login');
	});

	$router->group(['namespace' => 'Event'], function () use ($router)
	{
		$router->get('event', 'EventController@index');
		$router->get('event/{event_id}', 'EventController@show');
		$router->get('event/{event_id}/ticket', 'TicketController@index');
		$router->get('event/{event_id}/ticket/{ticket_id}', 'TicketController@show');
	});

	$router->group(['namespace' => 'Order'], function () use ($router)
	{
		$router->post('checkout', 'CheckoutController@store');
		$router->get('checkout/{checkout_id}', 'CheckoutController@show');
	});
});
