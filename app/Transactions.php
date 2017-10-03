<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
	protected $table = 'transactions';
	
	
	static public function generatevalue(){
		    $digits = 50;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Transactions::where('no', $result)->count() == 0)
					break;
			}
			
			return $result;
	}
}
