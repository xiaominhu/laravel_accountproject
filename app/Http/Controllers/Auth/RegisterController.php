<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Setting;
use App\Transactions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;

use App\Reward;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Session::flash('login', 'no');
		if($data['usertyper'] == "0"){

                Session::flash('user', 'user');

                Session::flash('name_user',  $data['name']);
                Session::flash('email_user', $data['email']);
                Session::flash('phone_user', $data['phone']);
          

    			return Validator::make($data, [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users',
                'phone'    => 'required|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
    			]);
            }
		else{
            Session::flash('name_seller',    $data['name']);
            Session::flash('email_seller',   $data['email']);
            Session::flash('phone_seller',   $data['phone']);
            Session::flash('license_seller', $data['license']);


             Session::flash('vendor', 'vendor');
             return Validator::make($data, [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users',
                'phone'    => 'required|max:255|unique:users',
                'license'  => 'required|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                ]);
        }
			
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
	 
	public function generatevalue(){
		$digits = 10;
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
	 
    protected function create(array $data)
    {
        $data['no'] = $this->generatevalue();
		if($data['usertyper'] == "1"){
			$data['usertype'] = 1;
            return User::create([
                'name'     => $data['name'],
                'no'       => $data['no'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'license'  => $data['license'],
                'usertype' => $data['usertype'],
                'password' => bcrypt($data['password']),
            ]);
        }
		else{
            if($data['invite'] != "never"){
                $receiver = User::where('no', $data['invite'])->first();
                if(isset($receiver)){

                    $reward = new Reward;
                    $reward->receiver_id = $receiver->id;
                    $reward->sender_id   = $data['email'];
                    $reward->no          = Reward::generatevalue();
                    $reward->save();  

                    $transaction = new Transactions;
                    $transaction->operator_id =  $receiver->id;
                    $transaction->reference_id = $reward->id;
                    $transaction->type = 3;

                    $item = Setting::where('name', 'reward')->first();
                    if(isset($item)){
                        $transaction->amount = $item['value'];
                        $transaction->final_amount =  $item['value'];
                    }
                    else{
                        $transaction->amount = 10;
                        $transaction->final_amount =  10;
                    }
                    $transaction->fee_amount   =  0;
                    $transaction->transtype = 0; //in 
                    $transaction->no = Transactions::generatevalue();
                    $transaction->save();
                }
            }
            $data['usertype'] = 0;
            
            // send welocme meesage
            User::sendMessage($data['phone'], trans('app.welcome_sms', ['no'=> $data['no']])); 
            Session::flush();
            return User::create([
                'name'     => $data['name'],
                'no'       => $data['no'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'usertype' => $data['usertype'],
                'password' => bcrypt($data['password']),
            ]);     
        }
    }
}
