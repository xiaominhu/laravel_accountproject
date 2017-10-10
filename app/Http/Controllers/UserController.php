<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Contactus;
use App\Fuelstation;
use App\Country;
use App\Zone;
use App\Paymentmanager;
use App\Operation;
use App\Vehicle;
use App\Deposit;
use Carbon\Carbon;
use Auth, Validator, URL, Nexmo, Response, Redirect;
use Illuminate\Support\Facades\Input;
use App\Transactions;
use App\Helpers\QrcodeClass;
use App\Sendmoney;
use App\Fees;
use Mail;
use App\Mail\Notification;

use Excel, Session;

class UserController extends Controller{
    //
	public function admin_browser(Request $request){
		
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$users = User::paginate($page_size);
		$setting['pagesize'] = $page_size;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$users = User::where('usertype', '!=' ,'4')
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
			$users = User::where('usertype', '!=' ,'4')->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($users as $user){
				$user->status    =  $request->{'status_' .    $user->no};
				$user->save();
			}
		}
		return view('admin/users', ['users' => $users->appends(Input::except('page')), 'setting' => $setting]);
	}


	public function admin_browser_export(Request $request){

			$users = User::where('usertype', '!=' ,'4')->get();

		 
			Excel::create('selfstation', function($excel)  use($users)  {
				$excel->sheet('users', function($sheet)  use($users)  {
					
					// add header
					$sheet->appendRow(array(
						trans('app.no'), trans('app.name'), trans('app.email') , trans('app.phone'), trans('app.type'),
						trans('app.status'), trans('app.email_approve'), trans('app.phone_approve'), trans('app.last_login'), trans('app.reg_date')
					));	
					
					foreach($users as $user){
						$row = array();
						$row[] = $user->no;
						if($user->first_name)
							$row[] = $user->first_name . $user->last_name;
						else
							$row[] = $user->name;
						$row[] = $user->email;
						$row[] = $user->phone;

						switch($user->usertype){
							case 0:
								$row[]  = trans('app.user');
								break;
							case 1:
								$row[]  =  trans('app.seller');
								break;
							case 2:
								$row[] = trans('app.admin');
								break;
						}

						if($user->status == 1) $row[]  =  trans('app.activated');
						else                   $row[]  =  trans('app.deactivated');

						if($user->email_verify == 1) $row[]  =  trans('app.yes');
						else                         $row[]  =  trans('app.no_en');

						if($user->phone_verify == 1) $row[]  =  trans('app.yes');
						else                         $row[]  =  trans('app.no_en');

						$row[] = $user->last_login_at;
						$row[] = $user->created_at;
						$sheet->appendRow($row);
					}

				});
			})->download('xls');

	}

	public function statement(Request $request, $id){
		$user = User::where('no', $id)->first();

		//5971264575
		 

		if(isset($user)){

		
			$setting = array();
			$setting['id'] = $id;
			$page_size = 10;
 

			if($user->usertype == 0){ //  user

			 
				
				if(isset($_GET['pagesize']))
					$page_size = $_GET['pagesize'];
				$setting['pagesize'] = $page_size;
				if($request->key !== null){

					$setting['key'] = $request->key;
					$users =    Transactions::where('operator_id', $user->id)
								 ->where(function ($query) use ($request) {
										 $query->where('phone',  'like',  '%'. $request->key . '%')
										->orWhere('name', 'like','%'. $request->key . '%')
										->orWhere('first_name', 'like','%'. $request->key . '%')
										->orWhere('last_name', 'like','%'. $request->key . '%'); 
							})
							->paginate($page_size);
				}
				else{
					$setting['key'] = "";
					$transactions = Transactions::where('operator_id', $user->id)
									->leftJoin("users", 'users.id', '=', 'transactions.operator_id')
									->select('transactions.no', 'users.first_name', 'users.last_name', 'users.name', 'users.phone', 'transactions.type', 'transactions.amount', 'transactions.created_at as operation_date', 'transactions.attachment')
									->get();
				}
				return view('admin/usersstatement', ['setting'=> $setting, 'transactions' => $transactions]);

				
			}
			if($user->usertype == 1){ // seller
				if(isset($_GET['pagesize']))
					$page_size = $_GET['pagesize'];
				$setting['pagesize'] = $page_size;
				if($request->key !== null){
					$setting['key'] = $request->key;
					$users =  Transactions::where('operator_id', $user->id)
								 ->where(function ($query) use ($request) {
									//	 $query->where('phone',  'like',  '%'. $request->key . '%')
									//	->orWhere('name', 'like','%'. $request->key . '%')
									//	->orWhere('first_name', 'like','%'. $request->key . '%')
									//	->orWhere('last_name', 'like','%'. $request->key . '%'); 
							})
							->leftJoin("users", 'users.id', '=', 'transactions.operator_id')
							->select('transactions.no', 'users.first_name', 'users.last_name', 'users.name', 'users.phone', 'transactions.type', 'transactions.amount', 'transactions.created_at as operation_date', 'transactions.attachment')
							->paginate($page_size);

				}
				else{
					$setting['key'] = "";
					$transactions = Transactions::where('operator_id', $user->id)
									->leftJoin("users", 'users.id', '=', 'transactions.operator_id')
									->select('transactions.no', 'users.first_name', 'users.last_name', 'users.name', 'users.phone', 'transactions.type', 'transactions.amount', 'transactions.created_at as operation_date', 'transactions.attachment')
									->get();
				}

				return view('admin/sellerstatement', ['setting'=> $setting, 'transactions' => $transactions]);
			}
		}	

		return view('errors/404');
	}

	public function statement_export(Request $request, $id){
		$user = User::where('no', $id)->first();
		if(isset($user)){
			 
				$transactions = Transactions::where('operator_id', $user->id)
					->leftJoin("users", 'users.id', '=', 'transactions.operator_id')
					->select('transactions.no', 'users.first_name', 'users.last_name', 'users.name', 'users.phone', 'transactions.type', 'transactions.amount', 'transactions.created_at as operation_date', 'transactions.attachment')
					->get();

				Excel::create('selfstation', function($excel)  use($transactions)  {
					$excel->sheet('users', function($sheet)  use($transactions)  {
						// add header
						$sheet->appendRow(array(
							trans('app.no_operationno'), trans('app.name'), trans('app.phone') , trans('app.type_operation'), trans('app.amount_operation'),
							 trans('app.attachment'), trans('app.date_operation')
						));	
						
						foreach($transactions as $transaction){
							$row = array();
							$row[] = $transaction->no;
							if($transaction->first_name)
								$row[] = $transaction->first_name . $transaction->last_name;
							else
								$row[] = $transaction->name;
							$row[] = $transaction->phone;
	
							switch($transaction->type){
								case '0':
									$row[]  = trans('app.user');
									break;
								case '1':
									$row[]  =  trans('app.seller');
									break;
								case '2':
									$row[] = trans('app.admin');
									break;
								case '3':
									$row[] = trans('app.admin');
									break;
								case '4':
									$row[] = trans('app.admin');
									break;
							}
							$row[] = $transaction->amount;
							if($transaction->attachment)
								$row[] = URL::to('admin/download/attachment') . '/' . $transaction->no;
							else $row[] = "";
							$row[] = $transaction->operation_date;
							$sheet->appendRow($row);
						}
					});
				})->download('xls');
			 
		 
		}
	}

	public function sellerdetails(Request $request, $id){

		$transaction = Transactions::where("transactions.no", $id)
						->select('transactions.no', 'users.name', 'users.first_name', 'users.last_name', 'transactions.type', 'transactions.amount', 'transactions.created_at as regdate', 'transactions.reference_id', 'users.no as sellerno', 'users.usertype')
						->leftJoin('users', 'users.id', '=', 'transactions.operator_id')
						->first();

		switch ($transaction->type) {
			case '0':
				$vehicle = Operation::where('operation.id', $transaction->reference_id)
									->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
									->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
									->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name')
									->first();
				$transaction->details = $vehicle;
				break;
			case '4':
				$fuelstation = Operation::where('operation.id', $transaction->reference_id)
										->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
										->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
										->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name')
										->first();
				$transaction->details = $fuelstation; 
				break;
			default:
				break;
		}

		if(isset($transaction)){
			if($transaction->usertype == 1) // seller
				return view('admin/sellerdetails', compact('transaction'));
			if($transaction->usertype == 0)
				return view('admin/userdetails', compact('transaction'));
		}
		else{
			return view('errors/404');
		}
	}
	
	public function userdownload_attach(Request $request, $id){
		$deposit = Deposit::where('no', $id)
					->where('user_id', Auth::user()->id)
					->first();
		if(isset($deposit)){
			$file= base_path(). '/images/bankdeposit_123/' .$deposit->notes;
		    $headers = array(
		              'Content-Type: application/image',
		            );
			return Response::download($file, $deposit->notes , $headers);
		}
	}

	public function admindownload_attach(Request $request, $id){
		$deposit = Deposit::where('no', $id)
				->first();
		if(isset($deposit)){
		$file= base_path(). '/images/bankdeposit_123/' .$deposit->notes;
		$headers = array(
				'Content-Type: application/image',
				);
		return Response::download($file, $deposit->notes , $headers);
		}
	}


	public function paymentmanager(Request $request){
		 $payments  = Paymentmanager::get();		 
         if($request->isMethod('post')) {
			 foreach($payments as $payment){
				 $payment->status = $request->{"paymentmanager_" . $payment->id} ;
				 $payment->save();
			 }
		 }
		return view('admin/paymentmanager', compact('payments'));
	}
	
	/////////////////////////////////////////////////////////////
	public function fillingup(Request $request){
		$setting = array();
		$setting['link'] = Auth::user()->no;
		return view('user/invite/fillingup', compact('setting'));
	}
	
	public function contactus(Request $request){
		$message = "";
		if ($request->isMethod('post')) {
			 $this->validate($request, Contactus::rules());
			 $contactus = new Contactus;
			 $contactus->content = $request->content;
			 $contactus->user_id = Auth::user()->id;
			 $contactus->type    = $request->type;
			 $contactus->save();
			 $message = "Successfully Sent";
		}
		return view('user/contactus/index', compact('message'));
	}
	
	private function getnerateqrcode($vehiclename, $model, $fueltype, $code, $picture){
		$fuel_text = "";
		switch($fueltype){
			case '0': //all
				$fuel_text = "ALL";
				break;
			case '1':// green
				$fuel_text = "Fuel91";
				break;
			case '2': // red
				$fuel_text = "Fuel95";
				break;
			case '3': // diesel165,42,42
			 
				$fuel_text = "Diesel";
				break;
		}
		$color = ['r' => 0, 'g' => 0, 'b' => 0];
		$text = $vehiclename . ':' . $model . ':' . $fuel_text. ':' . $code;
		$input_path  = base_path('images/userprofile/'. $picture);
		$result_path =   time().rand() . '.png';
		$output_path = base_path('images/qr/'.$result_path);
		QrcodeClass::generate($text,$input_path ,$output_path, $color);
		return $result_path;
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
				// update vehicle qr code
				$user->save();

			 

				$vehicles = Vehicle::where('user_id', $user->id)->get();
			 
				foreach($vehicles as $vehicle){
					unlink( base_path('images/qr/'.$vehicle->qrcode )); 
					$vehicle->qrcode =  $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no, $user->picture );
					$vehicle->save();
				}

			}
			
			$user->first_name = $request->first_name;
			$user->last_name  =  $request->last_name;
			$user->phone  	  =  $request->phone;
			$user->email      =  $request->email;
			$user->state      =  $request->state;
			$user->country    =  $request->country;
			$user->save();
		 }
		 
		 return view('user/usersettings/usersetting', compact('message', 'countries', 'states', 'user'));
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
		if(null !== $request->input('country'))
		{
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
		$states    = Zone::where('country_id',  '184')->get();
		$countries = Country::get();
		return view('user/map/map', compact('countries', 'setting_val', 'states', 'fuel_json'));
	}
	
	private function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo){
		
		$theta = $longitudeFrom - $longitudeTo;
		$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		
		return ($miles * 1.609344).' km';
	}
	
	public function api_map(Request $request){
		$sql = "";
		$setting_val 			= array();
		$setting_val['name']    = "";
		$setting_val['country'] = "";
		$setting_val['fuel']    = array();
		$setting_val['state']   = "";
		
		$states = array();
		$validator =  Validator::make($request->all(), [
						'my_lat' => 'required',
						'my_lang' => 'required',
					]); 
					
					
		if($validator->fails()){
			$errors = $validator->errors();
				return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
			} else{
				if(null !== $request->input('name'))
				{
					$setting_val['name'] = $request->input('name');
					$sql .= 'name like "' . 	$setting_val['name']  . '%"';			
				}
			
				if(null !== $request->input('country'))
				{
					$setting_val['country'] = $request->input('country');
					$states    = Zone::where('country_id',  $setting_val['country'])->get();
					 
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
						switch($setting_val['fuel']){
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
						}
				}

				if($request->service !== null)
				{
					$setting_val['service'] = $request->input('service');
						switch($setting_val['service']){
							case 1:  
								if($sql != "") 
									$sql  .= " and ";
								$sql .= ' s_o = "1"'; 
								break;
							case 2:  
								if($sql != "") 
									$sql  .= " and ";
								$sql .= ' s_w = "1"'; 
								break;
						}
				}
			 
			if($sql != "")
				$fuelstations =	Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
								->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
								->whereRaw($sql)
								->get();
			else
				$fuelstations = Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
								->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
								->get();
			
			$fuel_array = array();
			foreach($fuelstations as $fuelstation){
				$fuel_item = array();
				$fuel_item['lat'] = $fuelstation->lat;
				$fuel_item['lng'] = $fuelstation->lng;
				$fuel_item['city'] = $fuelstation->city;
				$fuel_item['name'] = $fuelstation->name;
				$fuel_item['state'] = $fuelstation->statename;
				$fuel_item['distance'] = $this->getDistance($request->input('my_lat') , $request->input('my_lang') , $fuel_item['lat'], $fuel_item['lng']);
				
				$fuel_array[] = $fuel_item;
			}
			return response()->json(['error' => 0 ,   'result' => $fuel_array]);
		}
	}
	
	public function reports(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$setting['pagesize'] = $page_size;
		$setting['from_amount'] = "";
		$setting['to_amount'] = "";
		$setting['from_date'] = "";
		$setting['to_date'] = "";

		$setting['vehicle'] = "";
		$setting['state'] = "";
		$setting['city'] = "";
		$setting['service_type'] = "";



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
		}

		if(null !== $request->input('vehicle'))
		{
			$setting['vehicle'] = $request->input('vehicle');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' vehicles.no = "' . 	$setting['vehicle']  . '"';
		}


		if(null !== $request->input('state'))
		{
			$setting['state'] = $request->input('state');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' vehicles.state = "' . 	$setting['state']  . '"';
		}

		if(null !== $request->input('city'))
		{
			$setting['city'] = $request->input('city');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' vehicles.city = "' . 	$setting['city']  . '"';
		} 

	 
		if(null !== $request->input('service_type'))
		{
			$setting['service_type'] = $request->input('service_type');
			
			if($sql != "") $sql  .= " and ";
			$sql .= ' transactions.type = "' . 	$setting['service_type']  . '"';
		 
		} 

		if($sql == "") $sql = "1=1";

	 
		if($request->key !== null){
			$setting['key'] = $request->key;
			
			$transactions = Transactions::orderBy('transactions.created_at')
			->select('transactions.created_at','transactions.no', 'transactions.type', 'transactions.reference_id', 'transactions.amount', 'transactions.created_at as regdate')
			->where('transactions.operator_id', Auth::user()->id)
			->where('transactions.type', '0')
			->whereRaw($sql)
			->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
			->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
			->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
			->where(function ($query) use ($request) {
				$query->where('transactions.no',  'like',  '%'. $request->key . '%')
				   ->orWhere('vehicles.name', 'like','%'. $request->key . '%')
				   ->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
				   ->orWhere('vehicles.city', 'like','%'. $request->key . '%'); 
		     })->paginate($page_size);
		}
		else{
			$setting['key'] = "";

		 
			$transactions = Transactions::orderBy('transactions.created_at')
					->select('transactions.created_at', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'transactions.amount', 'transactions.created_at as regdate')
					->where('transactions.operator_id', Auth::user()->id)
					->whereRaw($sql)
					->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
					->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
					->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
					->paginate($page_size);
				 
			}


			foreach ($transactions as $key => $value) {
				switch ($value->type) {
					case '0':
							$vehicle = Operation::where('operation.id', $value->reference_id)
											->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
											->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
											->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name', 'operation.service_type')
											->first();
							$value->details = $vehicle;
						break;
					default:
						break;
				}
			}

		$vehicles   = Vehicle::where("user_id", Auth::user()->id)->get();
		$states     = Vehicle::where("user_id", Auth::user()->id)
									->leftJoin('oc_zone', 'oc_zone.zone_id', '=','vehicles.state')
									->select('oc_zone.zone_id', 'oc_zone.name')
									->groupBy('vehicles.state')
									->get();

		$cities     = Vehicle::where("user_id", Auth::user()->id)
									->select('vehicles.city')
									->groupBy('vehicles.city')
									->get();

		return view('user/reports/reports', compact('setting', 'transactions', 'vehicles', 'states', 'cities'));
	}

	public function reports_export(Request $request){
		$transactions = Transactions::orderBy('transactions.created_at')
		->select('users.name', 'transactions.created_at','users.first_name', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
		->leftJoin( 'users' ,'transactions.operator_id', '=', 'users.id')
		->where('transactions.operator_id', Auth::user()->id)
		->get();

		Excel::create('vehicles', function($excel)  use($transactions)  {
			$excel->sheet('report', function($sheet)  use($transactions)  {
				// add header
				
				$sheet->appendRow(array(
					trans('app.no'), trans('app.vehicle_name'), trans('app.operation_type') , trans('app.service_type'),trans('app.state'),
					trans('app.city'),trans('app.amount'),trans('app.date_opration')
				));	

				foreach ($transactions as $key => $value) {
					switch ($value->type) { 
						case '0':
								$vehicle = Operation::where('operation.id', $value->reference_id)
												->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
												->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'vehicles.state')
												->select('vehicles.city', 'oc_zone.name as state', 'vehicles.name', 'operation.service_type')
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
					
					$row    = array();
					$row[]  = $value->no;
					
					if($value-> details !== null)
						$row[] = $value->details->name;
					else $row[] = '';

					
					if($value->type == '4')
						$row[] = trans('app.pos_revenue');
					elseif($value->type == '0')
						$row[] = trans('app.pos_payment');
					elseif($value->type == '1')
						$row[] = trans('app.deposit');
					elseif($value->type == '2')
						$row[] = trans('app.withdrawl');
					elseif($value->type == '3')
						$row[] = trans('app.reward');
					else
						$row[] = "";
					

					if($value-> details !== null){
						if($value-> details ->service_type == "1")
							$row[] = trans('fuel');
						elseif($value->  details ->service_type == "2")
							$row[] =  trans('oil');
						elseif($value->  details ->service_type == "3")
							$row[] = trans('wash');
						else
							$row[] = "";
					}	
					else $row[] = "";

					if($value-> details !== null)
						$row[] = $value->details->state;
					else $row[] = '';

				if($value-> details !== null)
					$row[] = $value->details->city;
				else $row[] = '';


					$row[] = $value->amount;
					$row[] = $value->created_at;
					$sheet->appendRow($row);
				}
			});
		})->download('xls');



	}

	// invite friend

	public function invitefriend(Request $request){

		if($request->type == 'email'){
			$validator = Validator::make($request->all(),
				[
					'address'    => 'required|email',
					'branch'     => 'required',
				 
				]
			)->validate();
		}
		else{
			$validator = Validator::make($request->all(),
			[
			 
				'address'    => 'required',
				'branch'     => 'required',
			]
			)->validate();
		}
		

		if($request->branch == "fillingup"){
			$invite_link = URL::to('/login') . '?invite=' . Auth::user()->no;
			if($request->type != 'email')
				User::sendMessage($request->address , 'This is the login verificatoin code.  ' .$invite_link  );
			else
				Mail::to($request->address)	->send(new Notification('This is the login verificatoin code.  ' .$invite_link));
			
		}
		else{ 
			if($request->content !== null){
				$vehicle = Vehicle::where('no',$request->content)->first();
				if(!isset($vehicle)) return response()->json(['status' => 0]);
				$invite_link =  URL::to('/images/qr') . '/' . $vehicle->qrcode;
				if($request->type != 'email')
					User::sendMessage($request->address , 'This is the login verificatoin code.  ' .$invite_link);
				else
					Mail::to($request->address)	->send(new Notification('This is the login verificatoin code.  ' .$invite_link));
					//Mail::to($request->address)->send(new Notification());
			}
			else
				return response()->json(['status' => 0]);
		}
		return response()->json(['status' => 1  ,  'msg' => $invite_link]);
	
	}


	public function sendmoney(Request $request){

		if($request->isMethod('post')){
			$this->validate($request, Sendmoney::rules());
			//if($request->amount >)
			$reference_id = $request->reference_id;
			$user = User::where('email', $reference_id)
						->where('usertype', '0')
						->where('email', '!=', Auth::user()->email)
						->first();
			if(!isset($user))
				return Redirect::back()->withErrors(['reference_id'=> trans('app.invalid_user')]); 	
			
			$balance = Fees::checkbalance(Auth::user()->id);
			if($request->amount > $balance)
				return Redirect::back()->withErrors(['amount'=> trans('app.insufficient_deposit')]);
			$sendmoney = new Sendmoney;
			$sendmoney->user_id 		 = Auth::user()->id;
			$sendmoney->receiver_id 	 = $user->id;
			$sendmoney->amount  		 = $request->amount;
			$sendmoney->reference_id 	 = $request->reference_id;
			$sendmoney->no               = Sendmoney::generatevalue(); 
			$sendmoney->save();
			

			$fee_data =  Fees::calculatefee($sendmoney->amount, 'sendmoney');
			if($fee_data['status'] == 1){
				$transaction = new Transactions;
				$transaction->operator_id = $sendmoney->user_id;
				$transaction->reference_id = $sendmoney->id;
				$transaction->type = 6;// send money
				
				$transaction->amount 	   =  $sendmoney->amount;
				$transaction->fee_amount   =  0;
				$transaction->final_amount =  $sendmoney->amount;
				$transaction->no = Transactions::generatevalue();
				$transaction->transtype   =  1;
				$transaction->save();

				$transaction = new Transactions;
				$transaction->operator_id = $sendmoney->receiver_id;
				$transaction->reference_id = $sendmoney->id;
				$transaction->type = 7;// accept money
				
				$transaction->amount 	   =  $sendmoney->amount;
				$transaction->fee_amount   =  $fee_data['fee'];
				$transaction->final_amount =  $fee_data['amount'];
				$transaction->no           = Transactions::generatevalue();
				$transaction->save();
				//Subfeemanagement::collectingFee($deposit->user_id);
				Session::flash('success', 'success');
			}
		}
		return view('user/sendmoney/sendmoney');
	}
}
