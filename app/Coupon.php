<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
	protected $table = 'coupon';
	
	public static function rules()
    {
        return [
            'amount'                 =>    'required|integer',
            'limit_users'            =>    'integer|integer'
        ];
    }
	
	static public function generatevalue(){
		    $digits = 17;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Coupon::where('code', $result)->count() == 0)
					break;
			}
			return $result;
	}
	
	static function convert_time($str){
		$time_array = explode(' ', $str);
		$day_array =  explode('/', $time_array[0]);
		$return_val = $day_array[2] . '/' .$day_array[0] . '/' . $day_array[1]. ' ' . 	$time_array[1];
		return $return_val;
	}
	
}
