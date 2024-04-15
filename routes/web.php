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
        return '<h1>API REST</h1> </br> ' . $router->app->version() . '-' . storage_path('app/private_key.pem');
    });
    $router->post('/login', 'AuthController@login');

    $router->get('/convocatoria/vigente-convocatoria', 'ConvocatoriaController@vigenteConvocatoria');

    $router->post('/solicitud/validacion', 'SolicitudController@validacionSolicitud');
    $router->post('/solicitud/create', 'SolicitudController@create');
    $router->post('/solicitud/uploadDocument', 'SolicitudController@uploadDocument');
    $router->get('/solicitud/alumno/{dni}', 'SolicitudController@cargaSolicitudAlumno');
    $router->get('/solicitud/servicioSolicitado/{dni}', 'SolicitudController@servicioSolicitadoSolicitante');
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
    $router->post('/convocatoria/create', 'ConvocatoriaController@create');
    $router->get('/convocatoria/show/{id}', 'ConvocatoriaController@show');
    $router->get('/convocatoria/reporte/{id}', 'ConvocatoriaController@reporteConvocatoria');
    //$router->put('/convocatoria/update/{id}', 'ConvocatoriaController@update');


    //$router->get('/DatosAlumnoAcademico', 'DatosAlumnoAcademicoController@index');
    //$router->get('/DatosAlumnoAcademico/show/{DNI}', 'DatosAlumnoAcademicoController@show');
});

// Rutas que requieren nivel de acceso 2 y 1
$router->group(['middleware' => ['auth', 'restriclevel2']], function ($router) {

    //Convocatoria
    $router->get('/convocatoria', 'ConvocatoriaController@index');

    //Solicitud
    $router->put('/solicitud/servicio', 'SolicitudController@updateServicio');

    $router->get('/servicio', 'ServicioController@index');
});

// Rutas que tienen  acceso todos los niveles de usuarios logeados
$router->group(['middleware' => 'auth'], function ($router) {
    //Solicitud
    $router->get('/solicitudes', 'SolicitudController@index');
    $router->get('/solicitud/show/{id}', 'SolicitudController@show');
    $router->get('/solicitud/export/', 'SolicitudController@solicitudExport');
    //LevelUsers
    $router->get('/leveluser', 'LevelUserController@index');

    $router->post('/logout', 'AuthController@logout');
    $router->get('/validateToken', 'AuthController@validateToken');

    //Rutas a implementar
});
