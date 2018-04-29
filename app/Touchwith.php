<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Touchwith extends Model
{
    //
	protected $table = "touchwith";
	public static function rules()
    {
        return [
            'name'      => 'required|min:2|max:255',
            'email'   	=> 'required|min:6|email|max:255',
			'subject'   => 'required|min:2|max:20',
			'message'   => 'required'
        ];
    }
	
	static public function generatevalue(){
		$digits = 10;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++){
				$result .= mt_rand(0, 9);
			}
			if( Touchwith::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
}
