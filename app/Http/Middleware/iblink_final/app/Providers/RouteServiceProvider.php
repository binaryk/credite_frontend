<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    protected $namespace = 'App\Http\Controllers';

    public function boot(Router $router) {

        $router->model('county', 'App\Models\County');
        $router->model('country', 'App\Models\Country');
        $router->model('institution', 'App\Models\Institution');
        $router->model('admin', 'App\Models\Administrator');
        $router->model('teacher', 'App\Models\Teacher');
        $router->model('group', 'App\Models\Group');
        $router->model('student', 'App\Models\Student');
        $router->model('custodian', 'App\Models\Custodian');
        $router->model('subject', 'App\Models\Subject');
        $router->model('semester', 'App\Models\Semester');

        parent::boot($router);
    }

    public function map(Router $router) {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }

}
