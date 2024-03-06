<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TokenBlacklist;

class AuthController extends Controller
{
    /**
     * Crear una nueva instancia del controlador AuthController.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'validate']]);
    }
    /**
     * Registro de usuarios
     **/
    public function register(Request $request)
    {
        // Limpiado datos de confirmacion de contraseña
        $data = $request->all();
        $user = User::where([
            ['username', '=', $data['username']],
            ['status_id', '!=', 1],
            ['email', '=', $data['email']]
        ])->first();
        if ($user) {
            return response()->json(['msg' => 'Ya existe un usuario con el mismo nombre de usuario o correo electronico', 'detalle' => $user], 404);
        }
        unset($data['password_confirmation']);

        //Hasheando contraseña
        $data["password"] = Hash::make($request->input('password'));

        $user = User::create($data);

        return response()->json(['msg' => 'Cuenta registrada satisfactoriamente', 'detalle' => $user], 200);
    }

    /**
     * Obtener un JWT (Json Web Token) mediante las credenciales proporcionadas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'username' => 'required'
        ]);

        $credentials = $request->only(['username', 'password']);
        $credentials['status_id'] = 3;
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['msg' => 'Credenciales inválidas', 'detalle' => null], 401);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar la columna ip_address en el registro del usuario
        $user->update(['ip_address' => $request->ip()]);

        $user['expirer_in'] = auth()->factory()->getTTL() * 60 * 24 * 7;
        $user['token'] = 'Bearer ' . $token;
        if ($user['status_id'] == 3) {
            return response()->json(['msg' => 'Sesión iniciada', 'detalle' => $user], 200);
        } else {
            return response()->json(['msg' => 'Credenciales inválidas', 'detalle' => null], 401);
        }
    }

    /**
     * Obtener el usuario autenticado basado en el token proporcionado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(Request $request)
    {
        $user = Auth::user(); // Obtiene el usuario autenticado con el token actual

        if (!$user) {
            return response()->json(['msg' => 'Token no válido', 'detalle' => null], 401);
        }

        return response()->json(['msg' => 'Token válido', 'detalle' => $user], 200);
    }

    /**
     * Cerrar la sesión del usuario (Invalidar el token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        // Registra el token actual en la tabla de blacklist
        TokenBlacklist::insert(['token' => $token]);

        // Invalida el token
        auth()->logout();

        return response()->json(['msg' => 'Sesión cerrada', 'detalle' => null], 200);
    }
}
