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
// List contact from resource
$router->get('/contacts', 'ContactController@index');
// Store a new contact on resource
$router->post('/contacts', 'ContactController@store');
// Show an existing contact from resource
$router->get('/contacts/{contact_id}', 'ContactController@show');
// Update an existing contact from resource
$router->put('/contacts/{contact_id}', 'ContactController@update');
// Delete an existing contact from resource
$router->delete('/contacts/{contact_id}', 'ContactController@delete');
