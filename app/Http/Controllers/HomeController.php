<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, DB, Validator, Session, Redirect;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;


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
Use Excel;

use Illuminate\Support\Facades\Storage;
use App\Mail\Notification;
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
		})->download('xls');
		 


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
	
	public function languages(Request $request){
		if($request->ajax()){
			$request->session()->put('locale', $request->locale);
		}
	}
	
	public function terms_and_conditions(){
		return view('terms_and_conditions');
	}
	public function help(){
		return view('help');
	}
	
	
	public function frontend(Request $request){
		return view('home');
	}
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		switch(Auth::user()->usertype){
			case 0: // user
				return redirect('/user/home');
				break;
			case 1:// seller
				return redirect('/seller/home');
				break;
			case 2:
				return redirect('/admin/home');
				break;
		}
    }
	
	public function adminindex(){
		
		return view('admin/home');
	}
	
	public function sellerindex(){
		$balance = Fees::checkbalance(Auth::user()->id, 'current');//
		
		
		$today_revenue = Operation::where('operation.receiver_id', Auth::user()->id)
		                          ->where('operation.status', 1)
		                          ->select('operation.*', 'users.name')
								  ->leftJoin('users', 'users.id', '=', 'operation.sender_id')
								  ->get();
		return view('seller/home', compact('balance', 'today_revenue'));
	}
	 
	public function api_main(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		$user_id = $user->id;
		
		$month_expense = 4000;
		$vehicles = Vehicle::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')->limit(5)->get();
		
		$result_vehicles = array();
		
		foreach($vehicles as $vehicle){
			$item = array();
			$item['name']  = $vehicle->name;
			$item['model'] = $vehicle->name;
			$item['type']  = $vehicle->name;
			$item['expense']  = 500;
			$result_vehicles [] = $item;
		}
		
		$balance = Deposit::where('user_id', '=', $user_id)->where('status', '1')->sum('amount');//
		
		return response()->json(['error' => 0 ,   'month_expense' => $month_expense, 'vehicles' => $vehicles, 'balance' => $balance]);
	}
	
	public function userindex(){
		$user_id = Auth::user()->id;
		$total_vehicle = Vehicle::where('user_id', $user_id)->count();
		$vehicles = Vehicle::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')->limit(5)->get();

		foreach($vehicles as $vehicle){
			$vehicle->expense = Transactions::where('transactions.type', 0)
										 ->leftJoin("operation", "operation.id", "=", "transactions.reference_id")
										 ->where("operation.vehicle", $vehicle->id)
										 ->whereDate('transactions.created_at', '>=', new Carbon('last month'))
										 ->sum('transactions.amount');

	
		}

		$balance = Fees::checkbalance(Auth::user()->id);//
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
			          'phone'    => 'required'
					]
			  )->validate();
			 
			
			if ($request->hasFile('picture')) {
				$image=$request->file('picture');
				$imageName=$image->getClientOriginalName();
				$imageName = time() . $imageName;
				$image->move('images/userprofile',$imageName);
				$user->picture = $imageName;
			}
			
			$user->first_name = $request->first_name;
			$user->last_name  =  $request->last_name;
			$user->phone  	  =  $request->phone;
			$user->email      =  $request->email;
			
			$user->state      =  $request->state;
			$user->country    =  $request->country;
			
			$user->save();
		 }
		 
		 return view('admin/usersetting', compact('message', 'countries', 'states', 'user'));
	}
	 
	// Add new employee
	 public function addnewemployee(Request $request){
		 $message = "";
		 $countries = Country::get();
		 if($request->isMethod('post')){
			  $validator = Validator::make($request->all(),
					[ 'picture'  => 'image|mimes:jpeg,bmp,png',
					  'email'    => 'required|email',
					  'first_name'     => 'required|max:255',
					  'last_name'      => 'required|max:255',
			          'phone'    	   => 'required|max:255|unique:users',
					  'password' 	   => 'required|min:6|confirmed',
					]
			  )->validate();
			  
			  $user = new User;
			  if ($request->hasFile('picture')) {
					$image=$request->file('picture');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/userprofile',$imageName);
					$user->picture = $imageName;
			  }
			  $user->name   	=  $request->first_name . ' ' . $request->last_name;
			  $user->no     	=  $this->generatevalue();
			  $user->email   	=  $request->email;
			  $user->usertype   =  2;
			  $user->password   =  bcrypt($request->password);
			  $user->phone      =  $request->phone;
			  $user->state      =  $request->state;
			  $user->country    =  $request->country;
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
						case 5:  //Manager Operatons
							$role->m_opr = 1;
							break;
						case 6:  //Manager Operatons
							$role->m_wir = 1;
							break;
						case 7:  //Manager Operatons
							$role->m_not = 1;
							break;
					}
			}
			$role->save();
		 }
		 return view('admin/newemployee', compact('message', 'countries'));
	 }
	 
	 public function messages(Request $request){
		 
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		
		if($request->key !== null){
			$setting['key'] = $request->key;
			$messages = Contactus::select('contactus.*', 'users.name')
						->leftJoin('users', 'users.id', '=', 'contactus.user_id')
						->where('contactus.content',  'like',  '%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
					     ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$messages =  Contactus::select('contactus.*', 'users.name')
						 ->leftJoin('users', 'users.id', '=', 'contactus.user_id')
					     ->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($messages as $message){
				
				$message->status    =  $request->{'status_' .    $message->id};
				$message->save();
				
			}
		}
		
		$setting['pagesize'] = $page_size;
		
	    return view('admin/messages', ['messages' => $messages->appends(Input::except('page')), 'setting' => $setting]);
	 }
	
	public function messages_export(Request $request){
		$messages =  Contactus::select('contactus.*', 'users.name', 'users.first_name', 'users.last_name')
			->leftJoin('users', 'users.id', '=', 'contactus.user_id')
			->get();

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
		
		
		if(null !== $request->input('country')){
			$setting_val['country'] = $request->input('country');
			
			$states    = Zone::where('country_id',  $setting_val['country'])->get();
			 
			$setting_val['lat'] = Country::where('country_id' , $setting_val['country'])->first()->lat;
			$setting_val['lng'] = Country::where('country_id' , $setting_val['country'])->first()->lng;
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' country = "' . 	$setting_val['country']  . '"';
		}
		
		if(null !== $request->input('state'))
		{
			$setting_val['state'] = $request->input('state');
			
			if($sql != "") $sql  .= " and ";
			
			$sql .= 'state = "' . 	$setting_val['state']  . '"';
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
			
			
			//$setting_val['service_name'] = Services::find($setting_val['service'])->name;
			//$sql = 'booking.service = "' . 	$setting_val['service']  . '"';
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
		return view('admin/map', compact('countries', 'setting_val', 'states', 'fuel_json'));
	}
	
	function attendances(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$users = User::where('usertype', 2)->paginate($page_size);
		$setting['pagesize'] = $page_size;
		return view('admin/attendances', ['users' => $users->appends(Input::except('page')), 'setting' => $setting]);
	}

	function attendances_export(Request $request){

		$users = User::where('usertype', 2)->get();

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
	
	function feedsmanagement(Request $request){
		$fees = Fees::all();
		if($request->isMethod('post')){
			foreach($fees as $fee){
				$fee->type    =  $request->{'type_' .    $fee->fee_key};
				$fee->percent =  $request->{'percent_' . $fee->fee_key};
				$fee->fixed   =  $request->{'fixed_' .   $fee->fee_key};
				$fee->save();
			}
		}
		return view('admin/feedsmanagement', compact('fees'));
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
			$setting['to_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			
			if($sql != "") $sql  .= " and ";
			$sql .= 'transactions.created_at < "' . 	$setting['to_date'] .'"';
		}

		if(null !== $request->input('feesmanagement'))
		{
			//	
		}
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$setting['pagesize'] = $page_size;

		if($sql == "") $sql = "1";

		if($request->key !== null){
			$setting['key'] = $request->key;
			$transactions = Transactions::orderBy('transactions.created_at')
							->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
						->leftJoin( 'users' ,'transactions.operator_id', '=', 'users.id')
						->where(function ($query) use ($request) {
								 $query->where('users.name', 'like','%'. $request->key . '%')
									->orWhere('users.first_name', 'like','%'. $request->key . '%')
									->orWhere('users.last_name', 'like','%'. $request->key . '%'); 
						})
						->whereRaw($sql)
						->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$transactions = Transactions::orderBy('transactions.created_at')
						->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
						->leftJoin( 'users' ,'transactions.operator_id', '=', 'users.id')
						 ->whereRaw($sql)
						->paginate($page_size);
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
					break;
			}
		}
		//return view('seller/reports/reports', compact('setting', 'operations', 'fuelstations', 'states', 'cities'));
		return view('admin/reports', compact('setting', 'transactions'));
	}	


	public function reports_export(Request $request){
		$transactions = Transactions::orderBy('transactions.created_at')
			->select('users.name', 'users.first_name', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
			->leftJoin( 'users' ,'transactions.operator_id', '=', 'users.id')
			->get();

 
		Excel::create('selfstation', function($excel)  use($transactions)  {
			$excel->sheet('users', function($sheet)  use($transactions)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.vehicle') . '/' . trans('app.fuelstation') , trans('app.operation_type'),
					trans('app.fees_type') . ' ' .  trans('app.operation') , trans('app.fees_type') . ' ' .  trans('app.subscription'),  trans('app.state'),
					trans('app.city'), trans('app.amount'), trans('app.cidate_oprationty')
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
					$row[] = $value->regdate;
					
					 
					$sheet->appendRow($row);
				}
			});
		})->download('xls');


	}

}
