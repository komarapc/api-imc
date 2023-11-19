<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Attempt to authenticate the user with the Bearer Token
            $user = JWTAuth::parseToken()->authenticate();

            // Attach the authenticated user to the request
            $request->merge(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 401,
                'statusMessage' => 'UNAUTHORIZED',
                'message' => 'Unauthorized. Try to login first',
                'success' => false,
            ], 401);
        }

        return $next($request);
    }
}
