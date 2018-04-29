<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Country;
use App\Bank;
use App\Card;
use App\Deposit;
use App\Withdraw;
use App\Fuelstation;
use Auth, Redirect, DB, Session, Validator, Hash, PDF;
use App\Coupon;
use App\Voucher;
use App\Setting;
use App\Operation;
use App\Vehicle;
use App\User;
use App\Selleremployee;
use App\Fees;
use Excel;
use Carbon\Carbon;
use JWTAuth;
use App\Transactions;
use App\Subfeemanagement;
use App\Couponhistory;
use App\History;
use App\Reward;
use App\Voucherhistory;
use Tymon\JWTAuth\Exceptions\JWTException;

   
class OperationController extends Controller
{
    //
	public function widthrawls(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
		$page_size = $request->pagesize;
		$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'withraw.user_id')
						->where("withraw.user_id", Auth::user()->id)
					    ->paginate($page_size);
		
		if($request->isMethod('post')){
			//
		}
		
		$setting['pagesize'] = $page_size;
	    return view('user/operation/withdraws', ['withdraws' => $withdraws->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function widthraw(Request $request){
		//widthraw
		if ($request->isMethod('post')) {
			$this->validate($request, Withdraw::rules());
				$withdraw  = new Withdraw;
				$withdraw->user_id  = Auth::user()->id;
				$withdraw->no       = Withdraw::generatevalue();
				$withdraw->amount   = $request->amount;
				$withdraw->save();
				//$request->session()->flash('status', 'Request is sent successfully.');
				//$request->session()->put('status', 'value');;
				Session::flash('status', 'Request is sent successfully.');

				$transaction = new Transactions;
				$transaction->operator_id = Auth::user()->id;
				$transaction->reference_id = $withdraw->id;
				$transaction->type = 2;
				$transaction->amount =  $request->amount;
				$transaction->no = Transactions::generatevalue();
				$transaction->save();


				return redirect('/user/operations/widthrawls');
		}
		return view('user/operation/widthraw');
	}
	
	private function validatecard($number){
		$cardtype = array(
			"visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
			"mastercard" => "/^5[1-5][0-9]{14}$/",
			//"amex"       => "/^3[47][0-9]{13}$/",
			//"discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
		);

		if (preg_match($cardtype['visa'],$number))
		{
			//return 'visa';
			return 2;
		}
		else if (preg_match($cardtype['mastercard'],$number)){
			//return 'mastercard';
			return 1;
		}
		/*
		else if (preg_match($cardtype['amex'],$number))
		{
			return 'amex';
		
		}
		else if (preg_match($cardtype['discover'],$number))
		{
			return 'discover';
		}*/
		else
		{
			return false;
		} 
	 }
	
	public function deposits(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
		$page_size = $request->pagesize;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where("deposit.user_id", Auth::user()->id)
						->where(function ($query) use ($request){
							 $query->where('deposit.no', 'like','%'. $request->key . '%')
								->orWhere('users.first_name', 'like','%'. $request->key . '%')
								->orWhere('users.last_name', 'like','%'. $request->key . '%')
								->orWhere('deposit.amount', 'like','%'. $request->key . '%'); 
						})
					    ->paginate($page_size);
 
						
		}
		else{
			$setting['key'] = "";
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where("deposit.user_id", Auth::user()->id)
					    ->paginate($page_size);
		}
		
		if($request->isMethod('post')){
		 
		}
		
		$setting['pagesize'] = $page_size;
		$title = trans('app.deposit');
	    return view('user/operation/deposits', ['deposits' => $deposits->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
	
	
	public function api_deposit(Request $request){
		$setting = array();
		$setting['type']  = "";
		$validator =  Validator::make($request->all(), [
			'cardtype' => 'in:card,bank,exist|required', // DEFAULT or SOCIAL values
		]);
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} 
		
		if($request->cardtype !== null){
			$setting['type'] = $request->cardtype;
		}
		if($request->cardtype == 'card'){
			$setting['countries'] = Country::get();
		}
		
		if($request->cardtype == 'exist'){
			$cards = Card::where('user_id', Auth::user()->id)->get();
			$setting['cards']    = $cards;
		}
		$user = JWTAuth::parseToken()->authenticate();
		if($setting['type'] == "bank"){
			
			// check first
			$deposit  = new Deposit;
			if ($request->hasFile('picture')){
				$validator =  Validator::make($request->all(), [
						'amount'         =>    'required|integer',
						'picture' 		 =>    'image|mimes:jpeg,bmp,png',
				]);
			}
			else{
				$validator =  Validator::make($request->all(), [
						'amount'         =>    'required|integer',
						'full_name'      =>    'required',
						'bank_name'      =>    'required',
						'time'           =>    'required',
						'date'           =>    'required'
				]);
			}
			 
			if($validator->fails()){
				$errors = $validator->errors();
				return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
			}
			
			if( $request->amount < 0.01)
				return  response()->json(['error' => 1 ,  'msg' => ['amount'=> "low_amount"]]);
			
			
			if ($request->hasFile('picture')){
				$image=$request->file('picture');
				$imageName=$image->getClientOriginalName();
				$imageName = time() . $imageName;
				$image->move('images/bankdeposit_123',$imageName);
				$deposit->notes = $imageName;
				$deposit->paymentid = 0;
			}
			else{
				$bank = Bank::where('full_name',  '=', $request->full_name)
							->where('bank_name', '=', $request->bank_name)
							->where('time', '=', $request->time)
							->where('date', '=', $request->date)
							->first();
				if(!isset($bank)){
					$bank = new Bank;
					$bank->full_name = $request->full_name;
					$bank->bank_name = $request->bank_name;
					$bank->time 	 = $request->time;
					$bank->date 	 = $request->date;
					
					$bank->user_id  = 	$user->id;
					$bank->save();
				}
				$deposit->paymentid = $bank->id;
			}
				$deposit->amount         =   $request->amount;
				$deposit->real_amount    =   $request->amount;

				/*
				if($request->coupon){
					$validator =  Validator::make($request->all(), [
						'coupon'         =>    'exists:coupon,code'
					]); 

					if($validator->fails()){
						$errors = $validator->errors();
						return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
					}
				 
					$coupon = Coupon::where('code', $request->coupon)
									->whereDate('limit_date', '>=', Carbon::today()->toDateString())
									->where('status', 1)
									->first();

					if(!isset($coupon)){
						return response()->json(['error' => 1 ,  'msg' =>array('coupon'=> 'expired')]);
					}
					$coupon->current_amount = $coupon->current_amount + 1;
					if($coupon->current_amount >= $coupon->limit_users){
						$coupon->status = 0;
						$coupon->save();
					}
					$deposit->real_amount = Coupon::calculatorcoupon($coupon->code, $deposit->real_amount);
					$deposit->reward   = $deposit->amount - $deposit->real_amount;
				}
				*/
 
				$deposit->type     = 0;
				$deposit->user_id  = $user->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->save();

				/*
				if($request->coupon){
					$couponhistory = new Couponhistory;
					$couponhistory->user_id = $user->id;
					$couponhistory->coupon  = $request->coupon;
					$couponhistory->reference_id = $deposit->id;
					$couponhistory->no = Couponhistory::generatevalue();
					$couponhistory->save();
				}
				*/
			
		}else if($setting['type'] == "card"){
			
				$validator =  Validator::make($request->all(), [
					'cardno'         =>    'required',
					'expireyear'     =>    'required|integer',
					'expiremonth'    =>    'required|integer',
					'country'        =>    'required',
					'postalcode'     =>    'required',
					'holdername'     =>    'required',
					'amount'         =>    'required|integer'
				]);
				
				if($validator->fails()){
					$errors = $validator->errors();
					return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
				}
				 
				$card = Card::where('cardno',      '=', $request->cardno)
							->where('expireyear',  '=', $request->expireyear)
							->where('expiremonth', '=', $request->expiremonth)
							->where('country',     '=', $request->country)
							->where('postalcode',  '=', $request->postalcode)
							->where('holdername',  '=', $request->holdername)
							->first();
				
				//check card type
				if(!$this->validatecard($request->cardno)){
					return response()->json(['error' => 1 ,  'msg' => 'Wrong card number.' ]);
				}
				
				if(!isset($card)){
					$card = new Card;
					$card->cardno        = $request->cardno;
					$card->expireyear    = $request->expireyear;
					$card->expiremonth 	 = $request->expiremonth;
					$card->country 	     = $request->country;
					$card->postalcode 	 = $request->postalcode;
					$card->holdername 	 = $request->holdername;
					$card->type 	     = $this->validatecard($request->cardno);
					$card->user_id       = 	$user->id;
					$card->save();
				}
				 
				$deposit  = new Deposit;
				$deposit->type     = $this->validatecard($request->cardno);
				$deposit->user_id  =  $user->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->paymentid = $card->id;
				$deposit->save();
				
			}else if($setting['type'] == "exist"){
				
				$card = Card::where('id',      '=', $request->existing_card)
							->where('user_id',  '=', 	$user->id)
							->first();
				
				if(!isset($card)) return response()->json(['error' => 1 ,  'msg' => 'Wrong card number.' ]);
				 
				$deposit  = new Deposit;
				$deposit->type     = $this->validatecard($card->cardno);
				$deposit->user_id  = 	$user->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->paymentid = $card->id;
				$deposit->save();
			}else{
				return response()->json(['error' => 1 ,  'msg' => 'Please choose the card']);
			}
			return response()->json(['error' => 0 ,  'msg' => 'success']);
	}
 
	public function api_reports(Request $request){
		$validator =  Validator::make($request->all(), [
			'offset' => 'required', // DEFAULT or SOCIAL values
			'from_date' => 'date', 
			'to_date' => 'date', 
		//	'to_amount' => 'integer', 
		//	'from_amount' => 'integer', 
			'type' => 'in:0,1,2,3,4,5,6,7',
			'orderby' => 'in:amount,type,created_at'
		]);
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} 

		$setting = array();
		$setting['orderby'] = "transactions.created_at";
		$setting['orderby_direction'] = "desc";


		$setting['from_amount'] = "";
		$setting['to_amount'] = "";
		$setting['from_date'] = "";
		$setting['to_date'] = "";

		$setting['vehicle'] = "";
		$setting['state'] = "";
		$setting['city'] = "";
		$setting['type'] = "";

		$sql = "";
		$user = JWTAuth::parseToken()->authenticate();
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

		
		if(null !== $request->input('type'))
		{
			$setting['type'] = $request->input('type');
			
			if($sql != "") $sql  .= " and ";
			$sql .= ' transactions.type = "' . 	$setting['type']  . '"';
		} 
 
		if($sql == "") $sql = "1=1";
		 
		if(null !== $request->input('orderby'))
		{
			$setting['orderby'] = 'transactions.' . $request->input('orderby');
			
			$setting['orderby_direction'] = "DESC";
			 
		}
				 
		$transactions = Transactions::select('transactions.created_at','transactions.transtype' ,'transactions.no', 'transactions.type', 'transactions.reference_id', 'transactions.amount', 'transactions.created_at as regdate')
			->where('transactions.operator_id', Auth::user()->id)
			->whereRaw($sql)
			->leftJoin('operation', 'operation.id', '=', 'transactions.reference_id')
			->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
			->offset($request->offset)
			->orderBy($setting['orderby'], $setting['orderby_direction'])
			//->orderBy("transactions.amount", 'DESC')
			->limit(5)  
			->get();    
		 
		foreach ($transactions as $key => $value) {
			switch ($value->type) {
				case '0':
						$vehicle = Operation::where('operation.id', $value->reference_id)
										->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
										->select('vehicles.city', 'vehicles.name', 'operation.service_type', 'vehicles.no')
										->first();
						$value->detail = $vehicle;
					break;
				default:
					break;
			}
		}
		return response()->json(['error' => 0 ,  'result' => $transactions]);
	}
	 
	public function deposit(Request $request){
		$setting = array();
		$setting['type']  = "";
		
		if($request->cardtype !== null){
			$setting['type'] = $request->cardtype;
		}
		if($request->cardtype == 'card'){
			$setting['countries'] = Country::get();
		}
		
		if($request->cardtype == 'exist'){
			$cards = Card::where('user_id', Auth::user()->id)->get();
			$setting['cards']    = $cards;
		}
		 
		if ($request->isMethod('post')) {
			if($setting['type'] == "bank"){
				// check first
				 
				$validator = Validator::make($request->all(),  Bank::rules());
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator);
				}

				if( $request->amount < 0.01)
						return Redirect::back()->withErrors(['amount'=> trans('app.low_amount')]);
			 
				$deposit  = new Deposit;
				$deposit->amount         =   $request->amount;
				$deposit->real_amount    =   $request->amount;

			/*	if($request->coupon){
					
					$validator =  Validator::make($request->all(), [
						'coupon'         =>    'exists:coupon,code'
					]); 

					if ($validator->fails()) {
						return redirect()->back()->withInput()->withErrors($validator);
					}

					$coupon = Coupon::where('code', $request->coupon)
								->whereDate('limit_date', '>=', Carbon::today()->toDateString())
								->where('status', 1)
								->first();

					if(!isset($coupon)){
						return Redirect::back()->withErrors(['coupon'=> trans('app.expired')]); 	
						if ($validator->fails()) {
							return redirect()->back()->withInput()->withErrors($validator);
						}
		
					}
					$coupon->current_amount = $coupon->current_amount + 1;
					if($coupon->current_amount >= $coupon->limit_users){
						$coupon->status = 0;
						$coupon->save();

					}
					$deposit->real_amount = Coupon::calculatorcoupon($coupon->code, $deposit->real_amount);
					$deposit->reward   = $deposit->amount - $deposit->real_amount;
				}*/
				
				$bank = Bank::where('full_name',  '=', $request->full_name)
							->where('bank_name', '=', $request->bank_name)
							->where('time', '=', $request->time)
							->where('date', '=', $request->date)
							->first();
							
				if(!isset($bank)){
					$bank = new Bank;
					$bank->full_name = $request->full_name;
					$bank->bank_name = $request->bank_name;
					$bank->time 	 = $request->time;
					$bank->date 	 = $request->date;
					$bank->user_id  = Auth::user()->id;
					$bank->save();
				}

				if ($request->hasFile('attachment')){
					$image=$request->file('attachment');
					$imageName=$image->getClientOriginalName();
					$imageName = time() . $imageName;
					$image->move('images/bankdeposit_123',$imageName);
					$deposit->notes = $imageName;
				}
				
				$deposit->type      = 0;
				$deposit->user_id   = Auth::user()->id;
				$deposit->no        = Deposit::generatevalue();
				$deposit->paymentid =   $bank->id;
				//$deposit->coupon    =   $request->coupon;
				$deposit->save();
				
				/*
				if($request->coupon){
					$couponhistory = new Couponhistory;
					$couponhistory->user_id = Auth::user()->id;
					$couponhistory->coupon  = $request->coupon;
					$couponhistory->reference_id = $deposit->id;
					$couponhistory->no = Couponhistory::generatevalue();
					$couponhistory->save();
				}
				*/


			}else if($setting['type'] == "card"){
				$this->validate($request, Card::rules());
				$card = Card::where('cardno',      '=', $request->cardno)
							->where('expireyear',  '=', $request->expireyear)
							->where('expiremonth', '=', $request->expiremonth)
							->where('country',     '=', $request->country)
							->where('postalcode',  '=', $request->postalcode)
							->where('holdername',  '=', $request->holdername)
							->first();
				//check card type
				if(!$this->validatecard($request->cardno)){
					return Redirect::back()->withErrors(['Wrong card number.']);
				}
				if(!isset($card)){
					$card = new Card;
					$card->cardno        = $request->cardno;
					$card->expireyear    = $request->expireyear;
					$card->expiremonth 	 = $request->expiremonth;
					$card->country 	     = $request->country;
					$card->postalcode 	 = $request->postalcode;
					$card->holdername 	 = $request->holdername;
					$card->type 	     = $this->validatecard($request->cardno);
					$card->user_id       = Auth::user()->id;
					$card->save();
				}			
				
				$deposit  = new Deposit;
				$deposit->type     = $this->validatecard($request->cardno);
				$deposit->user_id  = Auth::user()->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->paymentid = $card->id;
				$deposit->save();
			}else if($setting['type'] == "exist"){
				$card = Card::where('id',      '=', $request->existing_card)
							->where('user_id',  '=',  Auth::user()->id)
							->first();
				
				if(!isset($card)) return Redirect::back()->withErrors(['Please choose the card']);
				 
				$deposit  = new Deposit;
				$deposit->type     = $this->validatecard($card->cardno);
				$deposit->user_id  = Auth::user()->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->paymentid = $card->id;
				$deposit->save();
			}else{
				return Redirect::back()->with(['Please choose the card']); 
			}

			return redirect('/user/operations/deposits');
		}
		$title = trans('app.deposit_request');
		return view('user/operation/deposit', compact('setting', 'title'));
	}
	
	public function depositmanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where(function ($query) use ($request){
							$query->where('deposit.no',  'like',  '%'. $request->key . '%')
							->orWhere('deposit.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('deposit.status')
						->orderBy('deposit.created_at')
						->paginate($page_size);
						
		}
		else{
			$setting['key'] = "";
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						 ->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						 ->orderBy('deposit.status')
						 ->orderBy('deposit.created_at')
					     ->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($deposits as $deposit){
				if($request->{'status_' .    $deposit->no}){
					$deposit->status    =  $request->{'status_' .    $deposit->no};
					if($deposit->status){
						 
						$transaction = 	Transactions::where('type', 1)
								->where('reference_id', $deposit->id)
								->where('operator_id',  $deposit->user_id)
								->first();
						if(isset($transaction))
							continue;
					
						//calculatefee
						$fee_data =  Fees::calculatefee($deposit->amount, 'deposit', 0);
						if($fee_data['status'] == 1){
							$transaction = new Transactions;
							$transaction->operator_id = $deposit->user_id;
							$transaction->reference_id = $deposit->id;
							$transaction->type = 1;

							$transaction->amount 	   =  $deposit->amount;
							$transaction->fee_amount   =  $fee_data['fee'];
							$transaction->final_amount =  $fee_data['amount'];
							$transaction->no = Transactions::generatevalue();
							$transaction->save();
							
							History::addHistory(Auth::user()->id, 3,  1, $deposit->id);

							$user = User::find($deposit->user_id);
							if(isset($user))
								User::sendMessage($user->phone, trans('sms.deposit_sms', ['no'=> $deposit->no, 'amount'=> $deposit->amount]));
			
							
						}
						else
							return Redirect::back()->withErrors([trans('app.low_value')]);
						// Transactions
					}
				$deposit->save();
			}
			else{
				if(Auth::user()->usertype == '2'){
					$transaction = 	Transactions::where('type', 1)
						->where('reference_id', $deposit->id)
						->where('operator_id',  $deposit->user_id)
						->first();

					if(isset($transaction)){
						$deposit->status = 0;
						$deposit->save();
						$transaction->delete();
						History::addHistory(Auth::user()->id, 3,  0, $deposit->id);
					}
				}
			   }
			}
		}
		
		$setting['pagesize'] = $page_size;

		$title = trans('app.operation_manager_deposit');
	    return view('admin/deposit', ['deposits' => $deposits->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
	
	public function depositmanagement_export_pdf(Request $request){
		
		if($request->key !== null){
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where(function ($query) use ($request){
							$query->where('deposit.no',  'like',  '%'. $request->key . '%')
							->orWhere('deposit.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('deposit.status')
						->orderBy('deposit.created_at')
						->get();
						
		}
		else{
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
								->leftJoin('users', 'users.id', '=', 'deposit.user_id')
								->get();
		}
		
		
		$title = trans('app.operation_manager_deposit');
		User::downloadPDF('admin/pdf/deposit_pdf', compact('deposits', 'title'));
	}

	public function depositmanagement_export(Request $request){
		
		if($request->key !== null){
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where(function ($query) use ($request){
							$query->where('deposit.no',  'like',  '%'. $request->key . '%')
							->orWhere('deposit.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('deposit.status')
						->orderBy('deposit.created_at')
						->get();
		}
		else{
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
								->leftJoin('users', 'users.id', '=', 'deposit.user_id')
								->get();
		}
					 
		Excel::create('selfstation', function($excel)  use($deposits)  {
				$excel->sheet('users', function($sheet)  use($deposits)  {
					$sheet->appendRow(array(
						trans('app.no'), trans('app.name'), trans('app.phone') , trans('app.type'), trans('app.amount'),
						 trans('app.attachment'), trans('app.date'), trans('app.approve')
					));	
					
					foreach($deposits as $deposit){
						$row = array();
						$row[] = $deposit->no;
						if($deposit->first_name)
							$row[] = $deposit->first_name . $deposit->last_name;
						else
							$row[] = $deposit->name;
						$row[] = $deposit->phone;

						switch($deposit->type){
							case '0':
								$row[]  = trans('app.bank');
								break;
							case '1':
								$row[]  =  trans('app.master');
								break;
							case '2':
								$row[] = trans('app.visa');
								break;
							case '3':
								$row[] = trans('app.sdad');
								break;
						}
						$row[] = $deposit->amount;
						$row[] = "";
						$row[] = $deposit->created_at;
						if($deposit->status)
							$row[] = trans('app.approved');
						else
							$row[] = trans('app.not_approved');
						
						$sheet->appendRow($row);
					}
				});
		})->download('xls');
		
	}
	
	public function  userdeposit(Request $request){
		
		if ($request->isMethod('post')) {
			
			$validator = Validator::make($request->all(),  Bank::rules());

			if ($validator->fails()) {
			 
				return redirect()->back()->withInput()->withErrors($validator);
			}
		 
			if( $request->amount < 0.01)
				return Redirect::back()->withErrors(['amount'=> trans('app.low_amount')]);
		 
			$validator =  Validator::make($request->all(), [
					'user_id'        =>    'required',
			]);

			if ($validator->fails()) {
				return redirect()->back()->withInput()->withErrors($validator);
			}
 
			$user = User::where('no', $request->user_id)
						->where('usertype', '0')
						->first();
			if(!isset($user))
				return redirect()->back()->withInput()->withErrors(['user_id'=> trans('app.invalid_user')]); 	
 
			$deposit  = new Deposit;
			$deposit->amount         =   $request->amount;
			$deposit->real_amount    =   $request->amount;
 
			$bank = Bank::where('full_name',  '=', $request->full_name)
						->where('bank_name', '=', $request->bank_name)
						->where('time', '=', $request->time)
						->where('date', '=', $request->date)
						->first();
						
			if(!isset($bank)){
				$bank = new Bank;
				$bank->full_name = $request->full_name;
				$bank->bank_name = $request->bank_name;
				$bank->time 	 = $request->time;
				$bank->date 	 = $request->date;
				$bank->user_id  =  	$user->id;
				$bank->save();
			}

			if ($request->hasFile('attachment')){
				$image=$request->file('attachment');
				$imageName=$image->getClientOriginalName();
				$imageName = time() . $imageName;
				$image->move('images/bankdeposit_123',$imageName);
				$deposit->notes = $imageName;
			}
			
			$deposit->type      =    0;
			$deposit->user_id   =	$user->id;
			$deposit->no        =   Deposit::generatevalue();
			$deposit->paymentid =   $bank->id;
			$deposit->coupon    =   $request->coupon;
			//$deposit->status    =   1;
			$deposit->save();
		
			/****************************** */
			/*
			//calculatefee
			$fee_data =  Fees::calculatefee($deposit->amount, 'deposit', 0);
			if($fee_data['status'] == 1){
				$transaction = new Transactions;
				$transaction->operator_id = $deposit->user_id;
				$transaction->reference_id = $deposit->id;
				$transaction->type = 1;

				$transaction->amount 	   =  $deposit->amount;
				$transaction->fee_amount   =  $fee_data['fee'];
				$transaction->final_amount =  $fee_data['amount'];
				$transaction->no = Transactions::generatevalue();
				$transaction->save();
			}*/
			History::addHistory(Auth::user()->id, 3,  2, $deposit->id);
			//return redirect('/admin/depositmanagement');
			Session::flash('success', 'Request is sent successfully.');
			/*************************************************************/ 
		}
		
		$users = User::where('usertype', '0')
					->where('status', 1)
					->where('phone_verify', 1)	
					->get();
	 
		$title = trans('app.deposit');
		return view('admin/userdeposit', compact('title', 'users'));
	}

	/*********************** withdraw management   ***************************** */
	public function userwithdraw(Request $request){
		if ($request->isMethod('post')) {
				$validator =  Validator::make($request->all(), [
					'amount'        =>    'required|numeric',
					'no'            =>    'required'
				]);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator);
				}
				$user = User::where('no', $request->no)->first();
				if(!isset($user)) 
					return Redirect::back()->withErrors(['no'=> trans('app.invalid_user')]);
				
				if(($user->usertype != 0) && ($user->usertype != 1)){
					return Redirect::back()->withErrors(['no'=> trans('app.invalid_user')]); 	
				}

				$balance = Fees::checkbalance($user->id);
				if($balance < $request->amount)
					return Redirect::back()->withErrors(['amount'=> trans('app.low_balance')]);

				$withdraws = Withdraw::where('user_id', $user->id)
										->where('status', 0)
										->get();
				
				foreach($withdraws as $withdraw)
					$withdraw->delete();
				
				if($user->usertype == 0) 
					$fee_data =  Fees::calculatefee($request->amount, 'withrawal', 0);
				else
					$fee_data =  Fees::calculatefee($request->amount, 'withrawal', 1);


				$withdraw  = new Withdraw;
				$withdraw->fee_amount   =  $fee_data['fee'];
				$withdraw->final_amount =  $fee_data['amount'];
				$withdraw->user_id  	=  $user->id;
				$withdraw->no      	 	=  Withdraw::generatevalue();
				$withdraw->amount   	=  $request->amount;
				$withdraw->status       =  0;
				$withdraw->save();
 
				History::addHistory(Auth::user()->id, 4,  2, $withdraw->id);
				return redirect('/admin/withdrawmanagement');
		}
		$title = trans('app.withdrawls');
		return view('admin/withdraw/userwithdraw', compact('title'));
	}
 
	public function adminwithdraw(Request $request){
		if($request->isMethod('post')){
			if(Fees::adminbalance() <= $request->amount){
				return redirect()->back()->withInput()->withErrors(['amount'=> trans('app.insufficient_deposit')]); 	
			}
			$transaction = new Transactions;
			$transaction->operator_id  = Auth::user()->id;
			$transaction->reference_id = 0;
			$transaction->type = 9; 
			$transaction->transtype = 1; //out 

			$transaction->amount 	   =   $request->amount;
			$transaction->fee_amount   =   0;
			$transaction->final_amount =   $request->amount;
			$transaction->no = Transactions::generatevalue();
			$transaction->save();
			Session::flash('success', 'Request is sent successfully.');
			
		}
		$title = trans('app.withdrawl_for_admin');
		return view('admin/withdraw/adminwithdraw', compact('title'));
	}

	public function withdrawmanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
		$page_size = $request->pagesize;
	
		if($request->key !== null){
			$setting['key'] = $request->key; 
			$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'withraw.user_id')
						->where(function ($query) use ($request){
							$query->where('withraw.no',  'like',  '%'. $request->key . '%')
							->orWhere('withraw.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('withraw.status')
						->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			if(Auth::user()->usertype == '2')
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
									->leftJoin('users', 'users.id', '=', 'withraw.user_id')
									->orderBy('withraw.status')
									->paginate($page_size);
			else
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
								->where('withraw.status', '0')
								->leftJoin('users', 'users.id', '=', 'withraw.user_id')
								->orderBy('withraw.status')
								->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($withdraws as $withdraw){
				if($request->{'status_' .    $withdraw->no}){ // checked	
					$withdraw->status    =  1;
					$transaction = 	Transactions::where('type', 2)
							->where('reference_id', $withdraw->id)
							->where('operator_id',  $withdraw->user_id)
							->first();

						if(isset($transaction))
							continue;
							//calculatefee
							$user = User::find($withdraw->user_id);
							if($user->usertype == '0'){
								$balance = Fees::checkbalance($user->id);
								if($withdraw->amount > $balance)
								{
									continue;
								} 	
							}
 
							$transaction = new Transactions;
							$transaction->operator_id  = $withdraw->user_id;
							$transaction->reference_id = $withdraw->id;
							$transaction->type = 2;
							$transaction->transtype = 1; //out 

							$transaction->amount 	   =  $withdraw->amount;
							$transaction->fee_amount   =  $withdraw->fee_amount;
							$transaction->final_amount =  $withdraw->amount;
							$transaction->no = Transactions::generatevalue();
							 
							$transaction->save();
							History::addHistory(Auth::user()->id, 4,  1, $withdraw->id);

							if(isset($user))
								User::sendMessage($user->phone, trans('sms.withdraw_sms', ['no'=> $withdraw->no, 'amount'=> $withdraw->amount]));
						$withdraw->save();
			}
			else{
				if(Auth::user()->usertype == '2'){
					$transaction = 	  Transactions::where('type', 2)
										->where('reference_id', $withdraw->id)
										->where('operator_id',  $withdraw->user_id)
										->first();
					if(isset($transaction)){
						$withdraw->status = 0;
						$withdraw->save();
						$transaction->delete();
						History::addHistory(Auth::user()->id, 4,  0, $withdraw->id);
					}
				}
			   }
			}
		 
		}
		 
			/*
		if($request->isMethod('post')){
			foreach($withdraws as $withdraw){
				if($request->{'status_' .    $withdraw->no} == '0'){
				
					if($withdraw->status == 0){
						$transaction = new Transactions;
						$transaction->operator_id = $withdraw->user_id;
						$transaction->reference_id = $withdraw->id;
						$transaction->type = 2; //pos
						$transaction->transtype = 1; //out 
						$transaction->amount 	   =  $withdraw->amount;
						$transaction->fee_amount   =  $withdraw->fee_amount;
						$transaction->final_amount =  $withdraw->final_amount;
						$transaction->no = Transactions::generatevalue();
						$transaction->status = 0;
						//$transaction->save();
					
						// withdraw
						$transactions_inte = Transactions::where('transactions.status', '2')
														->where('transactions.operator_id', $withdraw->user_id)
														->get();

						foreach($transactions_inte as $transactionitem){
							$transactionitem->status = 0; // pending
							$transactionitem->save();
						}

						$user = User::find($withdraw->user_id);
						if(isset($user))
							User::sendMessage( $user->phone, 'Hi. Your withdrawal is approved.  The withdrawal number is ' . $withdraw->no);
					}
				
					$withdraw->status  =  $request->{'status_' .    $withdraw->no};
					$withdraw->save();
				}
				else{
					echo 'b';
				}
			}
		}
		*/
		 
		$setting['pagesize'] = $page_size;
		$item = Setting::where('name', 'withdraw_limit')->first();
		if(isset($item)) 
			$setting['withdraw_limit'] = $item['value'];
		else
			$setting['withdraw_limit'] = "";
 
		$title = trans('app.operation_manager_withdrawl');
	    return view('admin/withdraw/withdraw', ['withdraws' => $withdraws->appends(Input::except('page')), 'setting' => $setting, 'title'=> $title]);
	}
	
	public function withdrawmanagement_export_pdf(Request $request){
		if($request->key !== null){
			$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'withraw.user_id')
						->where(function ($query) use ($request){
							$query->where('withraw.no',  'like',  '%'. $request->key . '%')
							->orWhere('withraw.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('withraw.status')
						->get();
		}
		else{
			if(Auth::user()->usertype == '2')
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
									->leftJoin('users', 'users.id', '=', 'withraw.user_id')
									->orderBy('withraw.status')
									->get();
			else
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
								->where('withraw.status', '0')
								->leftJoin('users', 'users.id', '=', 'withraw.user_id')
								->orderBy('withraw.status')
								->get();
		}
		
		
		$title = trans('app.operation_manager_withdrawl');
		User::downloadPDF('admin/pdf/withdraw_pdf', compact('withdraws', 'title'));
	}

	public function withdrawmanagement_export(Request $request){
		if($request->key !== null){
			$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'withraw.user_id')
						->where(function ($query) use ($request){
							$query->where('withraw.no',  'like',  '%'. $request->key . '%')
							->orWhere('withraw.amount', 'like','%'. $request->key . '%')
							->orWhere('users.first_name', 'like','%'. $request->key . '%')
							->orWhere('users.last_name', 'like','%'. $request->key . '%')
							->orWhere('users.phone', 'like','%'. $request->key . '%')
							->orWhere('users.name', 'like','%'. $request->key . '%');
						})->orderBy('withraw.status')
						->get();
		}
		else{
			if(Auth::user()->usertype == '2')
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
									->leftJoin('users', 'users.id', '=', 'withraw.user_id')
									->orderBy('withraw.status')
									->get();
			else
				$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
								->where('withraw.status', '0')
								->leftJoin('users', 'users.id', '=', 'withraw.user_id')
								->orderBy('withraw.status')
								->get();
		}
			 			 
		Excel::create('selfstation', function($excel)  use($withdraws)  {
			$excel->sheet('users', function($sheet)  use($withdraws)  {
				$sheet->appendRow(array(
					trans('app.no'), trans('app.seller_name'), trans('app.phone') , trans('app.request_amount'), trans('app.withdrawl_amount'),   trans('app.status')
				));	
				
				foreach($withdraws as $withdraw){
					$row = array();
					$row[] = $withdraw->no;
					if($withdraw->first_name)
						$row[] = $withdraw->first_name . $withdraw->last_name;
					else
						$row[] = $withdraw->name;
					$row[] = $withdraw->phone;
 
					$row[] = $withdraw->amount;
					$row[] = $withdraw->final_amount;
					 
					if($withdraw->status)
						$row[] = trans('app.approved');
					else
						$row[] = trans('app.not_approved');
					
					$sheet->appendRow($row);
				}
			});
		})->download('xls');
	}
	 
	/******************************************** coupon manageemnt  ******************************/
	public function couponsmanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
	
			
		if($request->key !== null){
			$setting['key'] = $request->key;
			$coupons = Coupon::select('coupon.*')
					->where(function ($query) use ($request){
						$query->where('coupon.code', 'like','%'. $request->key . '%')
						->orWhere('coupon.amount', 'like','%'. $request->key . '%')
						->orWhere('coupon.id', 'like','%'. $request->key . '%'); 
					})
				->paginate($page_size);
 
		}
		else{
			$setting['key'] = "";
			$coupons = Coupon::select('coupon.*')
				->paginate($page_size); 
		}
		$setting['pagesize'] = $page_size;
		$title = trans('app.coupons');
		return view('admin/coupons/coupons', ['coupons' => $coupons->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
	public function couponsusages(Request $request, $id){
	 
		$setting = array();  
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;      
	 
		if($request->key !== null){
			$setting['key'] = $request->key;
			$couponhistories = Couponhistory::select('couponhistory.*', 'users.name', 'users.email','users.phone', 'users.no as userno')
											->where('coupon', $id)
						->leftJoin('users', 'users.id', '=', 'couponhistory.user_id')
					->where(function ($query) use ($request){
						$query->where('couponhistory.coupon', 'like','%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
						->orWhere('users.phone', 'like','%'. $request->key . '%')
						->orWhere('users.email', 'like','%'. $request->key . '%'); 
					})
				->paginate($page_size);
 
		}
		else{
			$setting['key'] = "";
			$couponhistories = Couponhistory::select('couponhistory.*', 'users.name', 'users.email', 'users.phone','users.no as userno')
							   ->leftJoin('users', 'users.id', '=', 'couponhistory.user_id')
							   ->where('couponhistory.coupon', $id)
				->paginate($page_size);
		}
		$setting['id'] = $id;
		$setting['pagesize'] = $page_size;
		$title = trans('app.couponhistory');
		return view('admin/coupons/couponusage', ['couponhistories' => $couponhistories->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}
 
	public function couponscreate(Request $request){
		$fuelstations = Fuelstation::all();
		$code = Coupon::generatevalue();  

		if($request->isMethod('post')){
			$this->validate($request, Coupon::rules());  
			$coupon = new Coupon;   
			$coupon->type 			= $request->type;
			
			if($request->limit_date){
				$coupon->limit_date  	= Coupon::convert_time($request->limit_date);
			}
			
			$coupon->limit_users 	=  $request->limit_users;
			$coupon->amount      	=  $request->amount;
			$coupon->code 			=  Coupon::generatevalue();
			$result 				=  $coupon->save();
			return redirect('/admin/coupons');
		}
		$title = trans('app.coupon_create');
		return view('admin/coupons/newcoupon', compact('fuelstations', 'title' ,'code'));
	}
	
	public function couponsupdate(Request $request, $id){
		$coupon =  Coupon::find($id);
		if(!isset($coupon)) return vaiew("errors/404");
		if($request->isMethod('post')){

			$validator =  Validator::make($request->all(), [
				'amount'                 =>    'required|integer',
				'limit_users'            =>    'integer|integer'
			])->validate(); 
			$coupon->type 			= $request->type;
			
			if($coupon->code != $request->code){
				$validator =  Validator::make($request->all(), [
					'code'                   =>    'required|unique:coupon',
				])->validate(); 
				$coupon->code = $request->code;
			}


			if($request->limit_date){
				$coupon->limit_date  	= Coupon::convert_time($request->limit_date);
			}
			
			$coupon->limit_users 	=  $request->limit_users;
			$coupon->amount      	=  $request->amount;
			 
			$result 				=  $coupon->save();
			return redirect('/admin/coupons');
		}
		$title = trans('app.coupon_update');
		return view('admin/coupons/newcoupon', compact('coupon', 'title'));
	}
	public function couponsdelete($id){
		$coupon =  Coupon::find($id);
		$coupon->delete();
		return Redirect::back()->with(['Please choose the card']);
	}
 
	/*****************************  Vouchers ***************************************/
	
	public function vouchermanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
	   
			
		if($request->key !== null){
			$setting['key'] = $request->key;
			$vouchers = Voucher::select('vouchers.*')
					->where(function ($query) use ($request){
						$query->where('vouchers.code', 'like','%'. $request->key . '%')
						->orWhere('vouchers.amount', 'like','%'. $request->key . '%')
						->orWhere('vouchers.id', 'like','%'. $request->key . '%'); 
					})
				->paginate($page_size);
 
		}
		else{
			$setting['key'] = "";
			$vouchers = Voucher::select('vouchers.*')
				->paginate($page_size);
		}
		$setting['pagesize'] = $page_size;
		$title = trans('app.vouchers');
		return view('admin/vouchers/vouchers', ['vouchers' => $vouchers->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	}

	public function voucherscreate(Request $request){
		$code = Voucher::generatevalue();
		if($request->isMethod('post')){
			$this->validate($request, Voucher::rules());
			$voucher = new Voucher;
			if($request->limit_date){
				$voucher->limit_date  	= Voucher::convert_time($request->limit_date);
			}
			$voucher->amount      	=  $request->amount;
			$voucher->limit_users 	=  $request->limit_users;
			$voucher->code 			=  $request->code;
			$result 				=  $voucher->save();

			History::addHistory(Auth::user()->id, 9, 0, $voucher->id);
			
			return redirect('/admin/vouchers');  
		}
		$title = trans('app.voucher_create');
		return view('admin/vouchers/newvoucher', compact('title' ,'code'));
	} 

	public function vouchersdelete($id){
		$voucher =  Voucher::find($id);
		if(isset($voucher))
			return view('errors/404');
		if(Auth::user()->usertype != "2")
			return view('errors/404');
		$voucher->delete();
		return Redirect::back()->with(['']);
	}

	public function vouchersupdate(Request $request, $id){
		$voucher =  Voucher::find($id);
		if(!isset($voucher)) return view("errors/404");
		if($request->isMethod('post')){
			$flag = 0;

			$validator =  Validator::make($request->all(), [
				'amount'                 =>    'required|integer',
			])->validate(); 
			 
			if($voucher->code != $request->code){
				$validator =  Validator::make($request->all(), [
					'code'                   =>    'required|unique:vouchers',
				])->validate();
				$voucher->code = $request->code;
				$flag = 1;
			}

			if($flag ||  ($voucher->limit_date !=  Voucher::convert_time($request->limit_date)) || ($voucher->amount  != $request->amount)){
				History::addHistory(Auth::user()->id, 9, 1, $voucher->id);
			}

			if($voucher->limit_date){
				$voucher->limit_date  	= Voucher::convert_time($request->limit_date);
			}
			$voucher->amount      	=  $request->amount;
			$voucher->limit_users 	=  $request->limit_users;
			$result 				=  $voucher->save();
			return redirect('/admin/vouchers');
		}
		$title = trans('app.voucher_update');
		return view('admin/vouchers/newvoucher', compact('voucher', 'title'));
	}
	
	public function vouchersusages(Request $request, $id){
		
		   $setting = array();
		   $page_size = 10;
		   if($request->pagesize !== null)
			   $page_size = $request->pagesize;
		
		   if($request->key !== null){
			   $setting['key'] = $request->key;
			   $voucherhistories = Voucherhistory::select('voucherhistory.*', 'users.name', 'users.email','users.phone', 'users.no as userno')
			  									  ->where('voucherhistory.code', $id)
						   ->leftJoin('users', 'users.id', '=', 'voucherhistory.user_id')
					   ->where(function ($query) use ($request){
						   $query->where('voucherhistory.code', 'like','%'. $request->key . '%')
									->orWhere('users.name', 'like','%'. $request->key . '%')
									->orWhere('users.first_name', 'like','%'. $request->key . '%')
									->orWhere('users.no', 'like','%'. $request->key . '%')
									->orWhere('voucherhistory.no', 'like','%'. $request->key . '%')
									->orWhere('users.last_name', 'like','%'. $request->key . '%')
									->orWhere('users.phone', 'like','%'. $request->key . '%')
									->orWhere('users.email', 'like','%'. $request->key . '%'); 
					   })
				   ->paginate($page_size);
	
		   }
		   else{
			   $setting['key'] = "";
			   $voucherhistories = Voucherhistory::select('voucherhistory.*', 'users.name', 'users.email', 'users.phone','users.no as userno')
								  ->leftJoin('users', 'users.id', '=', 'voucherhistory.user_id')
								  ->where('voucherhistory.code', $id)
				   ->paginate($page_size);
		   }
		   $setting['id'] = $id;
		   $setting['pagesize'] = $page_size;
		   $title = trans('app.voucherhistory');
		  
		   return view('admin/vouchers/voucherusage', ['voucherhistories' => $voucherhistories->appends(Input::except('page')), 'title' => $title ,'setting' => $setting]);
	   }
	/*****************************  User send the money from the seller POS ***************************************/
	public function acceptfromUserToSeller(Request $request){
		$validator =  Validator::make($request->all(), [
			'vehicle_no'  => 'required', // DEFAULT or SOCIAL values
			'password'    => 'required', // DEFAULT or SOCIAL values
			'amount'      => 'required|integer', // DEFAULT or SOCIAL values,
			'req_id'      => 'required'
		]);
 
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		}
		
		$operation = Operation::where('req_id', $request->req_id)->count();
		if($operation) 
			return response()->json(['error' => 0 ,  'msg' => "success"]);
 
		$user = JWTAuth::parseToken()->authenticate();
		  
		//receiver_id
		$selleremployee =   Selleremployee::where('user_id', $user->id)
										  ->first();
											  
		$fuelstation    =   Fuelstation::find($selleremployee->fuelstation_id);
		
		if($fuelstation->pos_status == 0){
			return response()->json(['error' => 1 ,   'msg' => 'inactive_fuelstation']);
		}

		$owner_id = $selleremployee->seller_id;
		$vehicle = Vehicle::where('no', $request->vehicle_no)->first();
		if(isset($vehicle)){
			  
 
			if($vehicle->status <= 0)
				return response()->json(['error' => 1 ,  'msg' => 'inactive']);

			if (!Hash::check($request->password, $vehicle->password)){
				$vehicle->wrongnum = $vehicle->wrongnum - 1;
				if($vehicle->wrongnum <= 0)
				{
					$vehicle->status = 0;
				}
				$vehicle->save();
				return response()->json(['error' => 1 ,   'msg' => 'password']);
			}
 
			if(Vehicle::actionLimit($vehicle->id, $selleremployee->service, $request->amount)){
				return response()->json(['error' => 1 ,   'msg' => 'limit_over']);  
			}

			$customer = User::find($vehicle->user_id);
			if(!isset($customer)) 
				return response()->json(['error' => 1 ,   'msg' => 'wrong_user' ]); 
			 
			$balance = Fees::checkbalance($vehicle->user_id);
			if($balance < $request->amount)
				return response()->json(['error' => 1 ,  'msg' => 'low_balance', 'balance' => $balance]); 
			
			$operation = new Operation();
			$operation->sender_id    =  $vehicle->user_id;
			$operation->receiver_id  =  $user->id;
			$operation->amount       =  $request->amount;
			$operation->final_amount =  Fuelstation::getfinalamount($request->amount, $selleremployee->fuelstation_id);
			$operation->fuelstation  =  $fuelstation->no;
			$operation->vehicle      =  $vehicle->id;
			$operation->owner_id     =  $owner_id;
			$operation->service_type =  $selleremployee->service;
			$operation->no           =  Operation::generatevalue();
			$operation->req_id       =  $request->req_id;
			$operation->save();
			
			$fee_data =  Fees::calculatefromamount($operation->final_amount, 'pospay');			
			if($fee_data['status'] == 1){
				$transaction = new Transactions;
				$transaction->operator_id = $vehicle->user_id;
				$transaction->reference_id = $operation->id;
				$transaction->type = 0; //in 
				$transaction->transtype = 1; //in 

				$transaction->amount 	   =  $operation->final_amount;
				$transaction->fee_amount   =  $fee_data['fee'];
				$transaction->final_amount =  $fee_data['amount'];
				
				$transaction->no = Transactions::generatevalue();
				$transaction->save();
			}
			/***************************  Check Reward and send to the user */
			$reward = Reward::where('sender_id', $customer->email)->first();
			if(isset($reward)){
				if($reward->status == '0'){
					$transaction = new Transactions;
                    $transaction->operator_id =  $reward->receiver_id;
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
					
					$reward->status = 1;
					$reward->save();
				}
			}

			return response()->json(['error' => 0 ,  'msg' => "success"]);
		}
		else{
			return response()->json(['error' => 1 ,  'msg' => "wrong_value"]);
		}
	}
	
	public function api_pendingoperation(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		$operations = Operation::where('receiver_id', $user->id)
					   ->where('operation.status', 0)
					   ->select('operation.no', 'operation.amount', 'vehicles.name', 'vehicles.type', 'vehicles.model', 'operation.created_at', 'users.name as customername')
					   ->leftJoin('vehicles','vehicles.id' , '=' ,'operation.vehicle')
					   ->leftJoin('users', 'users.id', '=', 'operation.sender_id')
					   ->get();
		return response()->json(['error' => 0 ,  'results' => $operations]);
	}

	public function api_operationhistory(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
		$operations = Operation::where('receiver_id', $user->id)
							    ->where('operation.status', 1)
								->whereDate('operation.created_at', '>=', Carbon::today()->toDateString())
								->select('operation.no', 'operation.amount', 'vehicles.name', 'vehicles.type', 'vehicles.model', 'operation.created_at', 'users.name as customername')
								->leftJoin('vehicles','vehicles.id' , '=' ,'operation.vehicle')
								->leftJoin('users', 'users.id', '=', 'operation.sender_id')
								->get();
		
		return response()->json(['error' => 0 ,  'results' => $operations]);
	}
	
	public function api_confirmpayment(Request $request){
		$validator =  Validator::make($request->all(), [
			'operation_no' => 'required', // DEFAULT or SOCIAL values
			'amount' => 'required|integer', // DEFAULT or SOCIAL values
			'password'    => 'required', // DEFAULT or SOCIAL values
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		}

		$user = JWTAuth::parseToken()->authenticate();
		$operation = Operation::where('no', $request->operation_no)
								->where('receiver_id', $user->id)
								->where('status', 0)
								->first();
		if(!isset($operation))
			return response()->json(['error' => 1 ,  'msg' => 'invalid_operation']);
		
		
		$vehicle = Vehicle::find($operation->vehicle);
		if(!isset($operation))
			return response()->json(['error' => 1 ,  'msg' => 'invalid_operation']);
		
		if($vehicle->status <= 0)
			return response()->json(['error' => 1 ,  'msg' => 'inactive']);
		
		if (!Hash::check($request->password, $vehicle->password)){
			$vehicle->wrongnum = $vehicle->wrongnum - 1;
			if($vehicle->wrongnum <= 0)
			{
				$vehicle->status = 0;
			}
			$vehicle->save();
			return response()->json(['error' => 1 ,   'msg' => 'password']);
		}
			
		if(($request->amount < 0) || ($request->amount > $operation->amount))
			return response()->json(['error' => 1 ,  'msg' => 'invalid_operation']);
		
		$operation->amount = $request->amount;
		$fuelstation = Fuelstation::where('no', $operation->fuelstation)->first();

		$operation->final_amount =  Fuelstation::getfinalamount($request->amount, $fuelstation->id);
		$operation->status = 1;
		$operation->save();

		$fee_data =  Fees::calculatefee($operation->final_amount, 'posrev', 1, $operation->owner_id);

	 
		//add the balance
	    $transaction = new Transactions;
		$transaction->operator_id =  $operation->owner_id;
		$transaction->reference_id = $operation->id;
		$transaction->type = 4;
		$transaction->amount =  $operation->final_amount;
		$transaction->fee_amount   =  $fee_data['fee'];
		$transaction->final_amount =  $fee_data['amount'];
		$transaction->transtype = 0; //in 
		$transaction->no = Transactions::generatevalue();
		$transaction->save();

		Subfeemanagement::collectingFee($operation->owner_id);
		// refund the money
		$fee_data =  Fees::calculatefromamount($request->amount, 'pospay');
		$transaction1 =  Transactions::where('reference_id', $operation->id)
		 							->where('operator_id', $operation->sender_id)
		 						    ->where('type', '0')
								   ->first();
		$transaction1->amount 	   =  $request->amount;
		$transaction1->fee_amount   =  $fee_data['fee'];
		$transaction1->final_amount =  $fee_data['amount'];
		$transaction1->save();
        
		return response()->json(['error' => 0 ,  'results' => 'success']);
	}
}