<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','no' ,'email', 'password', 'phone', 'usertype', 'license'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static function sendMessage($number, $message){
        $url = 'https://www.sms.gateway.sa/api/sendsms.php?' . http_build_query(
            [
              'username' => 'thelargest',
              'password' => '065382212',
              'numbers'  =>  $number,
              'sender'   => 'selfstation',
              'message'  =>  $message
            ]
        );
		
        $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
             
        if($response == '100') 
            return 1;
        else return 0;
    }
    
    
}
