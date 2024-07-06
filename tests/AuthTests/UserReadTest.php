<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserReadTest extends TestCase
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
    public function testReadUsersWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/users', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Lista de usuarios',
            'detalle' => [],
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadDataUsersCannotWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/users', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadDataUsersCannotWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/users');
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(403, $response->status());
    }

    /**
     * Verifica que un usuario administrador pueda ver una convocatoria a detalle.
     * REVISAR
     * @return void
     */
    public function testReadDataUsersShowWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Creamos un usuario para poder editar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Creamos un usuario para poder editar
        $user = $this->createUser('vorx','vort','0987',2);
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/users/show/1', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido 200 OK
         $this->assertEquals(200, $response->status());
          //Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Usuario',
            'detalle' => [],
        ]);
    }
    /**
     * 
     * Verifica en caso no exista alguna convocatoria.
     * @return void
     */
    public function testReadDataUsersShowIsNotExist(){
        // Separamos el TOKEN para validar el acceso
        $token = $this->getToken('admin','admin');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/users/show/80000', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(404, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([        
            'msg',
            'detalle' => [],        
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Usuario no encontrado',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver una convocatoria a detalle.
     *
     * @return void
     */
    public function testReadDataUsersShowCannotWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/users/show/{1}', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver una convocatoria.
     *
     * @return void
     */
    public function testReadDataUsersShowCannotWithoutCredentials(){
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/users/show/{1}');
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }

    //TENER EN CUENTA LOS TOKENS QUE SE ENCUENTRAN EN LA BLACKLIST
}
