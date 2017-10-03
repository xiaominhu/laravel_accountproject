<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Validator, Hash;
use App\Contactus;
use App\Sellerlogin;
use Nexmo;

class AuthenticateController extends Controller
{
    //
	public function authenticate(Request $request){
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try{
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 1, 'msg' => 'invalid_credentials'], 200);// 401
            }
        }catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
				return response()->json(['error' => 1 ,    'msg' => 'could_not_create_token'], 200);  // 500
        }
		
		$user = User::where('email', $request->email)
				->select('email', 'no', 'name', 'first_name', 'last_name', 'phone', 'picture', 'country', 'state', 'usertype')
				->first();

		if($request->input('gcm') !== null){
			$gcm = $request->input('gcm');
			$user->gcm = $gcm;
			$user->save();
		}
		
		
	
		
		if($user->usertype != "0")
			return response()->json(['error' => 1 ,    'msg' => 'wrong_type_user'], 200);  // 500
		
        // all good so return the token
        return response()->json(['error' => 0 ,  'user'=> $user,  'token' => $token]);
    }
	
	
	public function authenticateseller(Request $request){
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try{
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 1, 'msg' => 'invalid_credentials'], 200);// 401
            }
        }catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
				return response()->json(['error' => 1 ,    'msg' => 'could_not_create_token'], 200);  // 500
        }
		
		$user = User::where('email', $request->email)
				->select('email', 'no', 'name', 'first_name', 'last_name', 'phone', 'picture', 'country', 'state', 'usertype')
				->first();

		if($request->input('gcm') !== null){
			$gcm = $request->input('gcm');
			$user->gcm = $gcm;
			$user->save();
		}
		
		if($user->usertype != "4")
			return response()->json(['error' => 1 ,    'msg' => 'wrong_type_user'], 200);  // 500
		
        // all good so return the token
        return response()->json(['error' => 0 ,  'user'=> $user,  'token' => $token]);
    }
	
	
	
	
	public function getuser(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		// the token is valid and we have found the user via the sub claim
		return response()->json(compact('user'));
	}
	
	private function generatevalue(){
		$digits = 28;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			
			if( User::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
	
	
	public function signup(Request $request){
		
		$validator =  Validator::make($request->all(), [
			'name'     => 'required|max:255',
			'email'    => 'required|email|max:255|unique:users',
			'phone'    => 'required|max:255|unique:users',
			'password' => 'required|min:6',
		]); 
		
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			$response = User::create([
				'name'     => $request->name,
				'no'       => $this->generatevalue(),
				'email'    => $request->email,
				'phone'    => $request->phone,
				'usertype' => 0,
				'password' => bcrypt($request->password),
			]);	
         //'result' => $response, 

			$sellerlogin  = new Sellerlogin;
            $sellerlogin->seller_id = $response->id;
            $sellerlogin->verification_code = Sellerlogin::generatevalue();
            $sellerlogin->request_id =  Sellerlogin::generaterequestcode();
			User::sendMessage( $user->phone , 'This is the login verificatoin code.  ' .$sellerlogin->verification_code );
			$sellerlogin->save();
			return response()->json(['error' => 0 ,   'requestid'=>$sellerlogin->request_id]);  
            
			
		}
	}
		
	public function validateuser(Request $request){


		$validator =  Validator::make($request->all(), [
						'requestid' => 'required',
						'verficode' => 'required',
					]); 

		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			
			$sellerlogin = Sellerlogin::where('verification_code', $request->verficode)
	                                  ->where('request_id', $request->requestid)
	                                  ->first();
	    	if(isset($sellerlogin)){
	            $sellerlogin->delete();

	            $user = User::find($sellerlogin->seller_id);

	            $user->status = 1;
	            $user->save();

	            return response()->json(['error' => 0 ,   'result' => 'success']);
	    	}

	    	$sellerlogin = Sellerlogin::where('request_id', $request->requestid)
	                                  ->first();
	        if(isset($sellerlogin)){
	        		$sellerlogin->status = $sellerlogin->status + 1;
	                $sellerlogin->save();
	                if($sellerlogin->status > 3) {
	                	$sellerlogin->delete();
	                	return response()->json(['error' => 1 ,   'msg'=>'try_later']);
	                }
	                else
	                	return response()->json(['error' => 1 ,   'msg'=>'try_again']);
	        }

	   		return response()->json(['error' => 1 ,   'msg'=>'invalid_request']);

		}           	
	}
		
	public function changepassword(Request $request){
		$validator =  Validator::make($request->all(), [
						'old_password' => 'required|min:6',
						'new_password' => 'required|min:6',
						'confirm_password' => 'required|min:6',
					]); 
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			$user = JWTAuth::parseToken()->authenticate();
			
			if (!Hash::check($request->old_password, $user->password))
				return response()->json(['error' => 1 ,   'msg' => 'wrong_password' ]); 
			
			
			if($request->confirm_password != $request->new_password){
				return response()->json(['error' => 1 ,   'msg' => 'not_match' ]);
			}
			
			$user-> password = bcrypt($request->new_password);
			$user->save();
			
			return response()->json(['error' => 0 ,   'result' => 'success']);
		}
	}
	
	
	public function contactus(Request $request){

		$validator =  Validator::make($request->all(), [
						'type'         =>   'required|integer',
            			'content'      =>    'required',
					]); 

		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			$user = JWTAuth::parseToken()->authenticate();
			$contactus = new Contactus;
			$contactus->content = $request->content;
			$contactus->user_id = $user->id;
			$contactus->type    = $request->type;
			$contactus->save();
			return response()->json(['error' => 0 ,   'result' => 'success']);
		}

	}
	
	
	public function invite_friend_email(Request $request){
		//
		$validator =  Validator::make($request->all(), [
						'email' => 'email|required',
					]); 
					
		$user = JWTAuth::parseToken()->authenticate();
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			
			return response()->json(['error' => 0 ,   'result' => "success"]);
		}
	}
	
	public function invite_friend_sms(Request $request){
		//
		$validator =  Validator::make($request->all(), [
						'phone' => 'required',
					]); 

		$user = JWTAuth::parseToken()->authenticate();
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			
			return response()->json(['error' => 0 ,   'result' => "success"]);
		}
	}
	
	
}

