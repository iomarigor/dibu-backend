<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\TokenBlacklist;

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

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
            'email' => 'required|unique:users,email,1,id'
        ]);

        $password = Hash::make($request->input('password'));

        $user = User::create(['username' => $request->input('username'), 'password' => $password, 'email' => $request->input('email')]);

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
            'email' => 'required|unique:users,email,1,id'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['msg' => 'Credenciales inválidas', 'detalle' => null], 401);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar la columna ip_address en el registro del usuario
        $user->update(['ip_address' => $request->ip()]);

        $user['expirer_in'] = auth()->factory()->getTTL() * env('JWR_TIME_TOKEN');
        $user['token'] = 'Bearer ' . $token;

        return response()->json(['msg' => 'Sesión Iniciada', 'detalle' => $user], 200);
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

        // Puedes personalizar la información que deseas retornar del usuario
        $userData = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email
        ];

        return response()->json(['msg' => 'Token válido', 'detalle' => $userData], 200);
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

    /**
     * Cambiar la contraseña de un usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        //... por implementar
        // Cambiar la contraseña del usuario y luego registrar el token actual en la tabla de blacklist
        $token = $request->bearerToken();
        // Registra el token actual en la tabla de blacklist
        TokenBlacklist::insert(['token' => $token]);

        // Invalida el token
        auth()->logout();

        return response()->json(['msg' => 'Sesión cerrada', 'detalle' => null], 200);
    }
}
