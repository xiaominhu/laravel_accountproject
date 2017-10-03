<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {	
	
		if($request->session()->has('locale')){
			$locale = Session::get('locale');
		}
		else{
			$locale = 'sa';
		}
		
		App::setLocale($locale);
        return $next($request);
    }
}
