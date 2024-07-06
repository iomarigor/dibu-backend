<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ConvocatoriaLogicTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadVigenteConvocatoriaCannotWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/convocatoria/vigente-convocatoria');
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Ultima convocatoria mostrada',
            'detalle' => [
                "nombre" => 'Convocatoria2024-1',
            ],
        ]);
    }
    /**
     * Verifica que un usuario administrador pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadVigenteConvocatoriaWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/convocatoria/vigente-convocatoria', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
         $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Ultima convocatoria mostrada',
            'detalle' => [
                "nombre" => 'Convocatoria2024-1',
            ],
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadVigenteConvocatoriaCannotWithNotAllowedCredentialsLevel2(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/convocatoria/vigente-convocatoria', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso denegado
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
         $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Ultima convocatoria mostrada',
            'detalle' => [
                "nombre" => 'Convocatoria2024-1',
            ],
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadVigenteConvocatoriaCannotWithNotAllowedCredentialsLevel3(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('Cris','Cris','Random123',3);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'Random123');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/convocatoria/vigente-convocatoria', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso denegado
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
         $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Ultima convocatoria mostrada',
            'detalle' => [
                "nombre" => 'Convocatoria2024-1',
            ],
        ]);
    }
}
