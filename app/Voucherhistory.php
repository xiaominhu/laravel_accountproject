<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucherhistory extends Model
{
    //
	protected $table = 'voucherhistory';
	static public function generatevalue(){
		$digits = 10;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			
			if( Voucherhistory::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
}
