<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
       /*  'jwt.auth' =>  \PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate::class,

        'jwt.refresh' => \PHPOpenSourceSaver\JWTAuth\Http\Middleware\RefreshToken::class,
        'jwt.verify' => \App\Http\Middleware\VerifyJWTToken::class,*/
    ];
}

