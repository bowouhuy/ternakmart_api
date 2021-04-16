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



// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/users
    $router->post('users', 'AuthController@register');
 
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    //get navigation
    $router->get('nav/{role_id}', 'AuthController@navigation');
    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/login
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1 
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');

    //Controller Ternak
    $router->get('ternak', 'TernakController@index');
    $router->get('ternak/{id}', 'TernakController@show');
    $router->post('ternak/save', 'TernakController@store');
    $router->post('ternak/{id}', 'TernakController@update');
    $router->delete('ternak/{id}', 'TernakController@destroy');
});