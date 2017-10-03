<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
	protected $table = 'reward';
	
	static public function generatevalue(){
		$digits = 30;
		while(1){
			$result = '';
			for($i = 0; $i < $digits; $i++){
				$result .= mt_rand(0, 9);
			}
			if( Reward::where('no', $result)->count() == 0)
				break;
		}
		return $result;
	}
}
