<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sellercoupon extends Model
{
    //
	protected $table = "sellercoupon";
	
	public static function rules()
    {
        return [
            'type'           =>    'required|integer',
            'startdate'      =>    'required|date',
            'enddate'        =>    'date',
            'amount'        =>     'required|numeric',
            'type'          =>     'required|integer',
			'code'          =>     'required|unique:sellercoupon'   
        ];
    }
	static public function generatevalue(){
		    $digits = 20;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Sellercoupon::where('code', $result)->count() == 0)
					break;
			}
			return $result;
	}
	
}
