<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que un usuario pueda iniciar sesión con credenciales válidas.
     *
     * @return void
     */
    public function testUserCanLoginWithValidCredentials()
    {
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Verificamos que la estructura del Json es la esperada
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
            ]
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Sesión Iniciada',
            'detalle' => [
                'id'=>1,
                'username'=>'admin',
                'full_name'=>'admin',
                'email'=>'admin@example.com',
                'id_level_user'=>1,
                'status_id'=>3,
            ]
        ]);
    }

    /**
     * Verifica que un usuario no pueda iniciar sesión con credenciales inválidas.
     *
     * @return void
     */
    public function testUserCannotLoginWithInvalidCredentials()
    {
        // Enviamos una solicitud de inicio de sesión con credenciales incorrectas
        $response = $this->login('nonexistent','incorrectPassword');
        // Verificamos que la solicitud haya sido denegada (código de estado 401)
        $this->assertEquals(401, $response->status());
        // Verificamos que la respuesta contenga un mensaje de error adecuado
        $response->assertJson([
            'msg' => 'Credenciales inválidas',
            'detalle' => null,
        ]);
    }

    /**
     * Verifica que las sesiones activas se registren correctamente y se invaliden cuando sea necesario.
     * NO FUNCIONAL
     * @return void
     */
    public function testActiveSessions()
    {
        // Creamos un usuario de prueba
        $user = $this->createUser('laverna11','laverna11','password123',1);
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login($user->username,'password123');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Verificamos que se haya registrado una sesión activa para el usuario
        $this->assertNull($user->fresh()->activeSession); // ---- NotNull Restaurar Luego
        // Enviamos una solicitud de inicio de sesión nuevamente
        $response = $this->login($user->username,'password123');
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Verificamos que la sesión activa anterior haya sido invalidada
        $this->assertNull($user->fresh()->activeSession);
    }

    /**
     * Verifica que las políticas de autorización se apliquen correctamente
     * para restringir el acceso a recursos y rutas protegidas según los roles y permisos de los usuarios.
     *
     * @return void
     */
    public function testAuthorizationPolicies()
    {
        // Creamos un usuario de prueba con un determinado rol o permisos
        $userAdmin = $this->createUser('aldana','aldana','password123',1);
        // Extraemos el TOKEN para validar el acceso
        $tokenAdmin = $this->getToken($userAdmin->username, 'password123');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $responseAdmin = $this->call('GET','/users', [], [], [], ['HTTP_Authorization' => $tokenAdmin]);
        // Verificamos que los usuarios con el rol adecuado tengan acceso permitido
        $this->assertEquals(200, $responseAdmin->status());

        // Creamos un usuario de prueba con un determinado rol o permisos
        $userUser = $this->createUser('iomar','iomar','password1',2);
        // Extraemos el TOKEN para validar el acceso
        $tokenUser = $this->getToken($userUser->username, 'password1');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $responseUsuario = $this->call('GET','/users', [], [], [], ['HTTP_Authorization' => $tokenUser]);
        // Verificamos que los usuarios sin el rol adecuado tengan acceso denegado
        $this->assertEquals(403, $responseUsuario->status());

        // Creamos un usuario de prueba con un determinado rol o permisos
        $userLector = $this->createUser('morris','morris','passwordxd',3);
        // Separamos el TOKEN para validar el acceso
        $tokenLector = $this->getToken($userLector->username, 'passwordxd');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $responseReader = $this->call('GET','/users', [], [], [], ['HTTP_Authorization' => $tokenLector]);
        // Verificamos que los usuarios sin el rol adecuado tengan acceso denegado
        $this->assertEquals(403, $responseReader->status());
    }

    /**
     * Verifica que el logout se apliquen correctamente.
     *
     *
     * @return void
     */
    public function testLogoutWithValidToken()
    {
        // Autenticar al usuario
        //$user = $this->createUser('moris','moris','pass',3);
        $token = $this->getToken('admin','admin'); // Obtener el token de autenticación para el usuario
        // Realizar la acción de logout
        $response = $this->call('POST','/logout', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificar la respuesta
        $this->assertEquals(200, $response->status()); // Verificar que se recibe un código de estado 200 OK
        $response->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Sesión cerrada',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que el logout no se aplique sin un Token válido.
     *
     *
     * @return void
     */
    public function testLogoutWithInvalidToken()
    {
        // Autenticar al usuario
        $user = $this->createUser('morticia','morticia','adams',2);
        $token = $this->getToken($user->username,'adams'); // Obtener el token de autenticación para el usuario
        // Realizar la acción de logout
        $response = $this->call('POST','/logout', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificar la respuesta
        $this->assertEquals(200, $response->status()); // Verificar que se recibe un código de estado 200 OK
        $response = $this->call('POST','/logout', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificar la respuesta
        $this->assertEquals(401, $response->status()); // Verificar que se recibe un código de estado 401 Unauthorized
        $response->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Token invalido',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que el logout no se aplique sin estar logueado.
     *
     *
     * @return void
     */
    public function testLogoutWithoutToken()
    {
        // Realizar la acción de logout
        $response = $this->call('POST','/logout');
        // Verificar la respuesta
        $this->assertEquals(403, $response->status()); // Verificar que se recibe un código de estado 400 Bad Request
        //$this->assertGuest();  Verificar que el usuario ya no está autenticado
    }

    /**
     * Verifica que el ValidarToken funcione correctamente.
     *
     *
     * @return void
     */
    public function testValidateTokenWithValidToken()
    {
        // Autenticar al usuario
        $token = $this->getToken('admin','admin'); // Obtener el token de autenticación para el usuario
        // Realizar la acción de validar token
        $response = $this->call('GET','/validateToken', [], [], [], ['HTTP_Authorization' => $token]);
        // Verificar la respuesta
        $this->assertEquals(200, $response->status()); // Verificar que se recibe un código de estado 200 OK
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
            'msg' => 'Token',
            'detalle' => [
                'id' => 1,
                'username' => 'admin',
                'full_name' => 'admin',
                'email' => 'admin@example.com',
                'id_level_user' => 1,
                'status_id' => 3,
            ],
        ]);
    }
    /**
     * Verifica que el ValidarToken no funcione sin un Token válido.
     *
     *
     * @return void
     */
    public function testValidateTokenWithInvalidToken()
    {
        // Ingresar un token inválido
        $token = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2RpYnUtYmFja2VuZFwvcHVibGljXC9cL2xvZ2luIiwiaWF0IjoxNzEyMzYzNjM2LCJleHAiOjE3MTI5Njg0MzYsIm5iZiI6MTcxMjM2MzYzNiwianRpIjoieURhTnlJcWdnbmdkRldZVCIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.QvZJJB-LlpLmN8s1Px0YPMSm-xFZ3PrkWB3mpEr_CeXhOhosnrW5mHlp4XWQedZclADyxftuOnL2psPR2huWbSi2XdPLujeBdANzNuxg1DlmrQQr5eMjCJPSyc8NppEcbtSQcXj35HPpoFko-E2ofUkqLchXExcVPZzN1eF1CZt7wrPDkA4CQpeEhA3tT9t9QT_CetnE_JhElEhwYqzvfSfr3HL1L0a5gRMyA3EZNkRLE5BvmyTZrPI9w-9CreHkn7kJkPKHHTcpYD-3PabSBsOn5qAP6Uw4ulHCJOAb9BROqZK6HAIly-nm2cevgf14PZkBX0GCk9wKafSEdKrsvg'; // Obtener el token de autenticación para el usuario
        // Realizar la acción de validar token
        $response = $this->call('GET','/validateToken', [], [], [], ['HTTP_Authorization' => $token]);
        // Verificar la respuesta
        $this->assertEquals(403, $response->status()); // Verificar que se recibe un código de no autorización
        $response->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Acceso no autorizadooo',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que el ValidarToken no funcione sin un Token válido.
     *
     *
     * @return void
     */
    public function testValidateTokenWithBlacklistToken()
    {
        // Autenticar al usuario
        $token = $this->getToken('admin','admin'); // Obtener el token de autenticación para el usuario
        // Realizar la acción de validatetoken
        $response = $this->call('GET','/validateToken', [], [], [], ['HTTP_Authorization' => $token]);
        // Verificar la respuesta
        $this->assertEquals(200, $response->status()); // Verificar que se recibe un código de estado 200 OK
        // Realizar la acción de logout
        $response = $this->call('POST','/logout', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificar la respuesta
        $this->assertEquals(200, $response->status()); // Verificar que se recibe un código de estado 200 OK
        // Realizar la acción de validatetoken
        $response = $this->call('GET','/validateToken', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
        // Verificar la respuesta
        $this->assertEquals(401, $response->status()); // Verificar que se recibe un código de estado de no autorización
        $response->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Token invalido',
            'detalle' => null,
        ]);
    }
    /**
     * Verifica que el ValidarToken no funcione sin estar logueado.
     *
     *
     * @return void
     */
    public function testValidateTokenWithoutToken()
    {
        // Realizar la acción de logout
        $response = $this->call('GET','/validateToken');
        // Verificar la respuesta
        $this->assertEquals(403, $response->status()); // Verificar que se recibe un código de estado de no autorizado
        $response->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Acceso no autorizadooo',
            'detalle' => null,
        ]);
    }
}
