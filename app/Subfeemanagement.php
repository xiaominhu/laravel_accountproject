<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Fees;
use App\Subscriptionfee;
use App\Transactions;

class Subfeemanagement extends Model
{
    //
	protected $table = 'subfeemanagement';
	static public function generatevalue(){
		    $digits = 10;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				if( Subfeemanagement::where('no', $result)->count() == 0)
					break;
			}
			return $result;
	}
	
	static public function collectingFee($user_id){
		$fee = Subfeemanagement::getFeeByuserid($user_id);
		if($fee  == 0) return;	
		//Transactions
		$subfee = Subfeemanagement::where('user_id', $user_id)->first();
		if(!isset($subfee)){
			$balance = Fees::checkbalance($user_id);
			$subfee = new Subfeemanagement;
			$subfee->period = date("m-d");
			$subfee-> no    = Subfeemanagement::generatevalue();
			$subfee->user_id = $user_id;
			/*
			if($balance > $fee) 
				$subfee->amount = $fee;
			else
			*/
			$subfee->amount = $fee;
			$subfee->save();
		}
		else{
			if($subfee->period != date("m-d")) return;	
		}
		$transaction = Transactions::whereYear('created_at', '=', date('Y'))
						->where('operator_id', $user_id)
						->where('type', 5)
						->first();
		if(isset($transaction)) return;
				
		$transaction = new Transactions;
		$transaction->operator_id = $user_id;
		$transaction->reference_id = $subfee->id;
		$transaction->type = 5; //subscriptionfee
		$transaction->transtype = 1; //subscriptionfee
		$transaction->amount       =  $fee;
		$transaction->final_amount =  $fee;
		$transaction->no = Transactions::generatevalue();
		$transaction->save();
	}
	
	static public function getFeeByuserid($user_id){
		$user = User::find($user_id);
		if(!isset($user)){
			echo "Fatal error.  Cannot find this user";
			exit;
		}
		$subscriptionfee = Subscriptionfee::where('name', $user_id)->first();
		if($user->usertype == '0') //user
		{				
			if(!isset($subscriptionfee)){
				$subscriptionfee = Subscriptionfee::where('usertype', '0')
											   ->where('name', '0')
											   ->first();
			}
			$vehicles = Vehicle::where('user_id', $user_id)->count();
			
			if($subscriptionfee->freeamount <= $vehicles) return 0;
			else return $subscriptionfee->amount;
		}
		
		if($user->usertype == '1') //seller
		{
			if(!isset($subscriptionfee)){
				$subscriptionfee = Subscriptionfee::where('usertype', '1')
											   ->where('name', '0')
											   ->first();
			} 
			return $subscriptionfee->amount;
		}
		return 0;
	} 
	
}
