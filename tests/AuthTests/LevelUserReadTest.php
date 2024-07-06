<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LevelUserReadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que se valide correctamente el nivel de usuario nivel 1(Administradores).
     *
     * @return void
     */
    public function testReadDataLevelUserWithCredentialsLevel1(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/leveluser', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ]);
    }
    /**
     * Verifica que se valide correctamente el nivel de usuario nivel 2(Asistente).
     *
     * @return void
     */
    public function testReadDataLevelUserWithCredentialsLevel2(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/leveluser', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ]);
    }
    /**
     * Verifica que se valide correctamente el nivel de usuario nivel 3(Ayudantes).
     *
     * @return void
     */
    public function testReadDataLevelUserWithCredentialsLevel3(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('morris','morris','passwor3',3);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor3');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/leveluser', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ]);
    }
    /**
     * Verifica que no se permita verificar el usuario sin estar registrado.
     *
     * @return void
     */
    public function testReadDataLevelUserWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/leveluser');
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(403, $response->status());
    }
}
