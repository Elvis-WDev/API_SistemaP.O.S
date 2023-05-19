<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // Token invalido
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Invalid token'], 401);
            }
            // Token expirado
            if ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Expired token'], 401);
            }

            // Token perdido
            return response()->json(['status' => 'Token not found'], 401);
        }
        return $next($request);
    }
}
