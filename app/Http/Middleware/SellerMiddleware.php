<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Selfuser\Selfuser;
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
               if(!Selfuser::hasPermissionByUrl(Auth::user()->id, $request->url())){
                  return redirect('seller/usersettings');
               }
                return $next($request); 
            }
            
        }
        return redirect('home');
    }

}
