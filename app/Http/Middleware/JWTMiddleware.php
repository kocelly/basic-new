<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;


class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return $next($request);
        $message = '';

        try{
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            $message = 'Token de autenticación expirado';
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            $message = 'Token de autenticación invalido';
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            $message = 'Agregue token de autenticación';
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ]);
    }
}
