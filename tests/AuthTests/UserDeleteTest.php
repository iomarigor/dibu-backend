<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserDeleteTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Ejecutar migrate:fresh al inicio de cada prueba
        $this->artisan('migrate:fresh');
    }
    /**
     * Verifica que un usuario administrador pueda eliminar un usuario.
     * REVISAR
     * @return void
     */
    public function testDeleteDataUsersWithValidAllowedCredentials(){
        // Enviamos una solicitud de inicio de sesión con las credenciales del usuario
        $response = $this->login('admin','admin');
        // Creamos un usuario para poder editar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Verificamos que la solicitud haya sido exitosa (código de estado 200)
        $this->assertEquals(200, $response->status());
        // Separamos el TOKEN para validar el acceso
        $token = $response->json('token');
        // Enviamos solicitud de eliminación de usuario específico
        $response = $this->call('DELETE','/users/destroy/2', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que se haya eliminado correctamente
         $this->assertEquals(200, $response->status());
          //Verificamos que la estructura del Json es la esperada
        $response->assertJsonStructure([
            'msg',
            'detalle' => [],
        ])->assertJson([ // Verificamos que el Json tenga los datos esperados
            'msg' => 'Usuario eliminado',
            'detalle' => [],
        ]);
    }
    /**
     *
     * Verifica que se controle la excepción en caso de intentar eliminar un usuario inexistente.
     * @return void
     */
    public function testDeleteDataUsersWhereUserIsNotExist(){
        // Separamos el TOKEN para validar el acceso
        $token = $this->getToken('admin','admin');
        // Creamos un usuario para poder eliminar
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Enviamos solicitud de eliminación a un usuario inexistente
        $response = $this->call('DELETE','/users/destroy/80000', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que el sistema responda con el código correcto
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
     * Verifica que se controle la excepción en caso de intentar eliminar un usuario existente.
     * con un usuario no privilegiado(No administrador)
     * @return void
     */
    public function testDeleteDataUsersWithNotAllowedCredentials(){
        // Creamos un usuario de prueba con un determinado rol o permisos
        $user = $this->createUser('ald','ald','passwor',2);
        // Recibimos el TOKEN para validar el acceso
        $token = $this->getToken($user->username,'passwor');
        // Enviamos solicitudes a rutas protegidas con diferentes roles/permisos
        $response = $this->call('DELETE','/users/destroy/2', [], [], [], ['HTTP_Authorization' => 'Bearer ' . $token]);
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }
    /**
     * Verifica que no se pueda eliminar usuarios estar logueado con un usuario privilegiado.
     *
     * @return void
     */
    public function testDeleteDataUsersCannotWithoutCredentials(){
        // Creamos un usuario
        $user = $this->createUser('vortex','vortexxd','09876l4321',3);
        // Enviamos solicitudes a rutas protegidas sin credenciales
        $response = $this->call('DELETE','/users/destroy/2');
         // Verificamos que los usuarios con el rol no adecuado tengan acceso denegado
         $this->assertEquals(403, $response->status());
    }

    //TENER EN CUENTA LOS TOKENS QUE SE ENCUENTRAN EN LA BLACKLIST
}
