<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ConvocatoriaReadTest extends TestCase
{    
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que un usuario administrador pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadDataConvocatoriaWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/convocatoria', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadDataConvocatoriaCannotWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/convocatoria', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadDataConvocatoriaCannotWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/convocatoria');
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(403, $response->status());
    }

    /**
     * Verifica que un usuario administrador pueda ver una convocatoria a detalle.
     * REVISAR
     * @return void
     */
    public function testReadDataConvocatoriaShowWithValidAllowedCredentials(){        
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/convocatoria/show/1', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido 200 OK
         $this->assertEquals(200, $response->status());
         //Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Convocatoria filtrada',
        ]);
    }
    /**
     * Verifica en caso no exista alguna convocatoria.
     *
     * @return void
     */
    public function testReadDataConvocatoriaShowIsNotExist(){
        // Separamos el TOKEN para validar el acceso
        $token = $this->getToken('admin','admin');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/convocatoria/show/80000', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(404, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'No se encontró la convocatoria',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver una convocatoria a detalle.
     *
     * @return void
     */
    public function testReadDataConvocatoriaShowCannotWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/convocatoria/show/1', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver una convocatoria.
     *
     * @return void
     */
    public function testReadDataConvocatoriaShowCannotWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/convocatoria/show/1');
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
}
