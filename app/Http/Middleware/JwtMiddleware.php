<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends  BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException):
                return response()->json(['error' => true, 'message' => 'Token is invalid', 'data' => ''],401);
            elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException):
                return response()->json(['error' => true, 'message' => 'Token expired', 'data' => ''],401);
            else:
                return response()->json(['error' => true, 'message' => 'Authorization token no found', 'data' => ''],401);
            endif;
        }
        return $next($request);
    }
}
