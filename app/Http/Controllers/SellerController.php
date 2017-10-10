<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth, DB, Validator, URL, Redirect;
use App\Fuelstation;
use App\Country;
use App\Zone;
use App\User;
use App\Sellercoupon;
use Carbon\Carbon;
use App\Contactus;
use App\Operation;
use App\Selleremployee;
use App\Transactions;
use App\Sellerrole;
use Excel, Session;
use Illuminate\Support\Facades\Input;
class SellerController extends Controller
{
    //
	
	public function fuelstation_export(Request $request){
		
		$fuelstations =  Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
						 ->where('fuelstation.user_id', '=', Auth::user()->id)
						 ->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
					     ->get();
		Excel::create('fuelstation', function($excel)  use($fuelstations)  {
			$excel->sheet('seller', function($sheet)  use($fuelstations)  {
				// add header
				$sheet->appendRow(array(
					trans('app.no'), trans('app.name'), trans('app.status') , trans('app.position'), trans('app.pos_status'),trans('app.reg_date')
				));
				
				foreach ($fuelstations as $fuelstation) {
					$row    = array();
					$row[]  = $fuelstation->no;
					$row[]  = $fuelstation->name;
					$row[]  = $fuelstation->statename . '-'  .$fuelstation->city;
					
					if($fuelstation-> status) $row[] =  trans('app.working');
					else 					  $row[] =  trans('app.not_working');
					
					if($fuelstation-> pos_status) $row[] =  trans('app.working');
					else 					      $row[] =  trans('app.not_working');
					
					$row[] = $fuelstation->created_at;
					$sheet->appendRow($row);
				}
			});
		})->download('xls');
	}
	
	public function fuelstation(Request $request){
		//Fuelstation
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;

		$user_id = Sellerrole::get_seller_id(Auth::user()->id);	 
		$setting['pagesize'] = $page_size;
	
		if($request->key !== null){
			$setting['key'] = $request->key;		 
			
			if(Auth::user()->usertype == '1')
				$fuelstations = Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
							->where('fuelstation.user_id', '=', $user_id)
							->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
							->where(function ($query) use ($request) {
								$query->where('fuelstation.name',  'like',  '%'. $request->key . '%')
								->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
								->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
							})
							->paginate($page_size);
			else{
				$sellerrole = Sellerrole::where('user_id', Auth::user()->id)->first();
				$fuelstations = Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
				->where('fuelstation.user_id', '=', $user_id)
				->where('state', $sellerrole->state)
				->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
				->where(function ($query) use ($request) {
					$query->where('fuelstation.name',  'like',  '%'. $request->key . '%')
					->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
					->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
				})
				->paginate($page_size);
			}
				
		}
		else{
			$setting['key'] = "";

			if(Auth::user()->usertype == '1')
				$fuelstations =  Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
						 ->where('fuelstation.user_id', '=', $user_id)
						 ->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
						 ->paginate($page_size);
			else{
				$sellerrole = Sellerrole::where('user_id', Auth::user()->id)->first();
				$fuelstations =  Fuelstation::select('fuelstation.*', 'oc_zone.name as statename')
					->where('fuelstation.user_id', '=', $user_id)
					->where('state', $sellerrole->state)
					->leftJoin('oc_zone', 'fuelstation.state', '=', 'oc_zone.zone_id')
					->paginate($page_size);
			}
		}				 
		 		 
		if ($request->isMethod('post')){
			foreach($fuelstations as $fuelstation){
					$fuelstation->pos_status  =  $request->{'pos_status_' .  $fuelstation->id};
					$fuelstation->save();
					$fuelstation->status  =  $request->{'status_' .  $fuelstation->id};
					$fuelstation->save();
			}
		}
		return view('seller/fuelstation/index', ['fuelstations' => $fuelstations->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function fuelstationcreate(Request $request){
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);
			if($request->isMethod('post')){
				    $this->validate($request, Fuelstation::rules());
					$fuelstation = new Fuelstation;
					$fuelstation->name      = $request->name;
					$fuelstation->user_id   = $user_id;
					$fuelstation->lat       = $request->lat;
					$fuelstation->lng       = $request->lng;
					$fuelstation->state     = $request->state;
					$fuelstation->city      = $request->city;
					$fuelstation->no        = Fuelstation::generatevalue();
					//$fuelstation->country   = $request->country;

				if($request->fuel !== null)
				  foreach($request->fuel as  $value){
					  if( $value == 1)    $fuelstation->f_g = 1;
					  if( $value == 2)    $fuelstation->f_r = 1;
					  if( $value == 3)    $fuelstation->f_d = 1;
				  }
				
				  if($request->oil !== null)
				  foreach($request->oil as  $value){
					  if( $value == 1)    $fuelstation->s_f = 1;
					  if( $value == 2)    $fuelstation->s_w = 1;
					  if( $value == 3)    $fuelstation->s_o = 1;
				  }
				
				$fuelstation->save();
				return redirect('/seller/fuelstation');
			}
			 
			$countries = Country::get();
			$states    = Zone::where('country_id',  '184')->get();
			return view('seller/fuelstation/new', compact('countries', 'states'));
	}

	public function fuelstationupdate(Request $request, $id){
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);

		$fuelstation = Fuelstation::where('no',$id)
							->where('user_id', $user_id)
							->first();

		if ($request->isMethod('post')) {
			if(isset($fuelstation)){
				  $this->validate($request, Fuelstation::rules());
				  $fuelstation->name      = $request->name;
				  $fuelstation->user_id   = $user_id;
				  $fuelstation->lat       = $request->lat;
				  $fuelstation->lng       = $request->lng;
				  $fuelstation->state     = $request->state;
				  $fuelstation->city      = $request->city;
				  $fuelstation->country   = $request->country;

				if($request->fuel !== null)
				  foreach($request->fuel as  $value){
					  if( $value == 1)    $fuelstation->f_g = 1;
					  if( $value == 2)    $fuelstation->f_r = 1;
					  if( $value == 3)    $fuelstation->f_d = 1;
				  }
				  /*
				  foreach($request->oil as  $value){
					  if( $value == 1)    $fuelstation->s_f = 1;
					  if( $value == 2)    $fuelstation->s_w = 1;
					  if( $value == 3)    $fuelstation->s_o = 1;
				  }*/
				  $fuelstation->save();
			}
			else
				return view("errors/404");
		 }
		 
		 
		 $countries = Country::get();
		
		 $states    = Zone::where('country_id',  $fuelstation->country)->get();
		 return view('seller/fuelstation/new', compact('countries', 'fuelstation', 'states'));
	}
	
	public function fuelstationdelete(Request $request, $id){
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);

		$fuelstation = Fuelstation::where('no',$id)
									->where('user_id', Auth::user()->id)
									->first();
			
		if(isset($fuelstation)){
			$fuelstation->delete();
			return Redirect::back()->withErrors(['success']);
		}
		else
			return view('errors.404');
	}
	
	public function couponsdelete($id){
		$sellercoupon =  sellercoupon::find($id);
		$sellercoupon->delete();
		return redirect('/seller/coupons');
	}
	
	public function couponsupdate(Request $request, $id){
		$sellercoupon =  sellercoupon::find($id);
		if(!isset($sellercoupon)) return view("errors/404");
		if($request->isMethod('post')){
			$this->validate($request, Sellercoupon::rules());

			$startdate = new Carbon($request->startdate);
			$sellercoupon->startdate = $startdate->toDateTimeString();
			 
			if($request->enddate){
				$enddate   = new Carbon($request->enddate);
				$sellercoupon->enddate   = $enddate->toDateTimeString(); 
			}
			
			$sellercoupon->amount    = $request->amount;
			$sellercoupon->type	     = $request->type;
			$sellercoupon->save();
			return redirect('/seller/coupons');
		}
		return view('seller/coupons/create', compact('sellercoupon'));
	}
	
	public function couponscreate(Request $request){
		
		if ($request->isMethod('post')) {

			$this->validate($request, Sellercoupon::rules());

			$user_id = Sellerrole::get_seller_id(Auth::user()->id);
			

		    $sellercoupon = new Sellercoupon;
			 

			$startdate = new Carbon($request->startdate);
			$sellercoupon->startdate = $startdate->toDateTimeString();
			 
			 if($request->enddate){
				 $enddate   = new Carbon($request->enddate);
				 $sellercoupon->enddate   = $enddate->toDateTimeString(); 
			 }
			
			 $sellercoupon->amount    =  $request->amount;
			 $sellercoupon->user_id   =  $user_id ;
			 $sellercoupon->code 	  =  Sellercoupon::generatevalue();
			 $sellercoupon->type	  =  $request->type;
			 $sellercoupon->save();
			 return redirect('/seller/coupons');
		 }
		 
		// $sellercoupon = Sellercoupon::where('user_id', Auth::user()->id)->first();
		  
		 return view('seller/coupons/create', compact('sellercoupon'));
	
	}
	
	public function coupons(Request $request){
		$page_size = 10;
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);
		if($request->pagesize !== null)
			$page_size = $request->pagesize;

			if($request->key !== null){
				$setting['key'] = $request->key;

				if(Auth::user()->usertype == "1")
					$coupons = Fuelstation::where('user_id', $user_id)
										->where(function ($query) use ($request) {
											$query->where('name',  'like',  '%'. $request->key . '%')
											->orWhere('sale_amount', 'like','%'. $request->key . '%')
											->orWhere('no', 'like','%'. $request->key . '%')
											->orWhereDate('startdate', 'like','%'. $request->key . '%')
											->orWhereDate('endDate', 'like','%'. $request->key . '%');
										})
							->paginate($page_size);	 
				else{
					$sellerrole = Sellerrole::where('user_id', Auth::user()->id)->first();
					$coupons =  Fuelstation::where('user_id', $user_id)
								->where('state', $sellerrole->state)
								->where(function ($query) use ($request) {
									$query->where('name',  'like',  '%'. $request->key . '%')
									->orWhere('sale_amount', 'like','%'. $request->key . '%')
									->orWhere('no', 'like','%'. $request->key . '%')
									->orWhereDate('startdate', 'like','%'. $request->key . '%')
									->orWhereDate('endDate', 'like','%'. $request->key . '%');
								})
					->paginate($page_size);	 
				}
			}
			else{
				$setting['key'] = "";
				if(Auth::user()->usertype == "1")
					$coupons =  Fuelstation::where('user_id', $user_id)
											->paginate($page_size);
				else{
					$sellerrole = Sellerrole::where('user_id', Auth::user()->id)->first();
					$coupons =  Fuelstation::where('user_id', $user_id)
								->where('state', $sellerrole->state)
								->paginate($page_size);
				}
			}

		if($request->isMethod('post')) {
			foreach($coupons as $coupon){
					$coupon->sale_amount  =  $request->{'sale_amount_' .  $coupon->no};
					$coupon->sale_type  =  $request->{'sale_type_' .  $coupon->no};
					$coupon->sale_status  =  $request->{'sale_status_' .  $coupon->no};
					$coupon->startdate  =  $request->{'startdate_' . $coupon->no};
					$coupon->enddate    =  $request->{'enddate_' .  $coupon->no};				 
					$coupon->save();
			}
		}
		
		$setting['pagesize'] = $page_size;
		return view('seller/coupons/coupons', ['coupons' => $coupons->appends(Input::except('page')), 'setting' => $setting]);
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
			return view('seller/contactus/index', compact('message'));
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
		 
		 return view('seller/usersettings/usersetting', compact('message', 'countries', 'states', 'user'));
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
				
		$setting['fuelstation'] = "";
		$setting['state'] = "";
		$setting['city'] = "";
		$setting['service_type'] = "";
		//$setting['fuelstations'] = "";
		
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);
		$sql = "";
		
		if(null !== $request->input('from_amount'))
		{
			$setting['from_amount'] = $request->input('from_amount');
			
			if($sql != "") $sql  .= " and ";
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
			$sql .= 'transactions.created_at > "' . 	$setting['from_date'] .'"';
		}
		
		
		if(null !== $request->input('to_date'))
		{
			$to_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			$setting['to_date'] = $to_date;
			$to_date->addDay(); 
			if($sql != "") $sql  .= " and ";
			$sql .= 'transactions.created_at < "' . 	$to_date .'"';
		}
		
		if(null !== $request->input('fuelstation'))
		{
			$setting['fuelstation'] = $request->input('fuelstation');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' fuelstation.no = "' . 	$setting['fuelstation']  . '"';
		}
		

		if(null !== $request->input('state'))
		{
			$setting['state'] = $request->input('state');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' fuelstation.state = "' . 	$setting['state']  . '"';
		}

		if(null !== $request->input('city'))
		{
			$setting['city'] = $request->input('city');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' fuelstation.city = "' . 	$setting['city']  . '"';
		} 

		if(null !== $request->input('service_type'))
		{
			$setting['service_type'] = $request->input('service_type');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' transactions.type = "' . 	$setting['service_type']  . '"';
		} 


		
		if($sql == "") $sql = "1";
		
		if($request->key !== null){
			$setting['key'] = $request->key;		
			$transactions = Transactions::orderBy('transactions.created_at')
							->where('transactions.operator_id', $user_id)
							->select('transactions.created_at','transactions.no', 'transactions.type', 'transactions.reference_id', 'transactions.amount', 'transactions.created_at as regdate')
							->whereRaw($sql)
							->where('transactions.type', '4')
							->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
						  	->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
						  	->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
						  	->where(function ($query) use ($request) {
								 $query->where('fuelstation.name',  'like',  '%'. $request->key . '%')
									->orWhere('oc_zone.name', 'like','%'. $request->key . '%')
									->orWhere('fuelstation.city', 'like','%'. $request->key . '%'); 
							})
						  ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$transactions = Transactions::orderBy('transactions.created_at')
							->select('transactions.created_at','transactions.no', 'transactions.type', 'transactions.reference_id', 'transactions.amount', 'transactions.created_at as regdate')
							->where('transactions.operator_id', $user_id)
							->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
							->leftJoin('fuelstation', 'fuelstation.no', '=', 'operation.fuelstation')
							->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
							->whereRaw($sql)
							->paginate($page_size);
			}	
				
			foreach ($transactions as $key => $value) {
			 
				switch ($value->type) { 
					case '4':
							$fuelstation = Operation::where('operation.id', $value->reference_id)
												->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
												->leftJoin('oc_zone', 'oc_zone.zone_id', '=', 'fuelstation.state')
												->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name', 'operation.service_type')
												->first();
							$value->details = $fuelstation;
							
						break;
					default:
						break;
				}
			
		}		
		
		
		$fuelstations = Fuelstation::where("user_id", Auth::user()->id)->get();
		$states       = Fuelstation::where("user_id", Auth::user()->id)
									->leftJoin('oc_zone', 'oc_zone.zone_id', '=','fuelstation.state')
									->select('oc_zone.zone_id', 'oc_zone.name')
									->groupBy('fuelstation.state')
									->get();

		$cities       = Fuelstation::where("user_id", Auth::user()->id)
									->select('fuelstation.city')
									->groupBy('fuelstation.city')
									->get();


		return view('seller/reports/reports', compact('setting', 'transactions', 'fuelstations', 'states', 'cities'));
	}
	
	public function reports_export(Request $request){
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);


		$transactions = Transactions::orderBy('transactions.created_at')
		->select('users.name', 'transactions.created_at','users.first_name', 'users.last_name', 'transactions.no', 'transactions.type', 'transactions.reference_id', 'users.usertype', 'transactions.amount', 'transactions.created_at as regdate')
		->leftJoin( 'users' ,'transactions.operator_id', '=', 'users.id')
		->where('transactions.operator_id', $user_id)
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
													->select('fuelstation.city', 'oc_zone.name as state', 'fuelstation.name', 'operation.service_type')
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
	
	public function reportsdetails(Request $request, $id){
		$user_id = Sellerrole::get_seller_id(Auth::user()->id);

		$operation = Operation::where('operation.no', $id)
							->where('operation.owner_id', $user_id)
							->leftJoin('users', 'operation.receiver_id',  '=', 'users.id')
							->leftJoin('fuelstation', 'fuelstation.no', '=','operation.fuelstation')
							->select('operation.amount', 'users.name', 'operation.no', 'operation.type', 'fuelstation.name as fuelstationname', 'fuelstation.city', 'fuelstation.no as fuelnumber', 'operation.updated_at as regdate')
							->first();



		if(isset($operation))
			return view('seller/reports/details', compact('operation'));
		else
			return view('errors.404');
	}
	
	
	
	//////////////////////// seller employeeres action ///////////////////////////////////////////////
	public function employeers(Request $request){
		$page_size = 10;
		$setting = array();
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$setting['pagesize'] = $page_size;
		 
		if($request->key !== null){
			$setting['key'] = $request->key;
			$employeers =  Selleremployee::select('selleremployee.*', 'users.name', 'users.email' ,'users.no', 'fuelstation.name as fuelstationname')
					->where('fuelstation.user_id', '=', Auth::user()->id)
					->leftJoin('fuelstation', 'fuelstation.id', '=', 'selleremployee.fuelstation_id')
					->leftJoin('users', 'users.id', '=', 'selleremployee.id')
					->where(function ($query) use ($request) {
								 $query->where('fuelstation.name',  'like',  '%'. $request->key . '%')
									->orWhere('users.first_name', 'like','%'. $request->key . '%')
									->orWhere('users.last_name', 'like','%'. $request->key . '%')
									->orWhere('users.name', 'like','%'. $request->key . '%');
					})
					->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$employeers =  Selleremployee::select('selleremployee.*', 'users.name','users.email' ,'users.no', 'fuelstation.name as fuelstationname')
					->where('fuelstation.user_id', '=', Auth::user()->id)
					->leftJoin('fuelstation', 'fuelstation.id', '=', 'selleremployee.fuelstation_id')
					->leftJoin('users', 'users.id', '=', 'selleremployee.user_id')
					->paginate($page_size);
		}
		return view('seller/employeer/employeer', compact('setting', 'employeers'));
	}
	private function generatevalue(){
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
	public function employeerscreate(Request $request){
		
		$fuelstations = Fuelstation::where('user_id', Auth::user()->id)->get();
		
		if($request->isMethod('post')){
		 
			$validator = Validator::make($request->all(),
					[ 
					  'email'   	   => 'required|email|unique:users',
					  'first_name'     => 'required|max:255',
					  'last_name'      => 'required|max:255',
					  'phone'          => 'required|unique:users',
					  'password' 	   => 'required|min:6|confirmed',
					  'fuelstation'    => 'required',
				//	  'service'        => 'in:1,2,3|required',
					]
			  )->validate();
			  
			  $user = new User;
			  $user->name   	=  $request->first_name . ' ' . $request->last_name;
			  $user->first_name   	=  $request->first_name;
			  $user->last_name   	=  $request->last_name;
			  $user->no     	=  $this->generatevalue();
			  $user->email   	=  $request->email;
			  $user->usertype   =  4;
			  $user->phone      =  $request->phone;
			  $user->password   =  bcrypt($request->password);
			  $user->save();
			  
			$employeer = new Selleremployee();
			$employeer->user_id       	 =  $user->id;
			$employeer->seller_id        =  Auth::user()->id;
			$employeer->fuelstation_id   =  $request->fuelstation; 
			//$employeer->service   	 =  $request->service;
			$employeer->service   	     =  1;
			$employeer->save();
			return redirect('/seller/employeers');
		}
		
		return view('seller/employeer/newemployee', compact('fuelstations'));
	}

 
	public function employeerdelete(Request $request, $id){
			$user = User::where('users.no',$id)
			        ->select('selleremployee.*')
			        ->where('selleremployee.seller_id', Auth::user()->id)
					->leftJoin('selleremployee', 'users.id', '=', 'selleremployee.user_id')
					->first();
			 
			if(isset($user)){
				$selleremployee = Selleremployee::find($user->id);
				$selleremployee->delete();
				$user_data = User::where('users.no', $id)->first();
				$user_data->delete();
				return Redirect::back()->withErrors(['success']);
			}
			else
				return view('errors.404');
	}

	public function employeerupdate(Request $request, $id){
		$selleremployee = User::where('users.no',$id)
		->select('selleremployee.*', 'users.first_name', 'users.last_name', 'users.email', 'users.phone', 'users.no')
		->where('selleremployee.seller_id', Auth::user()->id)
		->leftJoin('selleremployee', 'users.id', '=', 'selleremployee.user_id')
		->first();
		if(!isset($selleremployee)) return view('errors/404');

		$fuelstations = Fuelstation::where('user_id', Auth::user()->id)->get();
		if($request->isMethod('post')){
			
			$validator = Validator::make($request->all(),
			[ 
			'email'   	     => 'required|email',
			'first_name'     => 'required|max:255',
			'last_name'      => 'required|max:255',
			'phone'          => 'required',
			'fuelstation'    => 'required',
		//	  'service'        => 'in:1,2,3|required',
			]
			)->validate();
			
			$user = User::where("no", $id)->first();
			
			if($request->email != $selleremployee->email){
				$validator = Validator::make($request->all(),
				[ 
				'email'   	   => 'required|email|unique:users',
				]
				)->validate();
				$user->email   	=  $request->email;
				$user->save();
			}

			if($request->phone != $selleremployee->phone){
				$validator = Validator::make($request->all(),
				[ 
				'email'   	   => 'phone|unique:users',
				]
				)->validate();
				$user->phone      =  $request->phone;
				$user->save();
			}

			if($request->password !== null){
				$validator = Validator::make($request->all(),
				[ 
					'password' 	   => 'required|min:6|confirmed',
				]
				)->validate();
				$user->password   =  bcrypt($request->password);
				$user->save();
			}
			$user->name       	=  $request->first_name . ' ' . $request->last_name;
			$user->first_name   =  $request->first_name;
			$user->last_name   	=  $request->last_name;
			$user->save();
			return redirect('seller/employeers');
		}
	 
		return view('seller/employeer/newemployee', compact('fuelstations', 'selleremployee'));
	}


	public function workercreate(Request $request){
		
		$countries = Country::get();
		$states    = Zone::where('country_id',  '184')->get();
 
		if($request->isMethod('post')){
			 $validator = Validator::make($request->all(),
				   [ 'picture' 		  => 'image|mimes:jpeg,bmp,png',
					 'email'    	  => 'required|email',
					 'first_name'     => 'required|max:255',
					 'last_name'      => 'required|max:255',
					 'phone'    	  => 'required|max:255|unique:users',
					 'password' 	  => 'required|min:6|confirmed',
					 'role'           => 'required'
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
			 $user->usertype   =  5; //seller employee
			 $user->password   =  bcrypt($request->password);
			 $user->phone      =  $request->phone;
			 $user->state      =  $request->state;
			 //$user->country    =  $request->country;
			 $user->country    =  184;
			 $user->save();
			 
			 $role = new Sellerrole;
			 $role->user_id    = $user->id;
			 $role->state      = $user->state;  
			 $role->master_id  = Auth::user()->id; 
			 foreach($request->role as $item){
				   switch($item){
					   case 1:  //Manager Users
						   $role->m_fuelstation = 1;
						   break;
					   case 2:   //Manager Paymentmethods
						   $role->m_report = 1;
						   break;
					   case 3:   //Manager Fees
						   $role->m_coupon = 1;
						   break;
				   }
		   }
		   $role->save();
		   Session::flash('success', 'success');
		}
		return view('seller/employeer/newworker', compact('countries', 'states'));
	}
}
