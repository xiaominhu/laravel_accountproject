<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, DB, Validator, Session, Redirect;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

use App\Helpers\QrcodeClass;
use Illuminate\Support\Facades\Input;
use App\Zone;
use App\User;
use App\Role;
use App\Country;
use App\Contactus;
use App\Fuelstation;
use App\Fees;
use App\Vehicle;
Use App\Setting;
Use App\Deposit;
Use App\Operation;
use App\Transactions;
Use Nexmo;
Use Excel, URL;
Use App\Subscriptionfee;
use App\Withdraw;
use App\Touchwith;
use App\Sellerrole;
use App\Sellerlogin;
use Illuminate\Support\Facades\Storage;
use App\Mail\Notification;
use App\History;
use App\Voucher;

use Mail, PDF;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    public function __construct()
    {
       // $this->middleware('auth');
    }
	 
	public function abc(){
		
		PDF::SetTitle('Hello World');
		PDF::AddPage();
	 
		PDF::SetFont('aealarabiya', '', 18);

		$lg = Array();
		$lg['a_meta_charset'] = 'UTF-8';
		$lg['a_meta_dir'] = 'rtl';
		$lg['a_meta_language'] = 'fa';
		$lg['w_page'] = 'page';
		PDF::setLanguageArray($lg);
		
		$htmlpersian = 'أنا طالب.';
		PDF::WriteHTML($htmlpersian, true, 0, true, 0);
		PDF::setRTL(false);
		PDF::SetFontSize(10);
		PDF::Output('hello_world.pdf');
		//echo Carbon::today()->toDateString();
		exit;
			$vehicles =    Transactions::where('transactions.type', 0)
									->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
									->groupBy('operation.vehicle')
									->selectRaw('*, sum(transactions.amount) as sum')
									->orderBy('sum', 'desc')
									->get();
			
			dd($vehicles);
			exit;
		
		$limit_day = Carbon::today();

		$limit_day->subDays(20);

		echo $limit_day;

		//echo trans('app.welcome_sms', ['no'=> 'dddddddddddddd']);

		//dd(User::sendMessage('966543632203', 'Hello world'));
		//$pdf = PDF::loadHTML('<h1>TestTestTestTestTestTestTestTestTestTestTestTestTestTestTestTestTestTest134</h1>')->setPaper('a4', 'landscape');
		
		//return $pdf->stream();
		
		exit;


		Excel::create('abc', function($excel) {
			
			$excel->sheet('selfstation', function($sheet) {
				$sheet->appendRow(array(
					'1', '3'
				));	
				
				$sheet->appendRow(array(
					'appended', 'appended'
				));

				$sheet->appendRow(array(
					'dfd', 'fdfd'
				));
				//$sheet->freezeFirstRow();	
			});
		})->download('pdf');
		  
		exit;

		$url = 'https://www.sms.gateway.sa/api/sendsms.php?' . http_build_query(
            [
              'username' =>  'thelargest',
              'password' => '065382212',
              'numbers' => '966501424226',
              'sender' => 'selfstation',
              'message' => 'Hi, Adel. How are you? I am huang.'
            ]
         );
       $ch = curl_init($url);
	//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
	    echo $response;
	}
	
	public function verifyemail(Request $request){
		//verifyemail
		$user = User::find(Auth::user()->id);
		$email = $user->email;

		$digits = 78;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			
			if( User::where('confirmationcode', $result)->count() == 0)
				break;
		}
	 
		$link = URL::to('email/verify/confirm') . '/' . $result;
		$user->confirmationcode =  $result;
		$user->save();
	 
		Mail::to($email)->send(new Notification('This is the email verify code.  ' .$link));
		Session::flash('emailverifysend', 'send');
		return Redirect::back()->withErrors(['msg', 'success']);
	}

	public function verifyemailconfirm($confirmationcode){
		if( ! $confirmationcode)
		{
			return redirect('/');
		}

		$user = User::whereconfirmationcode($confirmationcode)->first();
			if ( ! $user)
			{
				return redirect('/');
			}
			$user->email_verify = 1;
			$user->confirmationcode = null;
			$user->save();
		 
			Session::flash('emailverifysuccess', 'send');
			if(($user->usertype == "1") || ($user->usertype == "5"))
				return redirect('seller/login');
			else 
				return redirect('login');
	}

	public function smsrequest(Request $request){
		$user_id = Auth::user()->id;
		$user  =  User::find($user_id);
		$sellerlogin  = new Sellerlogin;
		$sellerlogin->seller_id = $user->id;
		$sellerlogin->verification_code = Sellerlogin::generatevalue();
		$sellerlogin->request_id =  Sellerlogin::generaterequestcode();
		User::sendMessage( $user->phone , trans('sms.validatoin_sms', ['verification_code'=>  $sellerlogin->verification_code ])); 

		$sellerlogin->save();
		return response()->json(array('status'=> 1, 'request_id' =>  $sellerlogin->request_id), 200);
	}

	public function smsvalidate(Request $request){
		$user_id = Auth::user()->id;
		$user  =  User::find($user_id);
		$validator =  Validator::make($request->all(), [
			'request_id' => 'required',
			'verifycode' => 'required',
		])->validate();
		
		$sellerlogin = Sellerlogin::where('verification_code', $request->verifycode)
						->where('request_id', $request->request_id)
						->where('seller_id',  $user_id)
						->first();
		if(!isset($sellerlogin)){
			return Redirect::back()->withErrors(['expiredsms'=>'expiredsms']);
		}
		$user->phone_verify = 1;
		$user->confirmationcode = null;
		$user->save();
		$sellerlogin->delete();
		return redirect('/home');
	}


	public function languages(Request $request){
 
		if($request->ajax()){
			$request->session()->put('locale', $request->locale);
		}
	}
	
	public function terms_and_conditions(){ 

		if(\Lang::getLocale() == "en")
			return view('terms_and_conditions');
		else 
			return view('terms_and_conditions-ar');
	}
	public function help(){
		return view('help');
	}
	
	public function getintouch(Request $request){
		$this->validate($request, Touchwith::rules());

		$touchwith = new Touchwith();
		$touchwith->name 	= $request->name;
		$touchwith->subject	= $request->subject;
		$touchwith->message = $request->message;
		$touchwith->email   = $request->email;
		$touchwith->no     =  Touchwith::generatevalue();
		$touchwith->save();

		Session::flash('message_sent', 'message_sent');
		return redirect('/');
	}
	
	public function frontend(Request $request){
		if(\Lang::getLocale() == "en")
			return view('home');
		else 
			return view('home-ar');
	}
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 
		 //redirect('/')->with('success', 'You are successfully logged in');
		switch(Auth::user()->usertype){
			case 0: // user
				return redirect('/user/home');
				break;
			case 1:// seller
			case 5:
				return redirect('/seller/home');
				break;
			case 2:
				return redirect('/admin/home');
				break;
			case 6:
				return redirect('/admin/usersettings');
				break;
		}
    }
	 
	public function adminindex(Request $request){
	
		//withdarawls today
		$today    = Carbon::createFromFormat('Y-m-d H:i:s',  date('Y-m-d'). " 00:00:00");
		
		$today_withdrawl = Transactions::where('transactions.created_at',  '>', date('Y-m-d'). " 00:00:00")
										->where('transactions.created_at',  '<', $today->addDay())
										->where('type', '2')
										->count();
		
		$today_deposit  =   Transactions::where('transactions.created_at',  '>', date('Y-m-d'). " 00:00:00")
										->where('transactions.created_at',  '<', $today->addDay())
										->where('type', '1')
										->count();
		
		$total_balance =   Fees::adminbalance();
		$total_balance = number_format($total_balance, 2, '.', ',');
		
		$latest_users = User::whereIn('users.usertype', ['0', '1'])->orderBy('created_at', 'DESC')->limit(3)->get();
		$latest_deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
							->where('deposit.status', 1)
							->leftJoin('users', 'users.id', '=', 'deposit.user_id')
							->orderBy('deposit.created_at', 'DESC')->limit(3)->get();
		
		return view('admin/home', compact('today_withdrawl', 'today_deposit', 'total_balance', 'latest_users', 'latest_deposits'));
	}
	
	public function sellerindex(){
		$user = User::find(Auth::user()->id);
		$message = "";
		if($user->welcome == "0"){
			$user->welcome = 1;
			$user->save();
			$message = "welcome";
			User::sendMessage($user->phone ,  trans('app.welcome_sms_message'));
			Session::flash('welcome', 'welcome');
		}

		$user_id = Sellerrole::get_seller_id(Auth::user()->id);
		$balance = Fees::checkbalance($user_id, 'current');//
		$balance = number_format($balance, 2, '.', ',');

		$today    = Carbon::createFromFormat('Y-m-d H:i:s',  date('Y-m-d'). " 00:00:00");
		$string_today = $today->toDateTimeString();	  
		$today_revenue = Operation::where('operation.owner_id', $user_id)
		                          ->where('operation.status', 1)
		                          ->select('operation.*', 'users.name')
								  ->leftJoin('users', 'users.id', '=', 'operation.sender_id')
								  ->where('operation.created_at',  '>', $string_today)
								  ->where('operation.created_at',  '<', $today->addDay())
								  ->get();
		//$top_fuelstation = Fuelstation::where('user_id')

		$result_fuelstation =   Transactions::where('transactions.type', 4)
								->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
								->leftJoin('fuelstation', 'operation.fuelstation', '=', 'fuelstation.no')					
								->groupBy('operation.fuelstation')
								->selectRaw('fuelstation.name , fuelstation.no, fuelstation.created_at ,sum(transactions.amount) as expense')
								->orderBy('expense', 'desc')
								->where('operator_id', $user_id)
								->limit(3)
								->get();
		return view('seller/home', compact('balance', 'today_revenue', 'result_fuelstation'));
	}
	 
	public function api_main(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		$user_id = $user->id;
		
		$month_expense = Transactions::where('transactions.type', 0)
								->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
								->whereDate('transactions.created_at', '>=', new Carbon('last month'))
								->where('operator_id', $user_id)
								->sum('transactions.amount');
		$month_expense = number_format($month_expense, 2, '.', ',');
		//$vehicles = Vehicle::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')->limit(3)->get();
			
		 $result_vehicles =   Transactions::where('transactions.type', 0)
									->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
									->leftJoin('vehicles', 'operation.vehicle', '=', 'vehicles.id')					
									->groupBy('operation.vehicle')
									->selectRaw('vehicles.name , sum(transactions.amount) as expense')
									->orderBy('expense', 'desc')
									->where('operator_id', $user_id)
									->limit(3)
									->get();			
		$balance = number_format(Fees::checkbalance($user_id), 2, '.', ',');
		return response()->json(['error' => 0 ,   'month_expense' => $month_expense, 'vehicles' => $result_vehicles, 'balance' => $balance]);
	}
	
	public function userindex(){
		$user = User::find(Auth::user()->id);
		if($user->welcome == "0"){
			$user->welcome = 1;
			$user->save();
			User::sendMessage($user->phone ,  trans('app.welcome_sms_message'));
			Session::flash('welcome', 'welcome');
		} 
		 
		$user_id = Auth::user()->id;
		$total_vehicle = Vehicle::where('user_id', $user_id)->count();
		$vehicles = Vehicle::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')->limit(5)->get();

		foreach($vehicles as $vehicle){
			$expense = Transactions::where('transactions.type', 0)
									 ->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
									 ->where("operation.vehicle", $vehicle->id)
									 ->whereDate('transactions.created_at', '>=', new Carbon('last month'))
									 ->sum('transactions.amount');
									
			$vehicle->expense = number_format($expense, 2, '.', ',');
		}

		$balance = Fees::checkbalance(Auth::user()->id);//
		$balance = number_format($balance, 2, '.', ',');
		return view('user/home', compact('total_vehicle', 'vehicles', 'balance'));
	}
	
	public function getcities(Request $request){
		
		$country_code = $request->country_code;
		$zones = Zone::where('country_id', $country_code)->get();
		return response()->json(array('zones'=> $zones, 'status'=> 1), 200);
	}
	 
	public function usersettings(Request $request){
		 $message = "";
		 $states = array();
		 $user = User::find(Auth::user()->id);
		 
		 $countries = Country::get();
		 $states    = Zone::where('country_id',  $user->country)->get();
		 
		 if($request->isMethod('post')){
			 
			$validator = Validator::make($request->all(),
				[ 'picture'  => 'image|mimes:jpeg,bmp,png',
				  'email'    => 'required|email',
				  'phone'    => 'required',
				  'name'     => 'required'   
				]
			)->validate();

			if ($request->hasFile('picture')) {
				$image=$request->file('picture');
				$imageName=$image->getClientOriginalName();
				$imageName = time() . $imageName;
				$image->move('images/userprofile',$imageName);
				$user->picture = $imageName;
				// change qr code
			}
			
			$user->first_name = $request->first_name;
			$user->last_name  =  $request->last_name;
			$user->phone  	  =  $request->phone;
			$user->email      =  $request->email;
			
			$user->state      =  $request->state;
			$user->country    =  $request->country;
			
			$user->save();
		 }
		 $title = trans('app.user_settings');
		 return view('admin/usersetting', compact('message', 'countries', 'states', 'title' ,'user'));
	}
	
	private function generatevalue($digits=10){
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

	// Add new employee
	public function addnewemployee(Request $request){
	 
		 $message = "";
		 $countries = Country::get();
		 if($request->isMethod('post')){
			  $validator = Validator::make($request->all(),
					[
					  'picture'  => 'image|mimes:jpeg,bmp,png',
					  'email'    => 'required|email|unique:users',
					  'name'      => 'required|max:255',
			          'phone'    	   => 'required|max:255|unique:users',
					  'password' 	   => 'required|min:6|confirmed',
					  'role' 	       => 'required',
					]
			  );
			
			if ($validator->fails()) {
				return redirect()->back()->withInput()->withErrors($validator);
			}
 
			  $user = new User;
			  if ($request->hasFile('picture')) {
					$image=$request->file('picture');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/userprofile',$imageName);
					$user->picture = $imageName;
			  }
			  $user->name   	=  $request->name;
			 
			  $user->no     	=  $this->generatevalue();
			  $user->email   	=  $request->email;
			  $user->usertype   =  6;
			  $user->password   =  bcrypt($request->password);
			  $user->phone      =  $request->phone;
			  $user->state      =  $request->state;
			  //$user->country    =  $request->country;
			  $user->save();
			  $role = new Role;
			  $role->user_id = $user->id;
			  
			  foreach($request->role as $item){
					switch($item){
						case 1:  //Manager Users
							$role->m_user = 1;
						
							break;
						case 2:   //Manager Paymentmethods
							$role->m_pay = 1;
							break;
						
						case 3:   //Manager Fees
							$role->m_fee = 1;
							break;
						
						case 4:  //Manager Operaton Deposit
							$role->m_dep = 1;
							break;
						case 5:  //Manager Coupons
							$role->m_cup = 1;
							break;
						case 6:  //Manager withdraw
							$role->m_wir = 1;
							break;
						case 7:  //Manager notification
							$role->m_not = 1;
							break;
						case 8:  //Manager notification
							$role->m_mes = 1;
							break;
						case 9:  //Manager report
							$role->m_rep = 1;
							break;
						case 10:  //Manager get in touch
							$role->m_gtc = 1;
							break;
						case 11:  //Manager subscription 
							$role->m_sub = 1;
							break;
						case 12:  //Manager attendances
							$role->m_atd = 1;
							break;
						case 13:  //Manager main_page
							$role->m_main = 1;
							break;
						case 14:  //Manager maps
							$role->m_map = 1;
							break;
						case 15:
							$role->m_qrs = 1;
							break;
						case 16:
							$role->m_vrc = 1;
							break;
					}
			}

			$role->save();
			History::addHistory(Auth::user()->id, 0, 2, $user->id);
			Session::flash('success', 'success');
		 }
		
		$states    = Zone::where('country_id',  '184')->get();
		$title = trans('app.add_new_employee');
		return view('admin/newemployee', compact('message', 'title', 'countries','states'));
	 }
	 
	public function updateemployee(Request $request, $id){

		$user =  User::where('no', $id)
				//	->leftJoin('role', 'user_id', '=', 'users.id')
					//->select('role.*', 'users.first_name', 'users.last_name', 'users.phone',  'users.usertype', 'users.state', 'users.id as userid', 'users.email','users.no')
					->first();
	  
		if(!isset($user)){
			return view("errors/404");
		}

		if($user->usertype == '6'){
			$user =  User::where('no', $id)
				->leftJoin('role', 'user_id', '=', 'users.id')
				->select('role.*', 'users.name', 'users.country', 'users.phone',  'users.usertype', 'users.state', 'users.id as userid', 'users.email','users.no')
				->first();
		}
		
		if($request->isMethod('post')){

			if($user->usertype == '6') 
				$validator = Validator::make($request->all(),
						[ 
						'picture'  => 'image|mimes:jpeg,bmp,png',
						'email'    => 'required|email',
						'name'      => 'required|max:255',
						'phone'    	   => 'required|max:255',
						'role' 	       => 'required',
						]
				);
			else
				$validator = Validator::make($request->all(),
						[ 
						'picture'  => 'image|mimes:jpeg,bmp,png',
						'email'    => 'required|email',
						'name'      => 'required|max:255',
						'phone'    	   => 'required|max:255',
					//	'role' 	       => 'required',
						]
				);


				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator);
				}
				
				if($request->email != $user->email){
					$validator = Validator::make($request->all(),
							[ 
							'email'    => 'required|email|unique:users',
							]
					);
					if ($validator->fails()) {
						return redirect()->back()->withInput()->withErrors($validator);
					}
				}
				

				if($request->phone != $user->phone){
					$validator = Validator::make($request->all(),
							[ 
							'phone'    	   => 'required|max:255|unique:users',
							]
					);
					if ($validator->fails()) {
						return redirect()->back()->withInput()->withErrors($validator);
					}
				}
 
				if ($request->hasFile('picture')) {
						$image=$request->file('picture');
						$imageName=$image->getClientOriginalName();
						$imageName = time() . $imageName;
						$image->move('images/userprofile',$imageName);
						$user->picture = $imageName;
				}
				$user->name   	=  $request->name;
				$user->email   	=  $request->email;
				
				if($request->password){
					$validator = Validator::make($request->all(),
						[
							'password' 	   => 'required|min:6|confirmed',
						]
					);
					$user->password   =  bcrypt($request->password);
				}
				 
				$user->phone      =  $request->phone;
				$user->state      =  $request->state;
				$user->save();
				 
			if($user->usertype == '6'){
				$role = Role::where('user_id', $user->userid)->first();
				
				$role->m_user = 0;
				$role->m_pay  = 0;
				$role->m_fee  = 0;
				$role->m_dep  = 0;
				$role->m_cup  = 0;
				$role->m_wir  = 0;
				$role->m_not  = 0;
				$role->m_mes  = 0;
				$role->m_rep  = 0;
				$role->m_gtc  = 0;
				$role->m_sub  = 0;
				$role->m_main = 0;
				$role->m_atd  = 0;
				$role->m_qrs  = 0;
				$role->m_vrc  = 0;
				$role->m_udr  = 0;
				$role->m_map  = 0;

				 
				foreach($request->role as $item){
						switch($item){
							case 1:  //Manager Users
								$role->m_user = 1;
								break;
							case 2:   //Manager Paymentmethods
								$role->m_pay = 1;
								break;
							case 3:   //Manager Fees
								$role->m_fee = 1;
								break;
							case 4:  //Manager Operaton Deposit
								$role->m_dep = 1;
								break;
							case 5:  //Manager Coupons
								$role->m_cup = 1;
								break;
							case 6:  //Manager withdraw
								$role->m_wir = 1;
								break;
							case 7:  //Manager notification
								$role->m_not = 1;
								break;
							case 8:  //Manager notification
								$role->m_mes = 1;
								break;
							case 9:  //Manager report
								$role->m_rep = 1;
								break;
							case 10:  //Manager get in touch
								$role->m_gtc = 1;
								break;
							case 11:  //Manager subscription 
								$role->m_sub = 1;
								break;
							case 12:  //Manager attendances
								$role->m_atd = 1;
								break;
							case 13:  //Manager main_page
								$role->m_main = 1;
								break;
							case 14:  //Manager maps
								$role->m_map = 1;
								break;
							case 15:
								$role->m_qrs = 1;
								break;
							case 16:
								$role->m_vrc = 1;
								break;
							case 17:
								$role->m_udr = 1;
								break;
					}
			}
			$role->save();
			
		}
 
			History::addHistory(Auth::user()->id, 0, 3, $user->id);
			Session::flash('success', 'success');
		}
	
		$message = "";
		$countries = Country::get();
		$states    = Zone::where('country_id',  $user->country)->get();
		$title = trans('app.update_employee');
		 
		return view('admin/newemployee', compact('message', 'user', 'title', 'countries','states')); 
	}
 
	 // getin touch
	public function admingetintouch(Request $request){
		
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		
		if($request->key !== null){
			$setting['key'] = $request->key;
			$messages = Touchwith::where('touchwith.message',  'like',  '%'. $request->key . '%')
						->orWhere('touchwith.name', 'like','%'. $request->key . '%')
						->orWhere('touchwith.no', 'like','%'. $request->key . '%')
						->orWhere('touchwith.email', 'like','%'. $request->key . '%')
						->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$messages =  Touchwith::paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($messages as $message){
				if($message->status !=  $request->{'status_' .    $message->no}){
					History::addHistory(Auth::user()->id, 7, $message->status, $message->id);
				}
				$message->status    =  $request->{'status_' .    $message->no};
				$message->save();
			}
		}
		
		$setting['pagesize'] = $page_size;
		$title = trans('app.get_in_touch');
		return view('admin/getintouch', ['messages' => $messages->appends(Input::except('page')),'title' => $title ,'setting' => $setting]);
		}
	
	public function admingetintouch_export(Request $request){
			if($request->key !== null){
				$messages = Touchwith::where('touchwith.message',  'like',  '%'. $request->key . '%')
							->orWhere('touchwith.name', 'like','%'. $request->key . '%')
							->orWhere('touchwith.email', 'like','%'. $request->key . '%')
							->orWhere('touchwith.no', 'like','%'. $request->key . '%')
							->get();
			}
			else{
				$messages =  Touchwith::all();
			}
		
			Excel::create('selfstation', function($excel)  use($messages)  {  
				$excel->sheet('getintouch', function($sheet)  use($messages)  {    
					// add header
					$sheet->appendRow(array(
						trans('app.no'), trans('app.name'), trans('app.message') , trans('app.type_message'),
							trans('app.status'), trans('app.date_created')
					));	
					
					foreach($messages as $message){
						$row = array();
						$row[] = $message->id;
						if($message->first_name)
							$row[] = $message->first_name . ' '  .$message->last_name;
						else
							$row[] = $message->name;
						
						switch($message->type){
							case 0:
								$row[]  = trans('app.technical');
								break;
							case 1:
								$row[]  =  trans('app.deposit');
								break;
							case 2:
								$row[] = trans('app.withrwal');
								break;
						}
						
						$row[]  =  $message->content;

						if($message->status)
							$row[] =  trans('app.solved');
						else
							$row[] =  trans('app.not_solved');
						
						$row[]  =  $message->created_at;


						$sheet->appendRow($row);
					}
				});
			})->download('xls');
		}

	public function admingetintouch_export_pdf(Request $request){
			if($request->key !== null){
				$messages = Touchwith::where('touchwith.message',  'like',  '%'. $request->key . '%')
							->orWhere('touchwith.name', 'like','%'. $request->key . '%')
							->orWhere('touchwith.email', 'like','%'. $request->key . '%')
							->orWhere('touchwith.no', 'like','%'. $request->key . '%')
							->get();
			}
			else{
				$messages =  Touchwith::all();
			}
			$title = trans('app.get_in_touch');
			User::downloadPDF('admin/pdf/getintouch_pdf', compact('messages', 'title')); 
	}

	public function message(Request $request){
		$id = $request->id;
		$message = Contactus::select('contactus.*', 'users.first_name', 'users.last_name', 'users.phone', 'users.email')
					->leftJoin('users', 'users.id', '=', 'contactus.user_id')
					->where('contactus.id', $id)
					->first();
		if(isset($message)){
			return response()->json(['status' => 1,   'data'=> $message]); 
		}
		else{
			return response()->json(['status' => 0,   'msg'=> "wrong_request"]); 
		}
	}

	public function messages(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		
		if($request->key !== null){
			$setting['key'] = $request->key;
			$messages = Contactus::select('contactus.type','contactus.id',  DB::raw('left(contactus.content, 21)  as content') ,'contactus.created_at', 'contactus.status','users.name')
						->leftJoin('users', 'users.id', '=', 'contactus.user_id')
						->where('contactus.content',  'like',  '%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.phone', 'like','%'. $request->key . '%')
						->orWhere('users.email', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
					     ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$messages =  Contactus::select('contactus.type','contactus.id',  DB::raw('left(contactus.content, 21)  as content') ,'contactus.created_at', 'contactus.status','users.name')
						 ->leftJoin('users', 'users.id', '=', 'contactus.user_id')
					     ->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($messages as $message){

				if($message->status !=  $request->{'status_' .    $message->id}){
					History::addHistory(Auth::user()->id, 6, $message->status, $message->id);
				}

				$message->status    =  $request->{'status_' .    $message->id};
				$message->save();
				
			}
		}
		
		$setting['pagesize'] = $page_size;
		$title = trans('app.messages');
	    return view('admin/messages', ['messages' => $messages->appends(Input::except('page')), 'title' => $title,'setting' => $setting]);
	 }
	
	public function messages_export(Request $request){
		if($request->key !== null){
			$messages = Contactus::select('contactus.*', 'users.name', 'users.first_name', 'users.last_name')
						->leftJoin('users', 'users.id', '=', 'contactus.user_id')
						->where('contactus.content',  'like',  '%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.phone', 'like','%'. $request->key . '%')
						->orWhere('users.email', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
					    ->get();
		}
		else{
			$messages =  Contactus::select('contactus.*', 'users.name', 'users.first_name', 'users.last_name')
			->leftJoin('users', 'users.id', '=', 'contactus.user_id')
			->get();
		}
		 
		Excel::create('selfstation', function($excel)  use($messages)  {  
			$excel->sheet('users', function($sheet)  use($messages)  {    
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.message') , trans('app.type_message'),
						trans('app.status'), trans('app.date_created')
				));	
				
				foreach($messages as $message){
					$row = array();
					$row[] = $message->id;
					if($message->first_name)
						$row[] = $message->first_name . ' '  .$message->last_name;
					else
						$row[] = $message->name;
					
					switch($message->type){
						case 0:
							$row[]  = trans('app.technical');
							break;
						case 1:
							$row[]  =  trans('app.deposit');
							break;
						case 2:
							$row[] = trans('app.withrwal');
							break;
					}
					 
					$row[]  =  $message->content;

					if($message->status)
						$row[] =  trans('app.solved');
					else
						$row[] =  trans('app.not_solved');
					
					$row[]  =  $message->created_at;


					$sheet->appendRow($row);
				}
			});
		})->download('xls');
	}

	public function messages_export_pdf(Request $request){
		if($request->key !== null){
			$messages = Contactus::select('contactus.*', 'users.name', 'users.first_name', 'users.last_name')
						->leftJoin('users', 'users.id', '=', 'contactus.user_id')
						->where('contactus.content',  'like',  '%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.phone', 'like','%'. $request->key . '%')
						->orWhere('users.email', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
					    ->get();
		}
		else{
			$messages =  Contactus::select('contactus.*', 'users.name', 'users.first_name', 'users.last_name')
			->leftJoin('users', 'users.id', '=', 'contactus.user_id')
			->get();
		}
		
		$title = trans('app.messages');
		User::downloadPDF('admin/pdf/messages_pdf', compact('messages', 'title'));
	}
 
	public function map(Request $request){
		$sql = "";
		$setting_val 			= array();
		$setting_val['name']    = "";
		$setting_val['country'] = "";
		$setting_val['fuel']    = array();
		$setting_val['state']   = "";
		
		
		$setting_val['lat']   = "24.71176900014207";
		$setting_val['lng']   = "46.6718788149592";
		
		
		$states = array();
		
		if(null !== $request->input('name'))
		{
			$setting_val['name'] = $request->input('name');
			
			$sql .= 'name like "' . 	$setting_val['name']  . '%"';
			
			
		}
		
		/*
		if(null !== $request->input('country')){
			$setting_val['country'] = $request->input('country');
			
			$states    = Zone::where('country_id',  $setting_val['country'])->get();
			 
			$setting_val['lat'] = Country::where('country_id' , $setting_val['country'])->first()->lat;
			$setting_val['lng'] = Country::where('country_id' , $setting_val['country'])->first()->lng;
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' country = "' . 	$setting_val['country']  . '"';
		}
		*/

		if(null !== $request->input('state'))
		{
			$setting_val['state'] = $request->input('state');
			
			if($sql != "") $sql  .= " and ";
			
			$sql .= 'state = "' . 	$setting_val['state']  . '"';

 
		   $setting_val['lat'] = Zone::where('zone_id' , $setting_val['state'])->first()->lat;
		   $setting_val['lng'] = Zone::where('zone_id' , $setting_val['state'])->first()->lng;
		   
		}
		
		if($request->fuel !== null)
		{
			$setting_val['fuel'] = $request->input('fuel');
			
			foreach($setting_val['fuel'] as $item){
				
				switch($item){
					case 1:  
						if($sql != "") 
							$sql  .= " and ";
						$sql .= ' f_g = "1"'; 
						break;
					case 2:  
						if($sql != "") 
							$sql  .= " and ";
						$sql .= ' f_r = "1"'; 
						break;
					
					case 3:  
						if($sql != "") 
							$sql  .= " and ";
						$sql .= ' f_d = "1"'; 
						break;
					
					case 4:  
						if($sql != "") 
							$sql  .= " and ";
						$sql .= ' s_o = "1"'; 
						break;
					case 5:  
						if($sql != "") 
							$sql  .= " and ";
						$sql .= ' s_w = "1"'; 
						break;
				}
				
			}
			
		 
		}
		
		
		if($sql != "")
			$fuelstations = Fuelstation::select('lat', 'lng')->whereRaw($sql)->get();
		else
			$fuelstations = Fuelstation::select('lat', 'lng')->get();
		
		$fuel_array = array();
		foreach($fuelstations as $fuelstation){
			$fuel_item = array();
			$fuel_item['lat'] = $fuelstation->lat;
			$fuel_item['lng'] = $fuelstation->lng;
			$fuel_array[] = $fuel_item;
		}
		$fuel_json = json_encode($fuel_array);
		$countries = Country::get();
		$states    = Zone::where('country_id',  '184')->get();

		$title = trans('app.maps');
		return view('admin/map', compact('countries', 'setting_val', 'states', 'fuel_json', 'title'));
	}
	
	function attendances(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$setting['pagesize'] = $page_size;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$users = User::where('usertype', 6)
						 ->where(function ($query) use ($request) {
								 $query->where('phone',  'like',  '%'. $request->key . '%')
								->orWhere('name', 'like','%'. $request->key . '%')
								->orWhere('first_name', 'like','%'. $request->key . '%')
								->orWhere('no', 'like','%'. $request->key . '%')
								->orWhere('last_name', 'like','%'. $request->key . '%'); 
					})
					->paginate($page_size);

		}
		else{
			$setting['key'] = "";
			$users = User::where('usertype', 6)->paginate($page_size);
		}

		$title =    trans('app.attendances');
		return view('admin/attendances', ['users' => $users->appends(Input::except('page')), 'title'=>$title ,'setting' => $setting]);
	}

	function attendances_export(Request $request){

		$users = User::where('usertype', 6)->get();
		Excel::create('selfstation', function($excel)  use($users)  {
			$excel->sheet('attendances', function($sheet)  use($users)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.phone') , trans('app.login_time'),
					 trans('app.logout_time')
				));	
				
				foreach($users as $user){
					$row = array();
					$row[] = $user->no;
					if($user->first_name)
						$row[] = $user->first_name . ' ' .$user->last_name;
					else
						$row[] = $user->name;
				  
					$row[] = $user->phone;
					$row[] = $user->last_login_at;
					$row[] = $user->created_at;
 
					$sheet->appendRow($row);
				}
			});
		})->download('xls');

	}
	
	function attendances_export_pdf(Request $request){
		$users = User::where('usertype', 6)->get();
		$title =    trans('app.attendances');		 
		User::downloadPDF('admin/pdf/attendances_pdf', compact('users', 'title'));
	}
	 
	function feedsmanagement(Request $request){
		$fees = Fees::paginate(10);
		if($request->isMethod('post')){
			foreach($fees as $fee){
				if(($fee->type !=  $request->{'type_' .    $fee->fee_key}) || ($fee->percent != $request->{'percent_' . $fee->fee_key}) || ($fee->fixed !=  $request->{'fixed_' .   $fee->fee_key})){
					History::addHistory(Auth::user()->id, 1, 0, $fee->id);
				}
				$fee->type    =  $request->{'type_' .    $fee->id};
				$fee->percent =  $request->{'percent_' . $fee->id};
				$fee->fixed   =  $request->{'fixed_' .   $fee->id};
				$fee->save();
			}
		}

		$sellers = User::where('usertype', 1)->where('phone_verify', 1)->get();
 
		$title = trans('app.fees_operation');
		return view('admin/feedsmanagement', compact('fees', 'title', 'sellers'));
	}

	function feesadd(Request $request){
 
		$validator = Validator::make($request->all(),
			[
				'name'   => 'required',
				'percentage' => 'required|numeric',
				'fixed_sar'  => 'required|numeric',
			]
		);

		if ($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}
		$user = User::where('no', $request->name)->where('usertype', 1)->where('phone_verify', 1)->first();
		if(!isset($user))
			return redirect()->back();
		
		$fee = Fees::where('specialuser', $user->id)->first();
	    if(!isset($fee))
			$fee 				=  new Fees(); 

		$fee->type   		=  2;
		$fee->fee_key       = 'posrev';
		$fee->fixed 		=  $request->fixed_sar;
		$fee->percent 		=  $request->percentage;
		$fee->name   		=  $user->name;
		$fee->specialuser 	=  $user->id;
		$fee->save();
	
		return redirect('/admin/feesmanagement');
	}
 
	public function subscriptionfees(Request $request){
		$subscripttionfees = Subscriptionfee::leftJoin("users", 'users.id', '=', 'subscriptionfee.name')
		->select("subscriptionfee.*", 'users.name as username')
		->paginate(5);
		if($request->isMethod('post')){
			foreach($subscripttionfees as $subscripttionfee){
					if(($subscripttionfee->amount != $request->{'amount_' .  $subscripttionfee->no}) || ($subscripttionfee->freeamount != $request->{'freeamount_' .  $subscripttionfee->no})){
						History::addHistory(Auth::user()->id, 2, 0, $subscripttionfee->id);
					}
					$subscripttionfee->amount  =  $request->{'amount_' .  $subscripttionfee->no};
					$subscripttionfee->save();
					$subscripttionfee->freeamount  =  $request->{'freeamount_' .  $subscripttionfee->no};
					$subscripttionfee->save();
			}
		}
		$title = trans('app.subscription_fees');
		return view ('admin/subscriptionfee', compact('title','subscripttionfees'));
	}

	function getusers(Request $request){
		if($request->type !== null){
			if($request->type == "user")
			{
				$users = User::where('usertype', '0')->select("no", 'name')->get();
			}elseif($request->type == "seller")
			{
				$users = User::where('usertype', '1')->select("no", 'name')->get();
			}
			else
				return response()->json(['status' => 0,   'msg'=> "wrong_request"]); 
			return response()->json(['status' => 1, 'data' => $users]); 
		}
		else{
			return response()->json(['status' => 0,   'msg'=> "wrong_request"]); 	
		}
	}

	// setting management
	public function adminsetting(Request $request){
		foreach($request->setting as $key=>$value){
			$setting_item = Setting::where('name', $key)->first();
			if(!isset($setting_item))
				$setting_item = new Setting;
			$setting_item->name  = $key;
			$setting_item->value = $value;
			$setting_item->save();
		}
	 
		return Redirect::back()->withErrors(['msg', 'success']);
	}
	
	public function reports(Request $request){
	
		$page_size = 10;
		$setting = array();
		$setting['from_amount'] = "";
		$setting['to_amount'] = "";
		$setting['from_date'] = ""; 
		$setting['to_date'] = "";

		$setting['fuelstation_seller'] = "";
		$setting['state_seller'] = "";
		$setting['city_seller'] = "";
		$setting['service_type_seller'] = "";

		
		$setting['vehicle_user'] = "";
		$setting['state_user'] = "";
		$setting['city_user'] = "";
		$setting['service_type_user'] = "";

		$setting['service_type_op'] = "";
		$setting['feesmanagement'] = '';
 
		$setting['subscription_fee_name'] = "";

		$sql = "";
		if(null !== $request->input('from_amount'))
		{
			
			$setting['from_amount'] = $request->input('from_amount');
			
		    $sql .= ' transactions.amount >= "' . 	$setting['from_amount']  . '"';
		}
		if(null !== $request->input('to_amount'))
		{

			$setting['to_amount'] = $request->input('to_amount');
			
			if($sql != "") $sql  .= " and ";
			$sql .= ' transactions.amount <= "' . 	$setting['to_amount']  . '"';
		}
		if(null !== $request->input('from_date'))
		{
			$setting['from_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('from_date'). " 00:00:00"); // 1975-05-21 22:00:00

			if($sql != "") $sql  .= " and ";
				$sql .= ' transactions.created_at > "' . 	$setting['from_date'] .'"';
		}
		
		
		if(null !== $request->input('to_date'))
		{
			$to_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			$setting['to_date'] = $to_date;
			$to_date->addDay();
			if($sql != "") $sql  .= " and ";
			$sql .= 'transactions.created_at < "' . 	$to_date .'"';
			$to_date->subDay(); 
		}

		if(null !== $request->input('feesmanagement'))
		{
			//
			switch ($request->input('feesmanagement')){
				case 'seller_type':
					$setting['feesmanagement'] = 'seller_type';
					if(null !== $request->input('fuelstation_seller'))
					{
						$setting['fuelstation_seller'] = $request->input('fuelstation_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.no = "' . 	$setting['fuelstation_seller']  . '"';
					}
				
				    if(null !== $request->input('state_seller'))
					{
						$setting['state_seller'] = $request->input('state_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.state = "' . 	$setting['state_seller']  . '"';
					}

					if(null !== $request->input('city_seller'))
					{
					
						$setting['city_seller'] = $request->input('city_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.city = "' . 	$setting['city_seller']  . '"';
					} 

					if(null !== $request->input('service_type_seller'))
					{
						$setting['service_type_seller'] = $request->input('service_type_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_seller']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "1"';
					break;
				case 'user_type':
					$setting['feesmanagement'] = 'user_type';

					if(null !== $request->input('vehicle_user'))
					{
						$setting['vehicle_user'] = $request->input('vehicle_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.no = "' . 	$setting['vehicle_user']  . '"';
					}
			
			
					if(null !== $request->input('state_user'))
					{
						$setting['state_user'] = $request->input('state_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.state = "' . 	$setting['state_user']  . '"';
					}
			
					if(null !== $request->input('city_user'))
					{
						$setting['city_user'] = $request->input('city_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.city = "' . 	$setting['city_user']  . '"';
					} 
			
				 
					if(null !== $request->input('service_type_user'))
					{
						$setting['service_type_user'] = $request->input('service_type_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_user']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "0"';
					break;
				case 'operation_fee_type':
						if(null !== $request->input('service_type_op'))
						{
							$setting['service_type_op'] = $request->input('service_type_op');
							if($sql != "") $sql  .= " and ";
							$sql .= ' transactions.type = "' . 	$setting['service_type_op']  . '"';
						}
						$setting['feesmanagement'] = 'operation_fee_type';
					break;
				case 'subscription_fee_type':
						if($sql != "") $sql  .= " and ";
						$sql  .= ' type = "5" ';
				
						if(null !== $request->input('subscription_fee_name')){
							$setting['subscription_fee_name'] = $request->input('subscription_fee_name');
							
							$sql .= ' and users.usertype = "' . 	$setting['subscription_fee_name']  . '"';
						}
						$setting['feesmanagement'] = 'subscription_fee_type';
						 
						break; 
			} 
			//dd($request->input('feesmanagement'));
		}
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$setting['pagesize'] = $page_size;

		if($sql == "") $sql = "1";
	
		if($request->key !== null){
			$setting['key'] = $request->key;
				$first   =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
							 
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('vehicles.name', 'like','%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('vehicles.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '0')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
								->whereRaw($sql);

				$second =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->where('fuelstation.name',  'like',  '%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '4')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
								->whereRaw($sql);
				
				$third =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('transactions.no', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%'); 
								})
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->whereRaw($sql);


				$transactions_query = $first->union($second)->union($third)->get();
			 
				$page = Input::get('page', 1);
				$offSet = ($page * $page_size) - $page_size;
				$itemsForCurrentPage = array_slice( json_decode(json_encode($transactions_query)), $offSet, $page_size, true);
				$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions_query), $page_size, $page);
 
		}
		else{
			$setting['key'] = "";

			if($setting['feesmanagement'] == 'seller_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name',  'transactions.fee_amount', 'transactions.id', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
 
			    ->paginate($page_size);
			}
			elseif($setting['feesmanagement'] == 'user_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name', 'users.last_name', 'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
			   ->paginate($page_size);
			}
			else{

				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name', 'transactions.final_amount', 'users.first_name', 'users.last_name',  'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
			   ->paginate($page_size);
			}
		}
		
		foreach ($transactions as $key => $value) {
			 switch ($value->type) {
				case '0':
						$vehicle = Operation::where('operation.id', $value->reference_id)
										->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
										->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
										->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name')
										->first();
						$value->details = $vehicle;
					break;
				case '4':
						$fuelstation = Operation::where('operation.id', $value->reference_id)
											->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
											->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
											->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name')
											->first();
						$value->details = $fuelstation; 
					break;
				default:
						$value->details = ""; 
					break;
			}
		}

		$fuelstations = Fuelstation::get();
		$states       = Fuelstation::select('oc_zone.zone_id', 'oc_zone.name')
									->leftJoin('oc_zone', 'oc_zone.zone_id', '=','fuelstation.state')
									->groupBy('fuelstation.state')
									->get();

		$cities       = Fuelstation::select('fuelstation.city')
									->groupBy('fuelstation.city')
									->get();
	
		$vehicles   = Vehicle::get();
		$states_user     = Vehicle::leftJoin('oc_zone', 'oc_zone.zone_id', '=','vehicles.state')
									->select('oc_zone.zone_id', 'oc_zone.name')
									->groupBy('vehicles.state')
									->get();

		$cities_user     = Vehicle::select('vehicles.city')
									->groupBy('vehicles.city')
									->get();
		$title = trans('app.reports'); 

		foreach($transactions as $transaction){
			$transaction->profit = Transactions::where('id' ,  '<=', $transaction->id)->sum('fee_amount')
								 + Transactions::where('id' ,  '<=', $transaction->id)->where('type', '5')->sum('final_amount') 
								 - Transactions::where('id' ,  '<=', $transaction->id)->whereIn('type', [3, 9, 8])->sum('final_amount');
			$transaction->profit = number_format($transaction->profit , 2, '.', ',');
		}
		
		return view('admin/reports/reports', ['transactions' => $transactions->appends(Input::except('page')), 'title'=> $title,'setting'=>$setting, 'fuelstations'=>$fuelstations, 'states'=>$states, 'cities'=>$cities, 'vehicles'=>$vehicles, 'states_user'=>$states_user, 'cities_user'=>$cities_user]);

	}	
 
	public function report_detail(Request $request, $id){
		$transaction = Transactions::where('no', $id)
								->first();
		if(!isset($transaction))
			return view('errors/404');

		if($transaction->type == "0"){
			$operation = Operation::find($transaction->reference_id);
			if(isset($operation)){
				$fuelstation =  Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
								->where('fuelstation.no', '=', $operation->fuelstation)
								->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
								->first();
 
				$vehicle = Vehicle::find($operation->vehicle);
				if(isset($fuelstation)){
					$transaction->fuelstation =  $fuelstation;
				}
				if(isset($vehicle)){
					$transaction->vehicle =  $vehicle;
				}

				$user = User::find($operation->receiver_id);
				if(isset($user)){
					$transaction->posuer = $user;
				}
			}
		}
		else if($transaction->type == "4"){
			$operation = Operation::find($transaction->reference_id);
				if(isset($operation)){
					$fuelstation = Fuelstation::where('no', $operation->fuelstation)->first();
					$vehicle = Vehicle::find($operation->vehicle);
					if(isset($fuelstation)){
						$transaction->fuelstation =  $fuelstation;
					}
					if(isset($vehicle)){
						$transaction->vehicle =  $vehicle;
					}
					$user = User::find($operation->receiver_id);
					if(isset($user)){
						$transaction->posuer = $user;
					}
				}
		}
		else if($transaction->type == "1"){
			$deposit = Deposit::select('bank.*')
							->where('deposit.id', $transaction->reference_id)
							->leftJoin('bank' ,'bank.id', '=', 'deposit.paymentid')
							->first();
			 
			$transaction->deposit = $deposit;
		}
		$title = trans('app.operation_details', ['id' => $transaction->no]);
		return view('admin/reports/details', compact('title', 'transaction'));
	}
	
	public function reports_export_pdf(Request $request){
		$setting = array();
		$setting['from_amount'] = "";
		$setting['to_amount'] = "";
		$setting['from_date'] = ""; 
		$setting['to_date'] = "";

		$setting['fuelstation_seller'] = "";
		$setting['state_seller'] = "";
		$setting['city_seller'] = "";
		$setting['service_type_seller'] = "";

		
		$setting['vehicle_user'] = "";
		$setting['state_user'] = "";
		$setting['city_user'] = "";
		$setting['service_type_user'] = "";

		$setting['service_type_op'] = "";
		$setting['feesmanagement'] = '';
 
		$setting['subscription_fee_name'] = "";

		$sql = "";
		if(null !== $request->input('from_amount'))
		{
			
			$setting['from_amount'] = $request->input('from_amount');
			
		    $sql .= ' transactions.amount >= "' . 	$setting['from_amount']  . '"';
		}
		if(null !== $request->input('to_amount'))
		{

			$setting['to_amount'] = $request->input('to_amount');
			
			if($sql != "") $sql  .= " and ";
			$sql .= ' transactions.amount <= "' . 	$setting['to_amount']  . '"';
		}
		if(null !== $request->input('from_date'))
		{
			$setting['from_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('from_date'). " 00:00:00"); // 1975-05-21 22:00:00

			if($sql != "") $sql  .= " and ";
				$sql .= ' transactions.created_at > "' . 	$setting['from_date'] .'"';
		}
		
		
		if(null !== $request->input('to_date'))
		{
			$to_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			$setting['to_date'] = $to_date;
			$to_date->addDay();
			if($sql != "") $sql  .= " and ";
			$sql .= 'transactions.created_at < "' . 	$to_date .'"';
			$to_date->subDay(); 
		}

		if(null !== $request->input('feesmanagement'))
		{
			//
			switch ($request->input('feesmanagement')){
				case 'seller_type':
					$setting['feesmanagement'] = 'seller_type';
					if(null !== $request->input('fuelstation_seller'))
					{
						$setting['fuelstation_seller'] = $request->input('fuelstation_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.no = "' . 	$setting['fuelstation_seller']  . '"';
					}
				
				    if(null !== $request->input('state_seller'))
					{
						$setting['state_seller'] = $request->input('state_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.state = "' . 	$setting['state_seller']  . '"';
					}

					if(null !== $request->input('city_seller'))
					{
					
						$setting['city_seller'] = $request->input('city_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.city = "' . 	$setting['city_seller']  . '"';
					} 

					if(null !== $request->input('service_type_seller'))
					{
						$setting['service_type_seller'] = $request->input('service_type_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_seller']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "1"';
					break;
				case 'user_type':
					$setting['feesmanagement'] = 'user_type';

					if(null !== $request->input('vehicle_user'))
					{
						$setting['vehicle_user'] = $request->input('vehicle_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.no = "' . 	$setting['vehicle_user']  . '"';
					}
			
			
					if(null !== $request->input('state_user'))
					{
						$setting['state_user'] = $request->input('state_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.state = "' . 	$setting['state_user']  . '"';
					}
			
					if(null !== $request->input('city_user'))
					{
						$setting['city_user'] = $request->input('city_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.city = "' . 	$setting['city_user']  . '"';
					} 
			
				 
					if(null !== $request->input('service_type_user'))
					{
						$setting['service_type_user'] = $request->input('service_type_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_user']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "0"';
					break;
				case 'operation_fee_type':
						if(null !== $request->input('service_type_op'))
						{
							$setting['service_type_op'] = $request->input('service_type_op');
							if($sql != "") $sql  .= " and ";
							$sql .= ' transactions.type = "' . 	$setting['service_type_op']  . '"';
						}
						$setting['feesmanagement'] = 'operation_fee_type';
					break;
				case 'subscription_fee_type':
						if($sql != "") $sql  .= " and ";
						$sql  .= ' type = "5" ';
				
						if(null !== $request->input('subscription_fee_name')){
							$setting['subscription_fee_name'] = $request->input('subscription_fee_name');
							
							$sql .= ' and users.usertype = "' . 	$setting['subscription_fee_name']  . '"';
						}
						$setting['feesmanagement'] = 'subscription_fee_type';
						 
						break; 
			} 
			//dd($request->input('feesmanagement'));
		}
		 
		if($sql == "") $sql = "1";
	
		if($request->key !== null){
				$first   =  DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
							 
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('vehicles.name', 'like','%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('vehicles.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '0')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
								->whereRaw($sql);

				$second =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->where('fuelstation.name',  'like',  '%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '4')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
								->whereRaw($sql);
				
				$third =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('transactions.no', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%'); 
								})
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->whereRaw($sql);


				$transactions = $first->union($second)->union($third)->get();
			  
		}
		else{
			if($setting['feesmanagement'] == 'seller_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name',  'transactions.fee_amount', 'transactions.id', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
			    ->get();
			}
			elseif($setting['feesmanagement'] == 'user_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name', 'users.last_name', 'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
			    ->get();
			}
			else{

				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name', 'transactions.final_amount', 'users.first_name', 'users.last_name',  'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
			    ->get();
			}
		}
		
		  

		foreach ($transactions as $key => $value){
			switch ($value->type) {
			   case '0':
					    $vehicle = Operation::where('operation.id', $value->reference_id)
									   ->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
									   ->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
									   ->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name')
									   ->first();
					    $value->details = $vehicle;
				   break;
			   case '4':
					   $fuelstation = Operation::where('operation.id', $value->reference_id)
										   ->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
										   ->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
										   ->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name')
										   ->first();
					   $value->details = $fuelstation; 
				   break;
			   default:
					$value->details  = null;
				   break;
		   }
			$value->profit = Transactions::where('id' ,  '<=', $value->id)->sum('fee_amount')
								 + Transactions::where('id' ,  '<=', $value->id)->where('type', '5')->sum('final_amount') 
								 - Transactions::where('id' ,  '<=', $value->id)->whereIn('type', [3, 9, 8])->sum('final_amount');
			$value->profit = number_format($value->profit , 2, '.', ',');
		}
		$title = trans('app.reports');
		
		 
		 
		User::downloadPDF('admin/pdf/reports_pdf', compact('transactions', 'title'));
	}

	public function reports_export(Request $request){
		$setting = array();
		$setting['from_amount'] = "";
		$setting['to_amount'] = "";
		$setting['from_date'] = ""; 
		$setting['to_date'] = "";

		$setting['fuelstation_seller'] = "";
		$setting['state_seller'] = "";
		$setting['city_seller'] = "";
		$setting['service_type_seller'] = "";

		
		$setting['vehicle_user'] = "";
		$setting['state_user'] = "";
		$setting['city_user'] = "";
		$setting['service_type_user'] = "";

		$setting['service_type_op'] = "";
		$setting['feesmanagement'] = '';
 
		$setting['subscription_fee_name'] = "";

		$sql = "";
		if(null !== $request->input('from_amount'))
		{
			
			$setting['from_amount'] = $request->input('from_amount');
			
		    $sql .= ' transactions.amount >= "' . 	$setting['from_amount']  . '"';
		}
		if(null !== $request->input('to_amount'))
		{

			$setting['to_amount'] = $request->input('to_amount');
			
			if($sql != "") $sql  .= " and ";
			$sql .= ' transactions.amount <= "' . 	$setting['to_amount']  . '"';
		}
		if(null !== $request->input('from_date'))
		{
			$setting['from_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('from_date'). " 00:00:00"); // 1975-05-21 22:00:00

			if($sql != "") $sql  .= " and ";
				$sql .= ' transactions.created_at > "' . 	$setting['from_date'] .'"';
		}
		
		
		if(null !== $request->input('to_date'))
		{
			$to_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			$setting['to_date'] = $to_date;
			$to_date->addDay();
			if($sql != "") $sql  .= " and ";
			$sql .= 'transactions.created_at < "' . 	$to_date .'"';
			$to_date->subDay(); 
		}

		if(null !== $request->input('feesmanagement'))
		{
			//
			switch ($request->input('feesmanagement')){
				case 'seller_type':
					$setting['feesmanagement'] = 'seller_type';
					if(null !== $request->input('fuelstation_seller'))
					{
						$setting['fuelstation_seller'] = $request->input('fuelstation_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.no = "' . 	$setting['fuelstation_seller']  . '"';
					}
				
				    if(null !== $request->input('state_seller'))
					{
						$setting['state_seller'] = $request->input('state_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.state = "' . 	$setting['state_seller']  . '"';
					}

					if(null !== $request->input('city_seller'))
					{
					
						$setting['city_seller'] = $request->input('city_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' fuelstation.city = "' . 	$setting['city_seller']  . '"';
					} 

					if(null !== $request->input('service_type_seller'))
					{
						$setting['service_type_seller'] = $request->input('service_type_seller');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_seller']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "1"';
					break;
				case 'user_type':
					$setting['feesmanagement'] = 'user_type';

					if(null !== $request->input('vehicle_user'))
					{
						$setting['vehicle_user'] = $request->input('vehicle_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.no = "' . 	$setting['vehicle_user']  . '"';
					}
			
			
					if(null !== $request->input('state_user'))
					{
						$setting['state_user'] = $request->input('state_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.state = "' . 	$setting['state_user']  . '"';
					}
			
					if(null !== $request->input('city_user'))
					{
						$setting['city_user'] = $request->input('city_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' vehicles.city = "' . 	$setting['city_user']  . '"';
					} 
			
				 
					if(null !== $request->input('service_type_user'))
					{
						$setting['service_type_user'] = $request->input('service_type_user');
						
						if($sql != "") $sql  .= " and ";
						$sql .= ' transactions.type = "' . 	$setting['service_type_user']  . '"';
					} 

					if($sql != "") $sql  .= " and ";
						$sql .= ' users.usertype = "0"';
					break;
				case 'operation_fee_type':
						if(null !== $request->input('service_type_op'))
						{
							$setting['service_type_op'] = $request->input('service_type_op');
							if($sql != "") $sql  .= " and ";
							$sql .= ' transactions.type = "' . 	$setting['service_type_op']  . '"';
						}
						$setting['feesmanagement'] = 'operation_fee_type';
					break;
				case 'subscription_fee_type':
						if($sql != "") $sql  .= " and ";
						$sql  .= ' type = "5" ';
				
						if(null !== $request->input('subscription_fee_name')){
							$setting['subscription_fee_name'] = $request->input('subscription_fee_name');
							
							$sql .= ' and users.usertype = "' . 	$setting['subscription_fee_name']  . '"';
						}
						$setting['feesmanagement'] = 'subscription_fee_type';
						 
						break; 
			} 
			//dd($request->input('feesmanagement'));
		}
		 
		if($sql == "") $sql = "1";
	
		if($request->key !== null){
				$first   =  DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
							 
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('vehicles.name', 'like','%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('vehicles.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '0')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
								->whereRaw($sql);

				$second =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%')
										->where('fuelstation.name',  'like',  '%'. $request->key . '%')
										->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
										->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
								})
								->where('transactions.type', '4')
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
								->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
								->whereRaw($sql);
				
				$third =     DB::table("transactions")->orderBy('transactions.created_at')
								->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no','transactions.id', 'transactions.fee_amount', 'transactions.type','transactions.final_amount', 'transactions.reference_id', 'users.usertype', 'transactions.amount',  'transactions.final_amount', 'transactions.created_at as regdate')
								->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
								->where(function ($query) use ($request) {
									$query->where('users.name', 'like','%'. $request->key . '%')
										->orWhere('users.first_name', 'like','%'. $request->key . '%')
										->orWhere('users.phone', 'like','%'. $request->key . '%')
										->orWhere('transactions.no', 'like','%'. $request->key . '%')
										->orWhere('users.last_name', 'like','%'. $request->key . '%'); 
								})
								->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
								->whereRaw($sql);


				$transactions = $first->union($second)->union($third)->get();
			  
		}
		else{
			if($setting['feesmanagement'] == 'seller_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name',  'transactions.fee_amount', 'transactions.id', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
			    ->get();
			}
			elseif($setting['feesmanagement'] == 'user_type'){
				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name',  'transactions.final_amount','users.first_name', 'users.last_name', 'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
				->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
				->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
				->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
			    ->get();
			}
			else{

				$transactions = Transactions::orderBy('transactions.created_at')
				->select('users.name', 'transactions.final_amount', 'users.first_name', 'users.last_name',  'transactions.id', 'transactions.fee_amount','transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
				->leftJoin('users' ,'transactions.operator_id', '=', 'users.id')
				->whereRaw($sql)
			    ->get();
			}
		}

 
		Excel::create('selfstation', function($excel)  use($transactions)  {
			$excel->sheet('users', function($sheet)  use($transactions)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.vehicle') . '/' . trans('app.fuelstation') , trans('app.operation_type'),
					trans('app.fees_type') . ' ' .  trans('app.operation') , trans('app.fees_type') . ' ' .  trans('app.subscription'),  trans('app.state'),
					trans('app.city'), trans('app.amount'),  trans('app.final_amount'), trans('app.admin_profit'), trans('app.sum'), trans('app.date_opration')
				));
				
				foreach ($transactions as $key => $value) {

					switch ($value->type) {
						case '0':
								$vehicle = Operation::where('operation.id', $value->reference_id)
												->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
												->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
												->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name')
												->first();
								$value->details = $vehicle;
							break;
						case '4':
								$fuelstation = Operation::where('operation.id', $value->reference_id)
													->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
													->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
													->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name')
													->first();
								$value->details = $fuelstation; 
							break;
						default:
							break;
					}

					$row = array();
					$row[] = $value->no;
					if($value->first_name)
						$row[] = $value->first_name . $value->last_name;
					else
						$row[] = $value->name;
				 
					if($value->details !== null)
						$row[] =  $value->details->name;
					else 	$row[] = "";
					
					switch($value->type){
						case 0:
							$row[]  = trans('app.pos_payment');
							$row[]  = trans('app.pos_payment');
							break;
						case 1:
							$row[]  =  trans('app.deposit');
							$row[]  =  trans('app.deposit');
							break;
						case 2:
							$row[] = trans('app.withdrawl');
							$row[] = trans('app.withdrawl');
							break;
						case 3:
							$row[] = trans('app.reward');
							$row[] = trans('app.reward');
							break;
						case 4:
							$row[] = trans('app.pos_revenue');
							$row[] = trans('app.pos_revenue');
							break;
					}
					
					if($value->usertype == 0)
						$row[] = trans('app.user');
				 
					if($value->usertype == 1)
						$row[] = trans('app.seller');
					 

				 
					if($value->details !== null)
						$row[] = $value->details->state;
					else $row[] = "";

				
					if($value->details !== null)
						$row[] = $value->details->city;
					else	$row[] = "";

					$row[] = $value->amount;
					$row[] = $value->final_amount;
					$row[] = $value->fee_amount;
				
					$value->profit = Transactions::where('id' ,  '<=', $value->id)->sum('fee_amount')
								 + Transactions::where('id' ,  '<=', $value->id)->where('type', '5')->sum('final_amount') 
								 - Transactions::where('id' ,  '<=', $value->id)->whereIn('type', [3, 9, 8])->sum('final_amount');
					$value->profit = number_format($value->profit , 2, '.', ',');
			
					$row[] = $value->profit;
					$row[] = $value->regdate;
					
					$sheet->appendRow($row);
				}
			});
		})->download('xls');


	}

	public function addsubscription(Request $request){
		$this->validate($request, Subscriptionfee::rules());
		$usertype = $request->usertype;
		$name = $request->name;
		$subscriptionfee = Subscriptionfee::where("name", $name)
										  ->where("usertype", $usertype)
										  ->first();
		if($subscriptionfee !== null)
			$subscriptionfee = $subscriptionfee;
		else{

			$user = User::where('no', $name)->first();
			if(!isset($user)) return view("errors/404");

			$subscriptionfee = new Subscriptionfee;
			$subscriptionfee->no = Subscriptionfee::generatevalue();
			$subscriptionfee->usertype = $usertype;
			$subscriptionfee->name   = $user->id;
			$subscriptionfee->amount = $request->amount; 
 
		}

		if($usertype == 0){
			$subscriptionfee->freecondition = 1;
			$subscriptionfee->freeamount    = $request->freeamount;
		}
	
		$subscriptionfee->amount = $request->amount;
		$subscriptionfee->save();

		History::addHistory(Auth::user()->id, 2,  1, $subscriptionfee->id);
		
		return redirect('/admin/feesmanagement/subscription');
	}

	public function adminsettings(Request $request){
		if($request->isMethod('post')){
			foreach($request->setting as $key=>$value){

				$setting_item = Setting::where('name', $key)->first();
				if(!isset($setting_item))
					$setting_item = new Setting;
				$setting_item->name  = $key;
				$setting_item->value = $value;
				$setting_item->save();
			}
		}

		$settings_array = Setting::all();
		$settings  = array();
		foreach($settings_array as $setting){
			$settings[$setting->name] = $setting->value; 
		}
		$title =trans('app.setting');
		return view('admin/adminsetting', compact('settings', 'title'));
	}

	// history
	public function history(Request $request){
		$settings  = array();
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		
			if($request->key !== null){ 
				$setting['key'] = $request->key;
				
				$histories = History::where(function ($query) use ($request) {
									 $query->where('users.phone',  'like',  '%'. $request->key . '%')
									->orWhere('users.name', 'like','%'. $request->key . '%')
									->orWhere('users.first_name', 'like','%'. $request->key . '%')
									->orWhere('history.no', 'like','%'. $request->key . '%')
									->orWhere('users.last_name', 'like','%'. $request->key . '%'); 
						})
						->leftJoin('users', 'users.id', '=', 'history.reference_id')
						->select('history.*')
						->paginate($page_size);
 
			}
			else{
				$setting['key'] = "";
				$histories = History::paginate($page_size);
			}

		$title = trans('app.history');
		$setting['pagesize'] = $page_size;

		foreach($histories as $history){
			/*
				0: user management 0: deactive, 1: active, 2 : add new employee 3: change employee info
				1: fees operation  
				2: subscriptio operatoin  0: change, 1: add
				3: deposit 0: deactive, 1: active, 2 : add new deposit
				4: withdraw   0: deactive, 1: active, 2 : add new withdrawl
				5: notification  
				6: message    1: solve, 0: resolve
				7: get in touch  1: solve, 0: resolve
				8:  qrcode active 1: active, 1: in active
				*/
			$user = User::find($history->user_id);
			if(!isset($user)) continue;

			switch($history->opeartiontype){
				case 0:
					$refer_user = User::where( 'id' , $history->reference_id)->first();
					if(isset($refer_user)){					 
						$history->details = trans('app.history_user_type_' . $history->action , ['name' => $user->name, 'user' => $refer_user->name]);
					}
					break;
				case 1: 
					$refer_user = Fees::where( 'id' , $history->reference_id)->first();
					if(isset($refer_user)){					 
						$history->details = trans('app.history_fees_type_0', ['name' => $user->name, 'no' => $refer_user->name]);
					}
					break;
				case 2: 
					$refer_user = Subscriptionfee::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_subscript_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->no]);
					}
					break;
				case 3: 
					$refer_user = Deposit::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_deposit_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->no]);
					}
					break;
				case 4: 
					$refer_user = Withdraw::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_withdraw_' . $history->action , ['name' => $user->name, 'no' => $refer_user->no]);
					}
					break;
				case 5: 
						$refer_user = Vehicle::where( 'id' , $history->reference_id)->first();
						if(isset($refer_user)){					 
							$history->details = trans('app.history_notification_type_0', ['name' => $user->name, 'no' => $refer_user->name]);
						}
					break;
				case 6: 
						$refer_user = Contactus::find($history->reference_id);
						if(isset($refer_user)){					 
							$history->details = trans('app.history_message_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->id]);
						}
					break;
				case 7: 
					$refer_user = Touchwith::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_touchwith_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->no]);
					}
					break;
				case 8: 
					$refer_user = Vehicle::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_qrstatus_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->no]);
					}
					break;
				case 9:
				 
					$refer_user = Voucher::find($history->reference_id);
					if(isset($refer_user)){					 
						$history->details = trans('app.history_voucher_type_' . $history->action , ['name' => $user->name, 'no' => $refer_user->code]);
					}
					break;
			}
		}

		return view('admin/history', ['histories' => $histories->appends(Input::except('page')),'title' => $title ,'setting' => $setting]);
		

	}
}
