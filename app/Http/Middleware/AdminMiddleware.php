<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Helpers\Selfuser\Selfuser;
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

            if((Auth::user()->usertype != 2) && (Auth::user()->usertype != 6))
                return redirect('home');
             if(Auth::user()->last_login_ip){
                /*
                $current_ip =  $request->ip();
                if($current_ip != Auth::user()->last_login_ip)
                {
                    $user = User::find(Auth::user()->id);
                    $user->status = 0;
                    $user->save();
                    Auth::logout();
                    return redirect('/');
                }
				*/
             }
			 
            if(Auth::user()->usertype == 2)
                return $next($request);
                
            if(Auth::user()->usertype == 6){
                if(!Selfuser::hasPermissionByUrlAdmin(Auth::user()->id, $request->url())){
                    return redirect('admin/usersettings');
                 }
                return $next($request);  
            }
        }
        return redirect('home');
    }
}
