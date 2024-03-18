<?php

use Illuminate\Support\Facades\DB;
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

// Rutas generales, no requiere de inicio de session
$router->group([], function ($router) {
    $router->get('/', function () use ($router) {
        //return ;
        return '<h1>API REST</h1> </br> ' . $router->app->version();
    });
    $router->post('/login', 'AuthController@login');
    $router->get('/validateToken', 'AuthController@validateToken');
});

// Rutas que requieren nivel de acceso 1
$router->group(['middleware' => ['auth', 'restriclevel1']], function ($router) {

    $router->post('/register', 'AuthController@register');

    //Users
    $router->put('/users/{id}', 'UserController@update');
    $router->get('/users', 'UserController@index');
    $router->delete('/users/{id}', 'UserController@destroy');

    //Servicio
    $router->post('/servicio/create', 'ServicioController@create');
    $router->get('/servicios', 'ServicioController@index');
    $router->get('/servicios/{id}', 'ServicioController@show');
    $router->put('/servicio/update/{id}', 'ServicioController@update');

    //Convocatoria
    $router->get('/convocatoria', 'ConvocatoriaController@index');
    $router->post('/convocatoria/create', 'ConvocatoriaController@create');
    $router->get('/convocatorias', 'ConvocatoriaController@index');
    $router->get('/convocatorias/{id}', 'ConvocatoriaController@show');
    $router->get('/ultima-convocatoria', 'ConvocatoriaController@ultimaConvocatoria');
    //$router->put('/convocatoria/update/{id}', 'ConvocatoriaController@update');

    //Requisito
    $router->get('/requisito', 'RequisitoController@index');
    $router->post('/requisito/create', 'RequisitoController@create');
    $router->post('/requisito/show', 'RequisitoController@show');
    $router->post('/requisito/update', 'RequisitoController@update');
    $router->post('/requisito/destroy', 'RequisitoController@destroy');
});

// Rutas que requieren nivel de acceso 2 y 1
$router->group(['middleware' => ['auth', 'restriclevel2']], function ($router) {
});

// Rutas que tienen  acceso todos los niveles de usuarios logeados
$router->group(['middleware' => 'auth'], function ($router) {

    //LevelUsers
    $router->get('/leveluser', 'LevelUserController@index');

    $router->get('/logout', 'AuthController@logout');

    //Rutas a implementar
});
