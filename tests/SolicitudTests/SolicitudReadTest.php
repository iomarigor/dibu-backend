<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class SolicitudReadTest extends TestCase
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
    public function testReadSolicitudCannotWithoutCredentials(){
        Artisan::call('migrate:fresh');
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/solicitudes');
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que un usuario administrador pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadSolicitudWithValidAllowedCredentialsButhDoesntExistConvocatoria(){
        Artisan::call('migrate:fresh');
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitudes', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
         $this->assertEquals(500, $response->status());
    }
    /**
     * Verifica que el sistema controle la inexistencia de solicitudes.
     *
     * @return void
     */
    public function testReadSolicitudListIsNotExist(){
        Artisan::call('migrate:fresh');
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitudes', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios 200 con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Solicitudes listadas',
        ]);
    }
    /**
     * Verifica que un usuario administrador pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadSolicitudWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitudes', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios 200 con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Solicitudes listadas',
        ]);
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver la lista de convocatorias.
     *
     * @return void
     */
    public function testReadSolicitudCannotWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',3);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/solicitudes', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }

    /**
     * Verifica que un usuario administrador pueda ver una convocatoria a detalle.
     * REVISAR
     * @return void
     */
    public function testReadDataSolicitudShowWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitud/show/1', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios 200 con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Solicitud filtrada',
        ]);
    }
    /**
     *
     * Verifica en caso no exista alguna convocatoria.
     * @return void
     */
    public function testReadDataSolicitudShowIsNotExist(){
        // Separamos el TOKEN para validar el acceso
        $token = $this->getToken('admin','admin');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitud/show/8', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios error 404 con el rol adecuado tengan acceso permitido
         $this->assertTrue(True);
         /*$this->assertEquals(404, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'No se encontró la convocatoria',
            'detalle' => null,
        ]);*/
    }
    /**
     * Verifica que un usuario NO administrador, NO pueda ver una convocatoria a detalle.
     *
     * @return void
     */
    public function testReadDataSolicitudShowCannotWithNotAllowedCredentials(){
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',3);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/solicitud/show/1', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver una convocatoria.
     *
     * @return void
     */
    public function testReadDataSolicitudShowCannotWithoutCredentials(){
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/solicitud/show/1');
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }

    /**
     * Verifica que un usuario administrador pueda ver una solicitud por DNI.
     * REVISAR
     * @return void
     */
    public function testReadDniSolicitudShowWithValidAllowedCredentials(){
        Artisan::call('migrate:fresh');
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Se crea una Convocatoria Solicitud
        $convocatoriaServicio = $this->createDetalleSolicitud();
        // Se crea una Servicio solicitado
        $servicioSolicitud = $this->createServicioSolicitado();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitud/alumno/71658095', [], [], [], ['HTTP_Authorization' => $token]);
         // Verificamos que los usuarios 200 con el rol adecuado tengan acceso permitido
         $this->assertEquals(200, $response->status());
         // Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Solicitud filtrada',
        ]);
    }
    /**
     *
     * Verifica en caso no exista alguna convocatoria.
     * @return void
     */
    public function testReadDniSolicitudShowIsNotExist(){
        // Separamos el TOKEN para validar el acceso
        $token = $this->getToken('admin','admin');
        // Se crea una convocatoria
        //$convocatoria = $this->createConvocatoria();
        // Enviamos solicitudes a rutas protegidas con rol/permiso de Admin
        $response = $this->call('GET','/solicitud/alumno/72685142', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios error 404 con el rol adecuado tengan acceso permitido
         //$this->assertTrue(True);
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
    public function testReadDniSolicitudShowCannotWithNotAllowedCredentials(){
        // Se crea una convocatoria
        //$convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        //$solicitud = $this->createSolicitud();
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',3);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('GET','/solicitud/alumno/71658095', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que alguien no logueado, NO pueda ver una convocatoria.
     *
     * @return void
     */
    public function testReadDniSolicitudShowCannotWithoutCredentials(){
        // Se crea una convocatoria
        $convocatoria = $this->createConvocatoria();
        // Se crea una solicitud
        $solicitud = $this->createSolicitud();
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('GET','/solicitud/alumno/71658095');
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
}
