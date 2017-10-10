<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    //
	protected $table = 'withraw';
	
	public static function rules()
    {
        return [
            'amount'         =>   'required|integer'
        ];
    }
	
	static public function generatevalue(){
		    $digits = 10;
			while(1){
				$result = '';
				for($i = 0; $i < $digits; $i++) {
					$result .= mt_rand(0, 9);
				}
				
				if( Withdraw::where('no', $result)->count() == 0)
					break;
			}
			
			return $result;
	}
	
}
