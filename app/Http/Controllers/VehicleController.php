<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Vehicle;
use App\Country;
use App\Zone;
use Illuminate\Support\Facades\Input;
use Redirect, Auth;
use App\Helpers\QrcodeClass;
use JWTAuth,Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Excel;


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
						//->orWhere('amount', 'like','%'. $request->key . '%')
					    ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$vehicles = Vehicle::where('user_id', '=', $user_id)->paginate($page_size);
		}
		return view('user/vehicle/index', ['vehicles' => $vehicles->appends(Input::except('page')), 'setting' => $setting]);
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
            'oil'     =>     'required',
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
		$vehicle->country   = 184;
		//$vehicle->country   = $request->country;
		$vehicle->qrcode    =  $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no);
		$vehicle->save();  
		return response()->json(['error' => 0 ,   'result' => 'success']);  
	}
	 
	public function create(Request $request){
		 if ($request->isMethod('post')) {
			  $this->validate($request, Vehicle::rules());
			  $vehicle = new Vehicle;
			  
		  if ($request->hasFile('picture')) {
			$image=$request->file('picture');
			$imageName=$image->getClientOriginalName();
			$imageName = time() . $imageName;
			$image->move('images/vehicle',$imageName);
			$vehicle->picture = $imageName;
		  }
		  
		  $vehicle->name      = $request->createvehicle_name;
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
		  $vehicle->qrcode = $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no);
		  /////////////////////////////////////

		   
		  //  sms

		  /////////////////////////////////////////
		  
		  $vehicle->save();
		  return redirect('/user/vehicles');
		}
		$countries = Country::get();
		$states    = Zone::where('country_id',   '184')->get();
		return view('user/vehicle/new', compact('countries', 'states'));
	}
	
	
	private function getnerateqrcode($vehiclename, $model, $fueltype, $code){
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
		
		if( Auth::user()->picture)
			$input_path  = base_path('images/userprofile/'. Auth::user()->picture);
		else
			$input_path  = base_path('images/default-user.png');
		
		$result_path =   time() . '.png';
		$output_path = base_path('images/qr/'.$result_path);
		QrcodeClass::generate($text,$input_path ,$output_path, $color);
		return $result_path;
	}
	
	public function update(Request $request, $id){
		 $vehicle = Vehicle::find($id);
		 if ($request->isMethod('post')) {
			  $this->validate($request, Vehicle::rules());
			  if(isset($vehicle)){
				   if ($request->hasFile('picture')){
					$image=$request->file('picture');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/vehicle',$imageName);
					$vehicle->picture = $imageName;
				  }
				  $vehicle->name      = $request->createvehicle_name;
				  $vehicle->user_id   = Auth::user()->id;
				  $vehicle->type      = $request->createvehicle_type;
				  $vehicle->model     = $request->createvehicle_model;
				  $vehicle->fuel      = $request->createvehicle_fuel;
				  $vehicle->oil       = $request->createvehicle_oil;
				  $vehicle->state     = $request->createvehicle_state;
				  $vehicle->city      = $request->createvehicle_city;
				 // $vehicle->country   = $request->createvehicle_coutry;
				  $vehicle->country   = 184;
				  $vehicle->password  = bcrypt($request->createvehicle_password);
				  // delete past qrcode image
				  unlink( base_path('images/qr/'.$vehicle->qrcode )); 

				  $vehicle->qrcode =  $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no);
				  $vehicle->save();
				  return redirect('/user/vehicles');
			  }
			  else{
				  return redirect('/errors/404');
			  }
				   
		 }
		  
		 $countries = Country::get();
		 $states    = Zone::where('country_id',  $vehicle->country)->get();
		 
		 return view('user/vehicle/new', compact('countries', 'states' ,'vehicle'));
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
				$vehicle->qrcode = $this->getnerateqrcode($vehicle->name, $vehicle->model, $vehicle->fuel,  $vehicle->no);
				$vehicle->save();
				return response()->json(['error' => 0 ,   'result' => 'success']);  
			}
			else{
				return response()->json(['error' => 1 ,   'result' => 'wrong_id']);  
			}
				 
	}
	
	public function usernotification_export(Request $request){
		$vehicles = Vehicle::select('vehicles.*')
		->where('user_id', '=', Auth::user()->id)
		->get();

		Excel::create('selfstation', function($excel)  use($vehicles)  {
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
		return view('user/notification/notification', ['vehicles' => $vehicles->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function adminnotification(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$user_id = Auth::user()->id;
		$setting['pagesize'] = $page_size;
		$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
							->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
							->paginate($page_size);
		
		if($request->isMethod('post')){
			foreach($vehicles as $vehicle){
				$vehicle->not_type     =  $request->{'not_type_' .     $vehicle->id};
				$vehicle->not_wash 	   =  $request->{'not_wash_' . $vehicle->id};
				$vehicle->not_status   =  $request->{'not_status_' .    $vehicle->id};
				$vehicle->not_times    =  $request->{'not_times_' .$vehicle->id};
				$vehicle->not_oil      =  $request->{'not_oil_' .  $vehicle->id};
				$vehicle->not_amount   =  $request->{'not_amount_'.$vehicle->id};
				$vehicle->save();
				
			}
		}
		return view('admin/notification', ['vehicles' => $vehicles->appends(Input::except('page')), 'setting' => $setting]);
	}

	public function adminnotification_export(Request $request){
		$vehicles = Vehicle::select('vehicles.*', 'users.name as username')
		->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
		->get();

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

		return view('/user/vehicle/qrcode', compact('vehicle'));
	}

	public function export(Request $request){
		$user_id = Auth::user()->id;
		$vehicles = Vehicle::where('user_id', '=', $user_id)->get();
		Excel::create('vehicles', function($excel)  use($vehicles)  {
			$excel->sheet('users', function($sheet)  use($vehicles)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.status') , trans('app.reg_date'),
					 
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
}
