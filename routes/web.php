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
    $router->post('/solicitud/validacion', 'SolicitudController@validacionSolicitud');
});

// Rutas que requieren nivel de acceso 1
$router->group(['middleware' => ['auth', 'restriclevel1']], function ($router) {

    $router->post('/register', 'AuthController@register');

    //Users
    $router->put('/users/update/{id}', 'UserController@update');
    $router->get('/users', 'UserController@index');
    $router->get('/users/show/{id}', 'UserController@show');
    $router->delete('/users/destroy/{id}', 'UserController@destroy');

    //Convocatoria
    $router->get('/convocatoria', 'ConvocatoriaController@index');
    $router->post('/convocatoria/create', 'ConvocatoriaController@create');
    $router->get('/convocatoria/show/{id}', 'ConvocatoriaController@show');

    //Datos academicos de alumnos
    $router->get('/DatosAlumnoAcademico', 'DatosAlumnoAcademicoController@index');
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
