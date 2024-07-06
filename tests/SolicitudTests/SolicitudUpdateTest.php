<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SolicitudUpdateTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que se registre correctamente un usuario nuevo
     *
     * @return void
     */
    public function testUpdateSolicitud()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Datos del usuario a registrar
        $userSolicitud = [
            'solicitud_id' => 1, 
            'servicios' => [
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
            ], 
        ];
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/solicitud/servicio', $usersolicitud, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
        // Verificamos que la solicitud haya pasado con un status 200 OK
        $this->assertEquals(200, $response->status());
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [
            ],   
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Datos de usuario actualizado satisfactoriamente',
            'detalle' => [    
            ],
        ]);
    }

    /**
     * Verifica que la respuesta del sistema frente a datos erroneos ingresados se aplique correctamente durante el registro.
     *
     * @return void
     */
    public function testBadUpdateUserData()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Datos del usuario a registrar
        $userSolicitud = [
            'solicitud_id' => 1, 
            'servicios' => [
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
            ], 
        ];       
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/solicitud/servicio', $userData, [], [], ['HTTP_Authorization' => $token]);        
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->status());
        return $response;
    }

    /**
     * Verifica que la validación de datos de entrada se aplique correctamente durante el registro.
     *
     * @return void
     */
    public function testUpdateUserDataValidation()
    {
        $response = $this->testBadUpdateUserData();
        // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [
            ],   
        ]);
    }

    /**
     * Verifica que no se permita el doble registro de usuarios
     *
     * @return void
     */
    public function testCannotDuplicateUpdateUserData()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();       
        // Datos del usuario a registrar
        $userSolicitud = [
            'solicitud_id' => 1, 
            'servicios' => [
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
                [
                    'servicio_id' => 1,
                    'estado' => 'aprobado',
                ],
            ], 
        ];   
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/solicitud/servicio', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(200, $response->status());
        // Creamos un usuario para poder editar
        $user = $this->createUser('vorx','vort','0987',2);
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/solicitud/servicio', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(404, $response->status());
        $response->assertJsonStructure([        
            'msg',
            'detalle',   
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Ya existe un usuario con el mismo nombre de usuario',
            'detalle' => null,
        ]);
    }
}
