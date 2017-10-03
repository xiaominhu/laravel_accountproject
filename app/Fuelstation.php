<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
		    $digits = 20;
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

	
	
	
}
