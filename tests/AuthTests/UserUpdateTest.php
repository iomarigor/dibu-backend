<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserUpdateTest extends TestCase
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
    public function testUpdateUser()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Creamos un usuario para poder editar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Datos del usuario a registrar
        $userData = [
            'username' => 'wado', 
            'full_name' => 'luiswado', 
            'password' => 'luis123', 
            'password_confirmation' => 'luis123', 
            'email' => 'luchowado@unas.com', 
            'id_level_user' => 3, 
        ];        
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/users/update/2', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
        // Verificamos que la solicitud haya pasado con un status 200 OK
        $this->assertEquals(200, $response->status());
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [
                'id',
                'username',
                'full_name',
                'email',
                'id_level_user',
                'status_id',
                'created_at',
                'updated_at',
            ],   
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Datos de usuario actualizado satisfactoriamente',
            'detalle' => [
                'username'=>'wado',
                'full_name'=>'luiswado',
                'email'=>'luchowado@unas.com',
                'id_level_user'=>3,      
            ]
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
        // Creamos un usuario para poder editar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Datos del usuario a registrar
        $userData = [
            'username' => '', // Nombre de usuario vacío (debería fallar la validación)
            'full_name' => '', // Nombre vacío (debería fallar la validación)
            'password' => '123', // Contraseña demasiado corta y sin caracteres(debería fallar la validación)
            'password_confirmation' => 'asdqwe', // Contraseña no coincide (debería fallar la validación)
            'email' => 'invalid_email', //Correo electrónico inválido (debería fallar la validación)
            'id_level_user' => 4, // Id_level_user inválido (debería fallar la validación)
        ];        
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/users/update/2', $userData, [], [], ['HTTP_Authorization' => $token]);        
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->status());
        return $response;
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
        // Creamos un usuario para poder editar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);        
        // Datos del usuario a registrar
        $userData = [
            'username' => 'iomar', // Nombre de usuario vacío (debería fallar la validación)
            'full_name' => 'waldo', // Nombre vacío (debería fallar la validación)
            'password' => 'waldomar123', // Contraseña demasiado corta y sin caracteres(debería fallar la validación)
            'password_confirmation' => 'waldomar123', // Contraseña no coincide (debería fallar la validación)
            'email' => 'waldomar@example.com', //Correo electrónico inválido (debería fallar la validación)
            'id_level_user' => 3, // Id_level_user inválido (debería fallar la validación)
        ];        
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/users/update/2', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(200, $response->status());
        // Creamos un usuario para poder editar
        $user = $this->createUser('vorx','vort','0987',2);
        // Enviamos una solicitud de registro con datos incorrectos
        $response = $this->call('PUT','/users/update/3', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);        
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
