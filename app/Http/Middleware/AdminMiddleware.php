<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null){
	 
		if(Auth::check()){
            if(Auth::user()->usertype == 2)
                return $next($request);
                
            if(Auth::user()->usertype == 6){
                return $next($request);  
            }
            
        }
        return redirect('home');
		
		
        return redirect('home');
    }
}
