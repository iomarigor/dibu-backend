<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserCreateTest extends TestCase
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
    public function testRegistrationUser()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Datos del usuario a registrar
        $userData = [
            'username' => 'luis',
            'full_name' => 'luis',
            'password' => 'luis123',
            'password_confirmation' => 'luis123',
            'email' => 'lucho@unas.com',
            'id_level_user' => 3,
        ];
        // Enviamos una solicitud de registro con datos correctos
        $response = $this->call('POST','/register', $userData, [], [], ['HTTP_Authorization' => $token]);
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
                'expirer_in',
                'token',
            ],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Cuenta registrada satisfactoriamente',
            'detalle' => [
                'username'=>'luis',
                'full_name'=>'luis',
                'email'=>'lucho@unas.com',
                'id_level_user'=>3,
            ]
        ]);
    }

    /**
     * Verifica que la respuesta del sistema frente a datos erroneos ingresados se aplique correctamente durante el registro.
     *
     * @return void
     */
    public function testBadRegistrationUserData()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
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
        $response = $this->call('POST','/register', $userData, [], [], ['HTTP_Authorization' => $token]);
        // Verificamos que la solicitud haya fallado con un código de estado 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->status());
    }

    /**
     * Verifica que no se permita el doble registro de usuarios
     *
     * @return void
     */
    public function testCannotDuplicateRegistrationUserData()
    {
        // Separamos el TOKEN para validar el acceso del admin
        $token = $this->getToken('admin','admin');
        // Datos del usuario a registrar
        $userData = [
            'username' => 'waldo', // Nombre de usuario
            'full_name' => 'waldo', // Nombre
            'password' => 'waldo123', // Contraseña
            'password_confirmation' => 'waldo123', // Contraseña coincide
            'email' => 'waldo@example.com', //Correo electrónico válido
            'id_level_user' => 2, // Id_level_user
        ];
        // Enviamos una solicitud de registro con datos correctos
        $response = $this->call('POST','/register', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificamos que la solicitud sea exitosa con un código de estado 200
        $this->assertEquals(200, $response->status());
        // Enviamos una solicitud de registro con datos repetidos
        $response = $this->call('POST','/register', $userData, [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificamos que la solicitud haya fallado con un código de estado 400
        $this->assertEquals(400, $response->status());
        $response->assertJsonStructure([
            'msg',
            'detalle',
        ])->assertJson([ // Verificamos que el Json devuelva el mensaje correcto
            'msg' => 'Ya existe un usuario con el mismo nombre de usuario o correo electronico',
            'detalle' => null,
        ]);
    }
}
