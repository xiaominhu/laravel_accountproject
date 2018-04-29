<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
	protected $table = "history";
	static public function generatevalue(){
		$digits = 10;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			
			if( History::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
	/****************************************** */
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
	9:  redeem broucher 0: create, 1: update
	*/
	/*******************************************/
	static public function addHistory($user_id, $type, $action, $reference_id){
		$history = new History;
		$history->user_id 		= $user_id;
		$history->opeartiontype = $type;
		$history->action = $action;
		$history->reference_id = $reference_id;
		$history->no            = History::generatevalue();
		$history->save();
	}
}
