<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Sellerrole extends Model
{
    //
	protected $table = 'sellerrole';
	
	static public function get_seller_id($user_id){
		$user = User::find($user_id);
		if($user->usertype == '1') return $user_id;
		
		if($user->usertype == '5'){
			$sellerrole = Sellerrole::where('user_id', $user_id)->first();
			if(isset($sellerrole))
				return $sellerrole->master_id;
		}
		return 0;
	}

}
