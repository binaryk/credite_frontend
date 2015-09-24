<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel 
{

    protected $middleware = 
    [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        // 'App\Http\Middleware\VerifyCsrfToken',
    ];

    protected $routeMiddleware = [
        'auth'     => 'App\Http\Middleware\Authenticate',
        'guest'    => 'App\Http\Middleware\RedirectIfAuthenticated',
        'switcher' => 'App\Http\Middleware\InstitutionSwitcher',
        'role'     => 'App\Http\Middleware\Role',
    ];

}
