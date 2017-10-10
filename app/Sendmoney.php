<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sendmoney extends Model
{
    //
	protected $table = "sendmoney";
	
	public static function rules()
    {
        return [
            //'reference_id'   =>    'required|exists:users, email',
            'amount'         =>    'required|numeric',
        ];
    }
	static public function generatevalue(){
		$digits = 20;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++) {
				$result .= mt_rand(0, 9);
			}
			
			if(Sendmoney::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
}
