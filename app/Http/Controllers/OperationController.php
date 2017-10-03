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
use Auth, Redirect, DB, Session, Validator, Hash;;
use App\Coupon;
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
	    return view('user/operation/deposits', ['deposits' => $deposits->appends(Input::except('page')), 'setting' => $setting]);
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
			
			
			if ($request->hasFile('picture')){
				$validator =  Validator::make($request->all(), [
						'amount'         =>   'required|integer',
						'picture' 		 => 'image|mimes:jpeg,bmp,png',
				]);
			}else{
					// check first
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
			
			$deposit  = new Deposit;
			
			
			if ($request->hasFile('picture')){
				$deposit->paymentid = 0;
				
				$image=$request->file('picture');
				$imageName=$image->getClientOriginalName();
				$imageName = time() . $imageName;
				$image->move('images/bankdeposit_123',$imageName);
				$deposit->notes = $imageName;
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
				
				$deposit->type     = 0;
				$deposit->user_id  = $user->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->save();
				
				
				
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
			'offset' => 'integer|required', // DEFAULT or SOCIAL values
			'from_date' => 'date', 
			'to_date' => 'date', 
			'to_amount' => 'integer', 
			'from_amount' => 'integer', 
			'type' => 'in:0,1,2,3',
			'orderby' => 'in:amount,type,created_at'
		]);
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		} 
		
		$setting_val = array();
		
		$setting_val['orderby'] = "created_at";
		$setting_val['orderby_direction'] = "desc";
		
		$sql = "";
		if(null !== $request->input('from_date'))
		{
			$setting_val['from_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('from_date'). " 00:00:00"); // 1975-05-21 22:00:00
			$sql .= 'created_at > "' . 	$setting_val['from_date'] .'"';
		}
		
		
		if(null !== $request->input('to_date'))
		{
			$setting_val['to_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to_date'). " 00:00:00");
			
			if($sql != "") $sql  .= " and ";
			$sql .= 'created_at < "' . 	$setting_val['to_date'] .'"';
		}
	
		if(null !== $request->input('from_amount'))
		{
			$setting_val['from_amount'] = $request->input('from_amount');
			
			if($sql != "") $sql  .= " and ";
		    $sql .= ' amount >= "' . 	$setting_val['from_amount']  . '"';
		}	
		
		if(null !== $request->input('to_amount'))
		{
			$setting_val['to_amount'] = $request->input('to_amount');
			if($sql != "") $sql  .= " and ";
			$sql .= ' amount <= "' . 	$setting_val['to_amount']  . '"';
		}	
		
		
		if(null !== $request->input('orderby'))
		{
			$setting_val['orderby'] = $request->input('orderby');
			$setting_val['orderby_direction'] = "desc";
		}	
		 
		$user = JWTAuth::parseToken()->authenticate();
		if(null !== $request->input('vehicle')){
			if($sql != "")
				$first  =   Operation::where('sender_id', $user->id)
							->select('amount','no' , 'created_at', DB::raw("'0' as type"),  DB::raw("'' as detail"))
							->whereRaw($sql);
			else
				$first  =   Operation::where('sender_id', $user->id)
							->select('amount','no' , 'created_at', DB::raw("'0' as type"),  DB::raw("'' as detail") );
							
			$first = 	$first->select('operation.amount', 'operation.no', 'operation.created_at', DB::raw("'0' as type"),  DB::raw("'' as detail"))
						 ->leftJoin('vehicles', 'vehicles.id', '=', 'operation.vehicle')
						 ->whereRaw('vehicles.name like "%'. $request->input('vehicle')  . '%"');
				
			$flag = 1;
				 
				if((null !== $request->input('type') )){
					if($request->input('type') != '0')
						$flag = 0;
				}
				if($flag)
					$deposits = $first
						->orderBy($setting_val['orderby'], $setting_val['orderby_direction'])
						->offset($request->offset)
						->limit(5)
						->get();
					else
						$deposits = array();
		}
		else{
			
			if($sql != "")
				$first  =   Operation::where('sender_id', $user->id)
							->select('amount','no' , 'created_at', DB::raw("'0' as type"),  DB::raw("'' as detail"))
							->whereRaw($sql);
							
			else
				$first  =   Operation::where('sender_id', $user->id)
							->select('amount','no' , 'created_at', DB::raw("'0' as type"),  DB::raw("'' as detail") );
			
			
			if($sql != "")
				$second =   Deposit::where('user_id', $user->id)
								->select('amount','no', 'created_at', DB::raw("'1' as type"),  DB::raw("type as detail"))
								->whereRaw($sql);
			else
				$second =   Deposit::where('user_id', $user->id)
								->select('amount','no', 'created_at', DB::raw("'1' as type"),  DB::raw("type as detail"));
								
								
			if($sql != "")
				$third  =   Withdraw::where('user_id', $user->id)
								->select('amount','no', 'created_at', DB::raw("'2' as type"),  DB::raw("'' as detail"))
								->whereRaw($sql);
			else
				$third  =   Withdraw::where('user_id', $user->id)
								->select('amount','no', 'created_at', DB::raw("'2' as type"),  DB::raw("'' as detail"));
						
				if(null !== $request->input('type')){
						switch($request->input('type')){
							case '0':
								$deposits = $first
									->orderBy('created_at', 'desc')
									->offset($request->offset)
									->limit(5)
									->get();
								break;
							case '1':
								$deposits = $second
									->orderBy('created_at', 'desc')
									->offset($request->offset)
									->limit(5)
									->get();
								break;
							case '2':
								$deposits = $third
									->orderBy('created_at', 'desc')
									->offset($request->offset)
									->limit(5)
									->get();
								break;
						}
					}
				else{
					$deposits = $first
							->union($second)
							->union($third)
							->orderBy('created_at', 'desc')
							->offset($request->offset)
							->limit(5)
							->get();
				}
		}
		foreach($deposits as $item){
			switch($item->type){
				case '0': // operation
					$vehicle = Vehicle::where('user_id', $user->id)
									  ->select('vehicles.no', 'vehicles.name')
									  ->where('operation.no', $item->no)
									  ->leftJoin('operation', 'operation.vehicle', '=', 'vehicles.id')
									  ->first();
					$item->detail = $vehicle;
					break;
				case '1': // deposit
					break;
				case '2': 
					break;
			}
		}
		return response()->json(['error' => 0 ,  'result' => $deposits]);
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
				$this->validate($request, Bank::rules());
				
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
				$deposit  = new Deposit;
				$deposit->type     = 0;
				$deposit->user_id  = Auth::user()->id;
				$deposit->no       = Deposit::generatevalue();
				$deposit->amount   = $request->amount;
				$deposit->paymentid = $bank->id;
				$deposit->save();

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

			/*
			$transaction = new Transactions;
			$transaction->operator_id = Auth::user()->id;
			$transaction->reference_id = $deposit->id;
			$transaction->type = 1;
			$transaction->amount =  $request->amount;
			$transaction->no = Transactions::generatevalue();
			$transaction->save();
			*/
			
			return redirect('/user/operations/deposits');
		}
		return view('user/operation/deposit', compact('setting'));
	}
	
	public function depositmanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
		$page_size = $request->pagesize;

		if($request->key !== null){
			$setting['key'] = $request->key;
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'deposit.user_id')
						->where('deposit.no',  'like',  '%'. $request->key . '%')
						->orWhere('deposit.amount', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
						 
						->orWhere('users.name', 'like','%'. $request->key . '%')
					    ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						 ->leftJoin('users', 'users.id', '=', 'deposit.user_id')
					     ->paginate($page_size);
		}
		
		if($request->isMethod('post')){
			foreach($deposits as $deposit){
				if($request->{'status_' .    $deposit->no}){
					$deposit->status    =  $request->{'status_' .    $deposit->no};
					if($deposit->status){
						//calculatefee
						$fee_data =  Fees::calculatefee($deposit->amount, 'deposit');
						 
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
						}
						else
							return Redirect::back()->withErrors(['Low value']);
						// Transactions
						
						
					}
					$deposit->save();
				}
				
			}
		}
		
		$setting['pagesize'] = $page_size;
	    return view('admin/deposit', ['deposits' => $deposits->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function depositmanagement_export(Request $request){
		$deposits = Deposit::select('deposit.*', 'users.name', 'users.phone')
						 ->leftJoin('users', 'users.id', '=', 'deposit.user_id')
					     ->get(); 
						 
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
	
	public function withdrawmanagement(Request $request){
		
		$page_size = 10;
		if($request->pagesize !== null)
		$page_size = $request->pagesize;
		
		if($request->key !== null){
			$setting['key'] = $request->key; 
			
			$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						->leftJoin('users', 'users.id', '=', 'withraw.user_id')
						->where('withraw.no',  'like',  '%'. $request->key . '%')
						->orWhere('withraw.amount', 'like','%'. $request->key . '%')
						->orWhere('users.first_name', 'like','%'. $request->key . '%')
						->orWhere('users.last_name', 'like','%'. $request->key . '%')
						->orWhere('users.name', 'like','%'. $request->key . '%')
					    ->paginate($page_size);
		}
		else{
			$setting['key'] = "";
			$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						 ->leftJoin('users', 'users.id', '=', 'withraw.user_id')
					     ->paginate($page_size);
		}
			
		
		if($request->isMethod('post')){
			foreach($withdraws as $withdraw){
				if($request->{'status_' .    $withdraw->no}){
					if($withdraw->status == 0){
						
						// withdraw
						$transactions_inte = Transactions::where('transactions.status', '2')
														->where('transactions.operator_id', $withdraw->user_id)
														->get();

						foreach($transactions_inte as $transactionitem){
							$transactionitem->status = 0; // pending
							$transactionitem->save();
						}
						User::sendMessage(Auth::user()->phone, 'Hi. Your withdrawal is approved.  The withdrawal number is ' . $withdraw->no);


					}
					$withdraw->status  =  $request->{'status_' .    $withdraw->no};
					$withdraw->save();
				}
			}
		}
		
		$setting['pagesize'] = $page_size;
		$item = Setting::where('name', 'withdraw_limit')->first();
		if(isset($item)) 
			$setting['withdraw_limit'] = $item['value'];
		else
			$setting['withdraw_limit'] = "";
	    return view('admin/withdraw', ['withdraws' => $withdraws->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function withdrawmanagement_export(Request $request){
		$withdraws = Withdraw::select('withraw.*', 'users.name', 'users.phone')
						 ->leftJoin('users', 'users.id', '=', 'withraw.user_id')
					     ->get();
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
	
	public function couponsmanagement(Request $request){
		$page_size = 10;
		if($request->pagesize !== null)
			$page_size = $request->pagesize;
		$coupons = Coupon::select('coupon.*', 'fuelstation.name')
				   ->leftJoin('fuelstation','fuelstation.id' , '=' ,'coupon.fuelstation_id')
				   ->paginate($page_size);
		$setting['pagesize'] = $page_size;
		return view('admin/coupons/coupons', ['coupons' => $coupons->appends(Input::except('page')), 'setting' => $setting]);
	}
	
	public function couponscreate(Request $request){
		$fuelstations = Fuelstation::all();
		if($request->isMethod('post')){
			$this->validate($request, Coupon::rules());
			$coupon = new Coupon;
			$coupon->fuelstation_id = $request->fuelstation_id;
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
		return view('admin/coupons/newcoupon', compact('fuelstations'));
	}
	
	public function couponsupdate(Request $request, $id){
		$coupon =  Coupon::find($id);
		if(!isset($coupon)) return vaiew("errors/404");
		if($request->isMethod('post')){
			$this->validate($request, Coupon::rules());
			$coupon->fuelstation_id = $request->fuelstation_id;
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
		$fuelstations = Fuelstation::all();
		return view('admin/coupons/newcoupon', compact('fuelstations', 'coupon'));
	}
	public function couponsdelete($id){
		$coupon =  Coupon::find($id);
		$coupon->delete();
		
		return Redirect::back()->with(['Please choose the card']);
	}
	
	
	/*****************************  User send the money from the seller POS ***************************************/
	public function acceptfromUserToSeller(Request $request){

		$validator =  Validator::make($request->all(), [
			'vehicle_no'  => 'required', // DEFAULT or SOCIAL values
			'password'    => 'required', // DEFAULT or SOCIAL values
			'amount'      => 'required|integer', // DEFAULT or SOCIAL values
		]);
		
		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		}
		
		$user = JWTAuth::parseToken()->authenticate();
		
		
		
		//receiver_id
		$selleremployee =   Selleremployee::where('user_id', $user->id)
								  ->first();
		$fuelstation    =   Fuelstation::find($selleremployee->fuelstation_id)->first();
								  
		$owner_id = $selleremployee->seller_id;


		$vehicle = Vehicle::where('no', $request->vehicle_no)->first();
		if(isset($vehicle)){
			$customer = User::find($vehicle->user_id);
			if(!isset($customer)) 
				return response()->json(['error' => 1 ,   'msg' => 'wrong_user' ]); 
			
			
			
			if (!Hash::check($request->password, $vehicle->password))
				return response()->json(['error' => 1 ,   'msg' => 'wrong_password']);
			
		
			
			$balance = Fees::checkbalance($vehicle->user_id);
			if($balance < $request->amount)
				return response()->json(['error' => 1 ,  'msg' => 'low_balance', 'balance' => $balance]); 
			
			$operation = new Operation();
			$operation->sender_id   =  $vehicle->user_id;
			$operation->receiver_id =  $user->id;
			$operation->amount      =  $request->amount;
			$operation->fuelstation =  $fuelstation->no;
			$operation->vehicle     =  $vehicle->id;
			$operation->owner_id     = $owner_id;
			$operation->no          =  Operation::generatevalue();
			$operation->save();

			
			$fee_data =  Fees::calculatefromamount($operation->amount, 'pospay');
			 
			
			if($fee_data['status'] == 1){
				$transaction = new Transactions;
				$transaction->operator_id = $vehicle->user_id;
				$transaction->reference_id = $operation->id;
				$transaction->type = 0; //in 
				$transaction->transtype = 1; //in 
				
				$transaction->amount 	   =  $request->amount;
				$transaction->fee_amount   =  $fee_data['fee'];
				$transaction->final_amount =  $fee_data['amount'];
				
				$transaction->no = Transactions::generatevalue();
				$transaction->save();
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
	
	public function api_confirmpayment(Request $request){
		 
		$validator =  Validator::make($request->all(), [
			'operation_no' => 'required', // DEFAULT or SOCIAL values
			'amount' => 'required|integer', // DEFAULT or SOCIAL values
		]);

		if($validator->fails()){
			$errors = $validator->errors();
			return response()->json(['error' => 1 ,  'msg' => $errors->messages()]);
		}

		$user = JWTAuth::parseToken()->authenticate();
		
		$operation = Operation::where('no', $request->operation_no)
								->where('receiver_id', $user->id)
								->first();
		if(!isset($operation))
			return response()->json(['error' => 1 ,  'msg' => 'invalid_operation']);
		
		if(($request->amount < 0) || ($request->amount > $operation->amount))
			return response()->json(['error' => 1 ,  'msg' => 'invalid_operation']);
		
		$operation->amount = $request->amount;
		$operation->status = 1;
		$operation->save();

		$fee_data =  Fees::calculatefee($operation->amount, 'posrev');
		 
		//add the balance
	    $transaction = new Transactions;
		$transaction->operator_id =  $operation->owner_id;
		$transaction->reference_id = $operation->id;
		$transaction->type = 4;
		$transaction->amount =  $request->amount;
		$transaction->fee_amount   =  $fee_data['fee'];
		$transaction->final_amount =  $fee_data['amount'];
		$transaction->transtype = 0; //in 
		
		$transaction->no = Transactions::generatevalue();
		$transaction->save();

		// refund the money
		$fee_data =  Fees::calculatefromamount($request->amount, 'pospay');
		$transaction =  Transactions::where('reference_id', $operation->id)
		 							->where('operator_id', $operation->sender_id)
									 ->first();
		$transaction->amount 	   =  $request->amount;
		$transaction->fee_amount   =  $fee_data['fee'];
		$transaction->final_amount =  $fee_data['amount'];
		$transaction->save();

		return response()->json(['error' => 0 ,  'results' => 'success']);
	}
}
