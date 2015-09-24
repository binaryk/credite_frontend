<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Request;

class Role 
{
    public function handle($request, Closure $next) 
    {
        $user    = Auth::user();
        if( is_null($user) )
        {
            return \Redirect::to('auth/login');
        }
        $current = $user->getOriginal('userable_type');
        if ($current == 'superadmin') 
        {
            return $next($request);
        }
        $route    = $request->route();
        $actions  = $route->getAction();
        $required = array_get($actions, 'role');
        if(! is_array($required)) 
        {
            $required = [$required];
        }
        if (! in_array($current, $required)) 
        {
            abort(404);
        }
        return $next($request);
    }
}
