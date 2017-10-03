<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
	protected $table = 'vehicles';
	
	public static function rules()
    {
        return[
            'createvehicle_name'     =>    'required',
            'createvehicle_type'     =>    'required',
            'createvehicle_model'    =>    'required',
            'createvehicle_fuel'     =>    'required',
            'createvehicle_state'    =>    'required|integer',
            'createvehicle_city'     =>    'required',
            'createvehicle_password' =>    'required',
            // 'createvehicle_coutry'   =>    'required|integer',
			'picture'                => 'image|mimes:jpeg,bmp,png',
        ];
    }
	
	static public function generatevalue(){
		    $digits = 30;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Vehicle::where('no', $result)->count() == 0)
					break;
			}
			
			return $result;
	}
}
