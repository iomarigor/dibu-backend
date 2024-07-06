<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use App\Models;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{    
    //use DatabaseMigrations;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
    /**
     * Soporte para pruebas de Auth y Login
     *
     * @return void
     */
    // Función que crea usuarios y los retorna
    protected function createUser($username, $full_name, $password, $id_level_user){
        $user = factory('App\Models\User')->create([
            'full_name' => $username,
            'username' => $full_name,
            'password' => Hash::make($password), // Hasheamos la contraseña
            'id_level_user' => $id_level_user,
        ]);
        return $user;
    }
    // Función que loguea usuarios y retorna la respuesta
    protected function login($username, $password){
        $response = $this->call('POST','/login', [
            'username' => $username,
            'password' => $password,
        ]);
        return $response;
    }
    // Función que extrae el TOKEN y lo retorna
    protected function getToken($username, $password){
        $response = $this->login($username,$password);
        $token = $response->json('token');
        return $token;
    }    

    /**
     * Soporte para pruebas de requisitos
     *
     * @return void
     */
    protected function createRequisito(){
        $requisito = factory('App\Models\Requisito')->create();
        return $requisito;
    }
    /**
     * Soporte para pruebas de Servicios
     *
     * @return void
     */
    protected function createServicio(){
        $servicio = factory('App\Models\Servicio')->create();
        return $servicio;
    }
    protected function createServicioSolicitado(){
        $servicio = factory('App\Models\ServicioSolicitado')->create();
        return $servicio;
    }
    protected function createDetalleSolicitud(){
        $servicio = factory('App\Models\DetalleSolicitud')->create();
        return $servicio;
    }
    /**
     * Soporte para pruebas de Secciones
     *
     * @return void
     */
    protected function createSeccion(){
        $seccion = factory('App\Models\Seccion')->create();
        return $seccion;
    }
    /**
     * Soporte para pruebas de Convocatorias
     *
     * @return void
     */    
    protected function createAlumno(){
        $solicitud = factory('App\Models\Alumno')->create();
        return $solicitud;
    }
    protected function createConvocatoriaServicio($idConvocatoria,$idServicio){
        $convocatoriaServicio = factory('App\Models\ConvocatoriaServicio')->create([
            'servicio_id' => $idServicio,
            'convocatoria_id' => $idConvocatoria,
        ]);
        return $convocatoriaServicio;
    }
    protected function createConvocatoria(){        
        $convocatoria = factory('App\Models\Convocatoria')->create([
            'fecha_inicio' => '2024-03-12',
            'fecha_fin' => '2024-04-16',
            'nombre' => 'Convocatoria2024-1',
        ]);
        $convocatoriaServicio = $this->createConvocatoriaServicio(1,1);
        $convocatoriaServicio = $this->createConvocatoriaServicio(1,2);
        $seccion = $this->createSeccion();
        $requisitos = $this->createRequisito();
        $alumno = $this->createAlumno();  
        return $convocatoria;
    }
    /**
     * Soporte para pruebas de Solicitudes
     *
     * @return void
     */    
    protected function createSolicitud(){        
        $solicitud = factory('App\Models\Solicitud')->create([
            'alumno_id' => 1,
            'convocatoria_id' => 1,
        ]);        
        return $solicitud;
    }
    /**
     * Datos de la convocatoria
     *
     * @return void
     */
    public function creacionDatosConvocatoria(){
        $convocatoriaData = [
            'fecha_inicio' => '2024-07-12 00:00:00',
            'fecha_fin' => '2024-08-16 00:00:00',
            'nombre' => 'Convocatoria2024-1',
            'convocatoria_servicio' => [
                    [
                        'servicio_id' => 1,
                        'cantidad' => 175,
                    ],
                    [            
                        'servicio_id' => 2,
                        'cantidad' => 240,
                    ],
                ],
            'secciones' => [
                'descripcion' => 'Datos Personales',
                'requisitos' => [
                    [
                        'nombre' => 'Código estudiante',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'DNI',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Nombres',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Apellidos',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Sexo',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => 'M|F',
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Dirección',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Fecha de nacimiento',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Edad',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Correo institucional',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    
                    [
                        'nombre' => 'Correo personal',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Celular de estudiante',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Celular padre',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    
                    [
                        'nombre' => 'Facultad',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Escuela profesional',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Modalidad de ingreso',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Tipo de estudiante',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Lugar de procedencia',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    [
                        'nombre' => 'Lugar de nacimiento',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 3,
                    ],
                    
                ],
            ],
            [
                'descripcion' => 'Solicitan por primera vez',
                'requisitos' => [
                    [
                        'nombre' => 'Ficha socieconomica',
                        'descripcion' => 'Subir una captura de la ficha socieconomica actualizada (servicio social y pag web)',
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Seleccion su clasificación según su SISFOH vigente',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Suba la captura de su SISFOH vigente',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Copia de DNI de los padres',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 1,
                    ],
                    [
                        'nombre' => 'Copia de DNI del solicitante',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 1,
                    ],
                    [
                        'nombre' => 'Una (01) fotorafia actualizada tamaño carnet y/o pasaporte',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 1,
                    ],
                ],
            ],
            [
                'descripcion' => 'Documentos solicitados',
                'requisitos' => [
                    [
                        'nombre' => 'Carta de compromiso de los padres para uso de los servicios solicitados (Menores de edad)',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 1,
                    ],
                    [
                        'nombre' => 'Solicitud dirigida a la dirección de bienestar universitario',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Copia de recivo de luz y/o agua los que solicitan por primera vez',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Reporte de deudas de tesoreria',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Formato de atencion de los servicios de DBU',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Certijoven policiales',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Certijoven judiciales',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Certijoven penales',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Certificado actualizado unico laboral CERTIJOVEN (Pag web del Ministerio de Trabajo)',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Carne de vacuna antitetanica',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Carne de vacuna antihepatitis',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Seguro de salud',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 4,
                    ],
                    [
                        'nombre' => 'Constancia vigente del SIS o seguro particular',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                    [
                        'nombre' => 'Carta de compromiso para la asistencia a los talleres de psicopedagogia minimo 03 veces',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 1,
                    ],
                    [
                        'nombre' => 'Certificado domiciliario',
                        'descripcion' => null,
                        'url_guia' => null,
                        'url_plantilla' => null,
                        'opciones' => null,
                        'tipo_requisito_id' => 2,
                    ],
                ],
            ],
        ];
        return $convocatoriaData;
    }

    public function creacionDatosSolicitud(){
        $datosSolicitud = [
            'convocatoria_id' => 1,
            'alumno_id' => 1,
            'servicios_solicitados' => [
                [
                    'estado' => 'pendiente',
                    'servicio_id' => 1,
                ],
                [
                    'estado' => 'pendiente',
                    'servicio_id' => 2,
                ]
            ],
            'detalle_solicitudes'  => [
                [
                    'respuesta_formulario' => '0020160310',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 1,
                ],
                [
                    'respuesta_formulario' => '73141098',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 2,
                ],
                [
                    'respuesta_formulario' => 'Iomar IGOR',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 3,
                ],
                [
                    'respuesta_formulario' => 'Alegre Barrera',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 4,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'M',
                    'requisito_id' => 5,
                ],
                [
                    'respuesta_formulario' => 'Informatica y Sistemas',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 6,
                ],
                [
                    'respuesta_formulario' => 'Informatica y Sistemas',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 7,
                ],
                [
                    'respuesta_formulario' => 'CEPRE',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 8,
                ],
                [
                    'respuesta_formulario' => 'JUANJUI',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 9,
                ],
                [
                    'respuesta_formulario' => 'TOCACHE',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 10,
                ],
                [
                    'respuesta_formulario' => '25',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 11,
                ],
                [
                    'respuesta_formulario' => 'iomar.alegre@unas.edu.pe',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 12,
                ],
                [
                    'respuesta_formulario' => 'JR. RICARDO PALMA',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 13,
                ],
                [
                    'respuesta_formulario' => '1999-03-11',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 14,
                ],
                [
                    'respuesta_formulario' => 'iomarigor@gmail.com',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 15,
                ],
                [
                    'respuesta_formulario' => '935287727',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 16,
                ],
                [
                    'respuesta_formulario' => '935287727',
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 17,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'Tesista',
                    'requisito_id' => 18,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 19,
                ],
                [
                    'respuesta_formulario' => '',
                    'url_documento' => null,
                    'opcion_seleccion' => 'POBRE EXTREMO',
                    'requisito_id' => 20,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToVDt7HDhDEMuR6s4MZXypm4cC9F5WlRcLaRdda680&s',
                    'opcion_seleccion' => null,
                    'requisito_id' => 21,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 22,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 23,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 24,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 25,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 26,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 27,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 28,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 29,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'No tiene',
                    'requisito_id' => 30,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'No tiene',
                    'requisito_id' => 31,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'No tiene',
                    'requisito_id' => 32,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 33,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 34,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 35,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => 'SIS',
                    'requisito_id' => 36,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 37,
                ],
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 38,
                ],                
                [
                    'respuesta_formulario' => null,
                    'url_documento' => null,
                    'opcion_seleccion' => null,
                    'requisito_id' => 39,
                ],
            ],
        ];
        return $datosSolicitud;
    }
}
