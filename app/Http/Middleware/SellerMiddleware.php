<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
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
            if(Auth::user()->usertype == 1)
                return $next($request);
                
            if(Auth::user()->usertype == 5){
                return $next($request);  
            }
            
        }
        return redirect('home');
    }

}
