<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Fuelstation extends Model
{
    //
	protected $table = "fuelstation";
	
	public static function rules()
    {
        return [
            'name'            =>    'required',
            'city'            =>    'required',
           // 'country'         =>    'required|integer',
            'state'           =>    'required|integer',
            'lat'        	  =>    'required',
            'lng'            =>    'required',
        ];
    }
	
	static public function generatevalue(){
		    $digits = 10;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Fuelstation::where('no', $result)->count() == 0)
					break;
			}
			return $result;
	}

	static function getfinalamount($amount, $fuelstation_id){

	
		$coupon = Fuelstation::where('id', $fuelstation_id)
								->where('sale_status', '1')
								->first();
					
		if(!isset($coupon)) return $amount; 
		//date_default_timezone_set("Asia/Riyadh");   // date("Y-m-d")

		$now = Carbon::now(new \DateTimeZone('Asia/Riyadh'));
	   
		if($coupon->startdate)
		{
			$after = new Carbon( $coupon ->startdate);
 
			if($now->diffInMinutes($after, false) > 0){
				return $amount;
			}
		}
 
		if($coupon->enddate)
		{
			$after = new Carbon( $coupon ->enddate);
			if($now->diffInMinutes($after, false) < 0){
				return $amount;
			}
		}

		 

		if ($coupon->sale_type == '1'){ // percent
			$amount = $amount - $amount * $coupon->sale_amount / 100;
			$amount = round($amount, 2);
		}else{ //fixed
			if($coupon->sale_amount > $amount) return $amount;
			$amount -= $coupon->sale_amount;
		}
		return $amount;
	}
		
}
