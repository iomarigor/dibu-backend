<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\TokenBlacklist;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        // Verifica si el token está en la lista de tokens inválidos
        $tokenInBlacklist = TokenBlacklist::where('token', $token)->exists();

        if ($tokenInBlacklist) {
            return response()->json(['msg' => 'Token invalido', 'detalle' => null], 401);
        }

        // Validar la IP del cliente
        $user = auth()->user();
        //var_dump($user);
        if ($user && $user->ip_address !== $request->ip()) {
            return response()->json(['msg' => 'Token invalido A', 'detalle' => null], 401);
        }

        return $next($request);
    }
}
