<?php namespace App\Http\Middleware;

use Closure;
use Session;

class InstitutionSwitcher 
{

    public function handle($request, Closure $next) {

        $id = Session::get('institution.id');
        if( ! $id ) 
        {
        	return $next($request);
        	// return redirect()->route('auth.switcher');
        }
        return $next($request);
    }
}