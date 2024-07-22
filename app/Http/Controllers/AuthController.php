<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionGenerate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Response\Response;
use App\Services\Auth\LoginAuthService;
use App\Services\Auth\LogoutAuthService;
use App\Services\Auth\RegisterAuthService;
use App\Services\Auth\ValidateTokenService;

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
    public function register(RegisterRequest $request, RegisterAuthService $registerAuthService)
    {
        try {
            return Response::res('Cuenta registrada satisfactoriamente', AuthResource::make($registerAuthService->register($request->validated())), 200);
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    /**
     * Obtener un JWT (Json Web Token) mediante las credenciales proporcionadas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request, LoginAuthService $loginAuthService)
    {
        try {
            return Response::res('Sesión Iniciada', AuthResource::make($loginAuthService->login($request->validated(), $request->ip())), 200);
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    /**
     * Obtener el usuario autenticado basado en el token proporcionado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(ValidateTokenService $validateTokenService)
    {
        try {
            return Response::res('Token', AuthResource::make($validateTokenService->validateToken()), 200);
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    /**
     * Cerrar la sesión del usuario (Invalidar el token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request, LogoutAuthService $logoutAuthService)
    {
        try {
            return Response::res('Sesión cerrada', $logoutAuthService->logout($request->bearerToken()), 200);
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }
}
