<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Operation;
use App\User;
use Mail;
use App\Mail\Notification;
use Carbon\Carbon;
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
			'createvehicle_plate'     =>    'required | min:7 |  max:7 | unique:vehicles,plate',
            'createvehicle_password' =>    'required|integer|digits:4',
            // 'createvehicle_coutry'   =>    'required|integer',
			'picture'                => 'image|mimes:jpeg,bmp,png',
        ];
    }
	
	static public function generatevalue(){
		    $digits = 10;
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

	// 1: stop, 0: go on
	static function actionLimit($vehicle_id, $service_type, $amount){
		
		$vehicle = Vehicle::find($vehicle_id);
	
		if(!isset($vehicle)) 
			return 0;
		 
		// calucalte period
		$limit_day = Carbon::today();
		$limit_day->subDays($vehicle->not_times);
		 
		switch($service_type){
			case 1:
			    if($vehicle->not_amount == 0) return 0;
				$oprations_sum = Operation::where('created_at', '>', $limit_day)
										  ->where('service_type', 1)
										  ->where('vehicle', $vehicle_id)
										  ->sum('amount');
				if(($oprations_sum + $amount) <= $vehicle->not_amount) return 0;
				break;
			case 2:
				if($vehicle->not_oil == 0) return 0;
				$oprations_sum = Operation::where('created_at', '>', $limit_day)
										  ->where('service_type', 2)
										  ->where('vehicle', $vehicle_id)
										  ->count();
				if( ($oprations_sum + $amount) <= $vehicle->not_oil) return 0;
				break;
			case 3:
 
				if($vehicle->not_wash == 0) return 0;
				$oprations_sum = Operation::where('created_at', '>', $limit_day)
										  ->where('service_type', 3)
										  ->where('vehicle', $vehicle_id)
										  ->count();
				
				if(($oprations_sum + $amount) <= $vehicle->not_wash) return 0;
				break;
		}
		
 



		$user  = User::find($vehicle->user_id);

		if($vehicle->not_type !=  1){// email
			Mail::to($user->email)->send(new Notification($vehicle->name . '  is limited to the budget'));
		}
		
		if($vehicle->not_type !=  2){
			User::sendMessage( $user->phone , $vehicle->name . '  is limited to the budget');
		}

	 
		if($vehicle->not_status == 1) return 1;
		else  return 0;
	}
 
}
