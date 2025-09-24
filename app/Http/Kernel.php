<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        // Alias personnalisés + alias standards si nécessaire
        'must.change.password' => \App\Http\Middleware\MustChangePassword::class,
        // Use Spatie's role middleware for 'role' alias
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        // Keep custom role middleware under a different alias if needed
        'app_role' => \App\Http\Middleware\RoleMiddleware::class,
        // Spatie (roles & permissions)
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ];

    // Backward-compatibility for projects/environments still expecting $routeMiddleware
    protected $routeMiddleware = [
        'must.change.password' => \App\Http\Middleware\MustChangePassword::class,
        // Use Spatie's role middleware for 'role' alias
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        // Keep custom role middleware under a different alias if needed
        'app_role' => \App\Http\Middleware\RoleMiddleware::class,
        // Spatie (roles & permissions)
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ];
}
