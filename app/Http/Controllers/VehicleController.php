<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subfeemanagement;
use App\Vehicle;
use App\Country;
use App\Zone;
use Illuminate\Support\Facades\Input;
use Redirect, Auth;
use App\Fees;
use App\Helpers\QrcodeClass;
use JWTAuth,Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Excel, PDF;
use App\History;
use App\Setting;
use App\User;
class VehicleController extends Controller
{
	//
	public function api_index(Request $request){
		
		$user = JWTAuth::parseToken()->authenticate();
		
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		
		if($request->key !== null){
			$setting['key'] = $request->key;
			$vehicles = Vehicle::where("user_id", $user->id)
						->where('name',  'like',  '%'. $request->key . '%')
					    ->get();
		}
		else{
			$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		}
		
		return response()->json(['error' => 0 ,   'result' => $vehicles]);
	}
	
	public function index(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		$setting['pagesize'] = $page_size;
		if($request->key !== null){
			$setting['key'] = $request->key;
			$vehicles = Vehicle::where("user_id", Auth::user()->id)
						->where('name',  'like',  '%'. $request->key . '%')
						->orWhere('no',  'like',  '%'. $request->key . '%')
						//->orWhere('amount', 'like','%'. $request->key . '%')
					    ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$vehicles = Vehicle::where('user_id', '=', $user_id)->paginate($page_size);
		}
		$title = trans('app.manager_vehicle');
		return view('user/vehicle/index', ['vehicles' => $vehicles->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
	public function store(Request $request){
		
		$vehicles = Vehicle::where('user_id', '=', Auth::user()->id)->paginate($request->pagesize);
		foreach($vehicles as $vehicle){
				$vehicle->status    =  $request->{'status_' .    $vehicle->id};
				$vehicle->save();
		}
		return Redirect::back()->with(['Please choose the card']);
	}
	
	public function api_countries(Request $request){
		
		$countries = Country::get();
		return response()->json(['error' => 0 ,   'result' => $countries]);
	}
	
	public function api_states(Request $request){
	 
		//country_id
        $validator =  Validator::make($request->all(), [
						'country_id' => 'required',
					]); 
		
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} else{
			
			$states = Zone::where('country_id', $request->country_id)->get();
			return response()->json(['error' => 0 ,   'result' => $states]);
		}
	}
	
	public function api_create(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		$validator =  Validator::make($request->all(), [
		    'name'     =>    'required',
            'type'     =>    'required',
            'model'    =>    'required',
            'fuel'     =>    'required',
            'state'    =>    'required|integer',
            'city'     =>    'required',
			'oil'      =>    'required',
			'password' =>    'required|integer|digits:4',
            //'country'   =>   'required|integer',
			'picture'   =>    'image|mimes:jpeg,bmp,png',
		]);
		
		if($validator->fails()){
			$errors = $validator->errors();
			$messages = $errors->messages();
			reset($messages);
			$first_key = key($messages);
			return response()->json(['error' => 1 ,  'msg' => $first_key]);
		}

		$fee_amount =  Subfeemanagement::getFeeByuserid($user->id);
		if($fee_amount > Fees::checkbalance($user->id))
		{
			return response()->json(['error' => 1 ,   'msg' => trans('app.low_balance')]);  
		}
		

		$vehicle = new Vehicle;
		
		if ($request->hasFile('picture')) {
			$image=$request->file('picture');
			$imageName=$image->getClientOriginalName();
			$imageName = time() . $imageName;
			$image->move('images/vehicle',$imageName);
			$vehicle->picture = $imageName;
		}
		$vehicle->name      = $request->name;
		$vehicle->no        = Vehicle::generatevalue();
		$vehicle->user_id   = $user->id;
		$vehicle->type      = $request->type;
		$vehicle->model     = $request->model;
		$vehicle->fuel      = $request->fuel;
		$vehicle->oil       = $request->oil;
		$vehicle->state     = $request->state;
		$vehicle->city      = $request->city;
		$vehicle->password  = bcrypt($request->password);
		$vehicle->country   = 184;
		//$vehicle->country   = $request->country;
		$vehicle->qrcode    =  $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no, $user->id);
		$vehicle->save();
		return response()->json(['error' => 0 ,   'result' => 'success']);  
	}
	
	public function create(Request $request){
		 if ($request->isMethod('post')) {
 
			$validator = Validator::make($request->all(),  
				[
					'createvehicle_name1'     =>    'required',
					'createvehicle_name2'     =>    'required',
					'createvehicle_name3'     =>    'required',
					'createvehicle_name4'     =>    'required',
					'createvehicle_name5'     =>    'required',
					'createvehicle_name6'     =>    'required',
					'createvehicle_name7'     =>    'required',

					'createvehicle_type'     =>    'required',
					'createvehicle_model'    =>    'required',
					'createvehicle_fuel'     =>    'required',
					'createvehicle_state'    =>    'required|integer',
					'createvehicle_city'     =>    'required',
				//	'createvehicle_plate'     =>    'required | min:7 |  max:7 | unique:vehicles,plate',
					'createvehicle_password' =>    'required|integer|digits:4',
					// 'createvehicle_coutry'   =>    'required|integer',
					'picture'                => 'image|mimes:jpeg,bmp,png',
				]
			);
 
			if ($validator->fails()) {
			//	return redirect()->back()->withInput()->withErrors(['createvehicle_name'=> trans('app.plate_is_need')]);
				return redirect()->back()->withInput()->withErrors($validator);
			}
			 
		 

			$fee_amount =  Subfeemanagement::getFeeByuserid(Auth::user()->id);
			if($fee_amount > Fees::checkbalance(Auth::user()->id))
			{
				return redirect()->back()->withInput()->withErrors(['createvehicle_name'=> trans('app.low_balance')]); 
			}

			$vehicle_name = $request->createvehicle_name1 . " " . $request->createvehicle_name2 . " " .$request->createvehicle_name3 . " " .$request->createvehicle_name4 . " " .$request->createvehicle_name5 . " " .$request->createvehicle_name6 . " " . $request->createvehicle_name7;
			
			$vehicle = Vehicle::where('name',    $vehicle_name)
							  ->where('user_id', Auth::user()->id)
							  ->where('type',  $request->createvehicle_type)
							  ->where('model', $request->createvehicle_model)
							  ->where('fuel',  $request->createvehicle_fuel)
							  ->where('oil',   $request->createvehicle_oil)
							  ->where('state', $request->createvehicle_state)
				 
							  ->where('city',  $request->createvehicle_city)
							  ->first();
			
			if(isset($vehicle)){
				return redirect()->back()->withInput()->withErrors(['createvehicle_name'=> trans('app.duplicated_vehicle')]); 
			}
 
		   // $vehicle->country   = $request->createvehicle_coutry;
			$vehicle = new Vehicle;
		  if ($request->hasFile('picture')) {
			$image=$request->file('picture');
			$imageName=$image->getClientOriginalName();
			$imageName = time() . $imageName;
			$image->move('images/vehicle',$imageName);
			$vehicle->picture = $imageName;
		  }

		  $vehicle->name      = $vehicle_name;
		  $vehicle->no        = Vehicle::generatevalue();
		  $vehicle->user_id   = Auth::user()->id;
		  $vehicle->type      = $request->createvehicle_type;
		  $vehicle->model     = $request->createvehicle_model;
		  $vehicle->fuel      = $request->createvehicle_fuel;
		  $vehicle->oil       = $request->createvehicle_oil;
		  $vehicle->state     = $request->createvehicle_state;
		  $vehicle->city      = $request->createvehicle_city;
		 
		  $vehicle->password  = bcrypt($request->createvehicle_password);

		 // $vehicle->country   = $request->createvehicle_coutry;
		  $vehicle->country   = 184;
		  $vehicle->qrcode = $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no, Auth::user()->id);
		  ////////////////////////////////////		   
		  //  sms
		  /////////////////////////////////////////
		  $vehicle->save();
		  Subfeemanagement::collectingFeeCar(Auth::user()->id, $vehicle->id);
		  return redirect('/user/vehicles');
		}
		$countries = Country::get();
		$states    = Zone::where('country_id',   '184')->get();
		$title = trans('app.add_vehicle');
		return view('user/vehicle/new', compact('title','countries', 'states'));
	}
	 
	private function getnerateqrcode($vehiclename, $model, $fueltype, $code, $user_id){
		$user = User::find($user_id);
		$color = ['r' => 0, 'g' => 0, 'b' => 0];
		$fuel_text = "";
		switch($fueltype){
			case '0': //all
				$color = ['r' => 0, 'g' => 0, 'b' => 0];
				$fuel_text = "ALL";
				break;
			case '1':// green
				$color = ['r' => 0, 'g' => 255, 'b' => 0];
				$fuel_text = "Fuel91";
				break;
			case '2': // red
				$color = ['r' => 0, 'g' => 0, 'b' => 0];
				$fuel_text = "Fuel95";
				break;
			case '3': // diesel165,42,42
				$color = ['r' => 0, 'g' => 0, 'b' => 0];
				$fuel_text = "Diesel";
				break;
		}
		$color = ['r' => 0, 'g' => 0, 'b' => 0];
		
		$text = $vehiclename . ':' . $model . ':' . $fuel_text. ':' . $code;
		
		//$input_path  = base_path('images/vehicle/'. $logopath);
		
		/*
		$item = Setting::where('name', 'reward')->first();
		if(isset($item)){
			$transaction->amount = $item['value'];
			$transaction->final_amount =  $item['value'];
		}
		else{
			$transaction->amount = 10;
			$transaction->final_amount =  10;
		}
		*/

		$mimum_cars = 50;
		$item = Setting::where('name', 'qrcodelimit')->first();
		if(isset($item)){
			$mimum_cars =  $item['value'];
		}
		
		$vehicle_nums = Vehicle::where('user_id', $user->id)->count();

		if($mimum_cars >  $vehicle_nums){
			$input_path  = base_path('images/logo.png');
		}
		else{
			if(Auth::user()->picture)
				$input_path  = base_path('images/userprofile/'. $user->picture);
			else
				$input_path  = base_path('images/default-user.png');
		}
 
		$result_path =   time() . '.png';
		$output_path = base_path('images/qr/'.$result_path);
		QrcodeClass::generate($text,$input_path ,$output_path, $color);
		return $result_path;
	}
	
	public function update(Request $request, $id){
		 $vehicle = Vehicle::where('id', $id) -> where('user_id', Auth::user()->id)->first();
		 if ($request->isMethod('post')) {
			 
			  $validator = Validator::make($request->all(),  
				[
					'createvehicle_name1'     =>    'required',
					'createvehicle_name2'     =>    'required',
					'createvehicle_name3'     =>    'required',
					'createvehicle_name4'     =>    'required',
					'createvehicle_name5'     =>    'required',
					'createvehicle_name6'     =>    'required',
					'createvehicle_name7'     =>    'required',

					'createvehicle_type'     =>    'required',
					'createvehicle_model'    =>    'required',
					'createvehicle_fuel'     =>    'required',
					'createvehicle_state'    =>    'required|integer',
					'createvehicle_city'     =>    'required',
					//'createvehicle_plate'     =>    'required | min:7 |  max:7 | unique:vehicles,plate',
					//'createvehicle_coutry'   =>    'required|integer',
					'picture'                => 'image|mimes:jpeg,bmp,png',
				]
			);

			if ($validator->fails()) {
			//	return redirect()->back()->withInput()->withErrors(['createvehicle_name'=> trans('app.plate_is_need')]);
				return redirect()->back()->withInput()->withErrors($validator);
			}

			  if(isset($vehicle)){
				  if ($request->hasFile('picture')){
					$image=$request->file('picture');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/vehicle',$imageName);
					$vehicle->picture = $imageName;
				  }
				 
				  $vehicle->name      = $request->createvehicle_name1 . " " . $request->createvehicle_name2 . " " .$request->createvehicle_name3 . " " .$request->createvehicle_name4 . " " .$request->createvehicle_name5 . " " .$request->createvehicle_name6 . " " . $request->createvehicle_name7;
				  $vehicle->user_id   = Auth::user()->id;
				  $vehicle->type      = $request->createvehicle_type;
				  $vehicle->model     = $request->createvehicle_model;
				  $vehicle->fuel      = $request->createvehicle_fuel;
				  $vehicle->oil       = $request->createvehicle_oil;
				  $vehicle->state     = $request->createvehicle_state;
				  $vehicle->city      = $request->createvehicle_city;
				  // $vehicle->country   = $request->createvehicle_coutry;
				  $vehicle->country   = 184;
				  if($request->createvehicle_password)
					  $vehicle->password  = bcrypt($request->createvehicle_password);
					  
				  // delete past qrcode image
				  unlink( base_path('images/qr/'.$vehicle->qrcode )); 

				  $vehicle->qrcode =  $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no, Auth::user()->id);
				  $vehicle->save();
				  return redirect('/user/vehicles');
			  }
			  else{
				  return redirect('/errors/404');
			  }
				   
		 }
		  
		 $countries = Country::get();
		 $states    = Zone::where('country_id',  $vehicle->country)->get();
		 $title = trans('app.edit_vehicle');
		 return view('user/vehicle/new', compact('countries', 'title','states' ,'vehicle'));
	}
	
	public function api_update(Request $request){
			
			$validator =  Validator::make($request->all(), [
				'no'       =>    'required',
				'name'     =>    'required',
				'type'     =>    'required',
				'model'    =>    'required',
				 'oil'     =>     'required',
				'fuel'     =>    'required',
				'state'    =>    'required|integer',
				'city'     =>    'required',
				'country'   =>    'required|integer',
				'picture'  =>    'image|mimes:jpeg,bmp,png',
			]); 
			
			if($validator->fails()){
				$errors = $validator->errors();
				$messages = $errors->messages();
				reset($messages);
				$first_key = key($messages);
				return response()->json(['error' => 1 ,  'msg' => $first_key]);
			}
	  
			$vehicle = Vehicle::where('no', $request->no)->first();
			$user = JWTAuth::parseToken()->authenticate(); 
			if(isset($vehicle)){
				if ($request->hasFile('picture')){
					$image=$request->file('picture');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/vehicle',$imageName);
					$vehicle->picture = $imageName;
				}
				$vehicle->name      = $request->name;
				$vehicle->user_id   = $user->id;
				$vehicle->type      = $request->type;
				$vehicle->model     = $request->model;
				$vehicle->fuel      = $request->fuel;
				$vehicle->oil       = $request->oil;
				$vehicle->state     = $request->state;
				$vehicle->city      = $request->city;
				//$vehicle->country   = $request->country;
				$vehicle->country   = 184;
				$vehicle->qrcode = $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no, $user->id);
				$vehicle->save();
				return response()->json(['error' => 0 ,   'result' => 'success']);  
			}
			else{
				return response()->json(['error' => 1 ,   'result' => 'wrong_id']);  
			}
				 
	}
	
	public function usernotification_export_pdf(Request $request){
		$user_id = Auth::user()->id;
		if($request->key !== null){
			$vehicles = Vehicle::where('user_id', '=', $user_id)
						->where('name',  'like',  '%'. $request->key . '%')
						->get();
		}
		else{
			$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		}
		
		$title = trans('app.notification');
		User::downloadPDF('user/notification/notification_pdf', compact('vehicles', 'title'));
	}
	
	public function usernotification_export(Request $request){
		$user_id = Auth::user()->id;
		if($request->key !== null){
			$vehicles = Vehicle::where('user_id', '=', $user_id)
						->where('name',  'like',  '%'. $request->key . '%')
						->get();
		}
		else{
			$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		}
		
		Excel::create('selfstation', function($excel)  use($vehicles) {
			$excel->sheet('notificatio', function($sheet)  use($vehicles)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.all_notification') , trans('app.maximum_foramount'),
					 trans('app.maximum_times_day'), trans('app.status')
				));	
				
				foreach($vehicles as $vehicle){
					$row = array();
					$row[] = $vehicle->no;
					if($vehicle->first_name)
						$row[] = $vehicle->first_name . $vehicle->last_name;
					else
						$row[] = $vehicle->name;
				 
					switch($vehicle->not_type){
						case 0:
							$row[]  = trans('app.yes');
							break;
						case 1:
							$row[]  =  trans('app.sms');
							break;
						case 2:
							$row[] = trans('app.email');
							break;
					}
					$row[] = $vehicle->not_amount;
					$row[] = $vehicle->not_times;
					
					if($vehicle->not_status)
						$row[] =  trans('app.yes');
					else
						$row[] =  trans('app.no_en');
					
					
					$sheet->appendRow($row);
				}
			});
		})->download('xls');

	}

	public function usernotification(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		$setting['pagesize'] = $page_size;
		if($request->key !== null){
			$setting['key'] = $request->key;
			
			$vehicles = Vehicle::where('user_id', '=', $user_id)
						->where('name',  'like',  '%'. $request->key . '%')
						->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$vehicles = Vehicle::where('user_id', '=', $user_id)->paginate($page_size);
		}
		if($request->isMethod('post')){
			foreach($vehicles as $vehicle){
 
				$vehicle->not_type     =  $request->{'not_type_' .     $vehicle->id};
				$vehicle->not_wash 	   =  $request->{'not_wash_' . $vehicle->id};
				$vehicle->not_status   =  $request->{'not_status_' .    $vehicle->id};
				 
				if($vehicle->not_status){
					$vehicle->not_times    =  $request->{'not_times_' .$vehicle->id};
					$vehicle->not_oil      =  $request->{'not_oil_' .  $vehicle->id};
					$vehicle->not_amount   =  $request->{'not_amount_'.$vehicle->id};

				 
				}  
				else{
					$vehicle->not_times    =  0;
					$vehicle->not_oil      =  0;
					$vehicle->not_amount   =  0;
				}
				$vehicle->save();
			}
		}
		$title = trans('app.notification');
		return view('user/notification/notification', ['vehicles' => $vehicles->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
	
	public function adminnotification(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		$setting['pagesize'] = $page_size;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->where('vehicles.name',  'like',  '%'. $request->key . '%')
								->orWhere('vehicles.no',  'like',  '%'. $request->key . '%')
								->orWhere('users.name',  'like',  '%'. $request->key . '%')
								->orWhere('users.first_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.last_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.phone',  'like',  '%'. $request->key . '%')
								->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
						->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
						->paginate($page_size);
		}

		if($request->isMethod('post')){
			foreach($vehicles as $vehicle){

				if(($vehicle->not_type  != $request->{'not_type_' .     $vehicle->id}) || ($vehicle->not_wash != $request->{'not_wash_' . $vehicle->id}) || ($vehicle->not_status != $request->{'not_status_' .    $vehicle->id}) || ($vehicle->not_times !=  $request->{'not_times_' .$vehicle->id}) || ($vehicle->not_amount != $request->{'not_amount_'.$vehicle->id})){
					History::addHistory(Auth::user()->id, 5, 0, $vehicle->id);
				}

				$vehicle->not_type     =  $request->{'not_type_' .     $vehicle->id};
				$vehicle->not_wash 	   =  $request->{'not_wash_' . $vehicle->id};
				$vehicle->not_status   =  $request->{'not_status_' .    $vehicle->id};
				$vehicle->not_times    =  $request->{'not_times_' .$vehicle->id};
				$vehicle->not_oil      =  $request->{'not_oil_' .  $vehicle->id};
				$vehicle->not_amount   =  $request->{'not_amount_'.$vehicle->id};
				$vehicle->save();
				
			}
		}
		$title = trans('app.manager_notifications');
		return view('admin/notification', ['vehicles' => $vehicles->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}

	public function adminnotification_export(Request $request){
		$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
		->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
		->get();
		
		if($request->key !== null){
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->where('vehicles.name',  'like',  '%'. $request->key . '%')
								->orWhere('vehicles.no',  'like',  '%'. $request->key . '%')
								->orWhere('users.name',  'like',  '%'. $request->key . '%')
								->orWhere('users.first_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.last_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.phone',  'like',  '%'. $request->key . '%')
								->get();
		}
		else{
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->get();
		}
		 
		Excel::create('selfstation', function($excel)  use($vehicles)  {
			$excel->sheet('users', function($sheet)  use($vehicles)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.all_notification') , trans('app.maximum_foramount'),
					 trans('app.maximum_times_day'), trans('app.status')
				));	
				
				foreach($vehicles as $vehicle){
					$row = array();
					$row[] = $vehicle->no;
					if($vehicle->first_name)
						$row[] = $vehicle->first_name . $vehicle->last_name;
					else
						$row[] = $vehicle->name;
				 
					switch($vehicle->not_type){
						case 0:
							$row[]  = trans('app.yes');
							break;
						case 1:
							$row[]  =  trans('app.sms');
							break;
						case 2:
							$row[] = trans('app.email');
							break;
					}
					$row[] = $vehicle->not_amount;
					$row[] = $vehicle->not_times;
					
					if($vehicle->not_status)
						$row[] =  trans('app.yes');
					else
						$row[] =  trans('app.no_en');
					 
					$sheet->appendRow($row);
				}
			});
		})->download('xls');
	}

	public function adminnotification_pdf(Request $request){
		if($request->key !== null){
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->where('vehicles.name',  'like',  '%'. $request->key . '%')
								->orWhere('vehicles.no',  'like',  '%'. $request->key . '%')
								->orWhere('users.name',  'like',  '%'. $request->key . '%')
								->orWhere('users.first_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.last_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.phone',  'like',  '%'. $request->key . '%')
								->get();  
		}
		else{
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->get();
		}
		$title = trans('app.user_management');
		User::downloadPDF('admin/pdf/notification_pdf', compact('vehicles', 'title'));
	}

	public function delete(Request $request, $id){
		$vehicle = Vehicle::find($id);		
		if(isset($vehicle)){
			$vehicle->delete(); 
		}
		return redirect('/user/vehicles');
	}
	
	// showing qr code
	public function qrcode(Request $request, $id){
		$vehicle = Vehicle::where('no', $id)->first();
		if(!isset($vehicle)) return view('errors/404');
		$title = trans('app.qrcode');
		return view('/user/vehicle/qrcode', compact('vehicle', 'title'));
	}

	public function export(Request $request){
		$user_id = Auth::user()->id;
		 
		if($request->key !== null){
			$vehicles = Vehicle::where("user_id", Auth::user()->id)
						->where('name',  'like',  '%'. $request->key . '%')
						->orWhere('no',  'like',  '%'. $request->key . '%')
					    ->get();
		}
		else{
			$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		}
		
		Excel::create('vehicles', function($excel)  use($vehicles)  {
			$excel->sheet('users', function($sheet)  use($vehicles)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.plate_number'), trans('app.status') , trans('app.reg_date'),
				));	
				
				foreach($vehicles as $vehicle){
					$row = array();
					$row[] = $vehicle->no;
					if($vehicle->first_name)
						$row[] = $vehicle->first_name . ' ' .$vehicle->last_name;
					else
						$row[] = $vehicle->name;
					if($vehicle->status)
						$row[] =  trans('app.working');   
					else
						$row[] =  trans('app.deleted');   
				 
					$row[] = $vehicle->created_at;
					 
					$sheet->appendRow($row);
				}
			});
		})->download('xls');
	}

	public function export_pdf(Request $request){
		$user_id = Auth::user()->id;
		if($request->key !== null){
			$vehicles = Vehicle::where("user_id", $user_id)
						->where('name',  'like',  '%'. $request->key . '%')
						->orWhere('no',  'like',  '%'. $request->key . '%')
					    ->get();
		}
		else{
			$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		}
		$title = trans('app.manager_vehicle');
		User::downloadPDF('user/vehicle/index_pdf', compact('vehicles', 'title'));
	}

	public function printview(Request $request, $id){

		$vehicle = Vehicle::where('no', $id)->first();
		if(!isset($vehicle))
			return view('errors/404');  

		switch($vehicle->fuel){
			case '0': 
				$vehicle->fuel_text = trans("app.all");
				break; 
			case '1':
				$vehicle->fuel_text =  trans("app.green_fuel");
				break;
			case '2': 
				$vehicle->fuel_text =  trans("app.red_fuel");
				break;
			case '3': 
				$vehicle->fuel_text = trans("app.diesel");  
				break;
		}

		return view('user/vehicle/print', compact('vehicle'));
	}
	public function qrstatusmanagement(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		$setting['pagesize'] = $page_size;

		if($request->key !== null){

			$setting['key'] = $request->key;
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
								->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
								->where('vehicles.name',  'like',  '%'. $request->key . '%')
								->orWhere('users.name',  'like',  '%'. $request->key . '%')
								->orWhere('users.first_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.last_name',  'like',  '%'. $request->key . '%')
								->orWhere('users.phone',  'like',  '%'. $request->key . '%')
								->paginate($page_size);
			
		}
		else{

			$setting['key'] = "";
			$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
						->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
						->paginate($page_size);
			
		}
       
		if($request->isMethod('post')){  

			foreach($vehicles as $vehicle){
				if($vehicle->status != $request->{'status_' .    $vehicle->no}){
					History::addHistory(Auth::user()->id, 8,  $request->{'status_' .    $vehicle->no}  , $vehicle->id);
					if($vehicle->status  == '0')
						$vehicle->wrongnum = 5;
				}
				$vehicle->status   =  $request->{'status_' .    $vehicle->no};
				$vehicle->save();
			}

		}
		$title = trans('app.qrstatus_management');
		return view('admin/qrstatusmanagement', ['vehicles' => $vehicles->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
}
