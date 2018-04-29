<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PDF;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','no' ,'email', 'password', 'phone', 'usertype', 'license', 'status'
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

        $number = '966' . $number;

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

    public static function downloadPDF($view, $data){
        
        PDF::SetTitle($data['title']);
        
        PDF::AddPage('L', 'A4');
        if(\Lang::getLocale() == "sa"){
            PDF::SetFont('aealarabiya');
            $lg = Array();
            $lg['a_meta_charset'] = 'UTF-8';
            $lg['a_meta_dir'] = 'rtl';
            $lg['a_meta_language'] = 'fa';
            $lg['w_page'] = 'page';
            PDF::setLanguageArray($lg);
        }
      
       // PDF::setRTL(false)
		PDF::WriteHTML(view($view, $data), true, 0, true, 0);
		PDF::Output($data['title'] . '.pdf');

    }
    
    
}
