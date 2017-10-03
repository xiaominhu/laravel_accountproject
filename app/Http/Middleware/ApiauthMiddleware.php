<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiauthMiddleware
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
		
		try {

			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}

		} catch (TokenExpiredException $e) {

			return response()->json(['token_expired'], $e->getStatusCode());

		} catch (TokenInvalidException $e) {
			
			return response()->json(['token_invalid'], $e->getStatusCode());

		} catch (JWTException $e) {
			return response()->json(['error' => 1, 'msg' => 'token_absent' ]);
		}
		
		if($user->status != "1")
			return response()->json(['error' => 1, 'msg' => 'not_verified' ]);

		if($user->usertype != "0")
			return response()->json(['error' => 1, 'msg' => 'wrong_type_user' ]);
		
		
		
        return $next($request);
    }
}
