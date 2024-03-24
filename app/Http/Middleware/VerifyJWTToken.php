<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Auth;

class VerifyJWTToken extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();

            $user = JWTAuth::user();

            $request->merge(['user' => $user]);
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is Invalid');
            } elseif ($e instanceof TokenExpiredException) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is Expired');
            } else {
                throw new UnauthorizedHttpException('jwt-auth', 'Token not found');
            }
        }

        return $next($request);
    }
}
