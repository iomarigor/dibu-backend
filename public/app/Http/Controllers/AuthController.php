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
     * Create a new AuthController instance.
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
        unset($user['email_verified_at']);
        unset($user['remember_token']);
        unset($user['created_at']);
        unset($user['updated_at']);
        return response()->json(['msg' => 'Cuenta registrada satisfactoriamente', 'detalle' => $user], 200);
    }
    /**
     * Get a JWT via given credentials.
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
            return response()->json(['msg' => 'Credenciales invalidas', 'detalle' => null], 401);
        }
        // Obtener el usuario autenticado   
        $user = auth()->user();
        // Actualizar la columna ip_address en el registro del usuario
        $user->update(['ip_address' => $request->ip()]);
        //  Quitando atribudos inecesarios
        unset($user['email_verified_at']);
        unset($user['remember_token']);
        unset($user['created_at']);
        unset($user['updated_at']);
        $user['expirer_in'] = auth()->factory()->getTTL() * 60;
        $user['token'] = 'Bearer ' . $token;
        return response()->json(['msg' => 'Iniciando sessión', 'detalle' => $user], 200);
    }

    /**
     * Get the authenticated User based on the provided token.
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
     * Log the user out (Invalidate the token).
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

        return response()->json(['msg' => 'Session cerrada', 'detalle' => null], 200);
    }

    /**
     * Change a password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        //... por implementar
        // Cambiar la contraseña del usuario y luego registrar el token actual en la tabla de blacklist
        $token = $request->bearerToken();
        // Registra el token actual en la tabla de blacklist
        DB::table('token_blacklist')->insert(['token' => $token]);

        // Invalida el token
        auth()->logout();

        return response()->json(['msg' => 'Session cerrada', 'detalle' => null], 200);
    }
}
