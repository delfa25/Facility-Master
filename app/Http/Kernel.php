<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        // Alias personnalisés + alias standards si nécessaire
        'must.change.password' => \App\Http\Middleware\MustChangePassword::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];

    // Backward-compatibility for projects/environments still expecting $routeMiddleware
    protected $routeMiddleware = [
        'must.change.password' => \App\Http\Middleware\MustChangePassword::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}
