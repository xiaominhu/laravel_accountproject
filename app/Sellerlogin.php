<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sellerlogin extends Model
{
    //
	protected $table = "sellerlogin";
	
	static public function generatevalue(){
		    $digits = 6;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Sellerlogin::where('verification_code', $result)->count() == 0)
					break;
			}
			return $result;
	}
	
	static public function generaterequestcode(){
		$digits = 40;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			if( Sellerlogin::where('request_id', $result)->count() == 0)
				break;
		}
		return $result;
	}
}
