<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transactions;

class Fees extends Model
{
    //
	protected $table = "fees";
	
	public static function rules()
    {
        return [
            'name'            =>    'required',
            'fee_key'         =>    'required'
        ];
    }

    // $usertype 0: user, 1: seller
    public static function calculatefee($amount, $feetype, $usertype, $specialuser = 0)
    {
        if($usertype == 0) $usertype = 3;
        else               $usertype = 2;
        
         
        $result = array();
        $result['status'] = 1;
        $result['fee']     = 0;
        $result['amount'] = $amount;
       
        $fee = Fees::where('fee_key', $feetype)
                    ->where('specialuser', $specialuser)
                    ->first();
            

        if(!isset($fee))
            $fee = Fees::where('fee_key', $feetype)
                        ->where( function ($query) use ($usertype) {
                            $query->where('type',  '1')
                                ->orWhere('type', $usertype);
                        })
                        ->first();
            
        if(isset($fee)){
            if(($fee->percent == 0) && ($fee->fixed == 0)){
                $result['status'] = 1;
                $result['fee']     = 0;
                $result['amount'] = $amount;
            }elseif( $fee->percent != 0){
                $result['fee']     = $amount * $fee->percent / 100;
                $result['amount']  = $amount - $result['fee'];
                $result['status']  = 1; 
                $result['fee_type']='percent';
            }else{
                if($fee->fixed > $amount){
                    $result['status'] = 0;
                    $result['errors'] = 1; // result 
                }
                else{
                    $result['status']  = 1;
                    $result['amount']  =  $amount - $fee->fixed; // result 
                    $result['fee']     =  $fee->fixed; // result 
                    $result['fee_type']= 'fixed';
                }
            }
        }
        return $result;       
    }

    public static function calculatefromamount($amount, $feetype)
    {
        $result = array();
        $fee = Fees::where('fee_key', $feetype)->first();
        if(isset($fee)){
            if(($fee->percent == 0) && ($fee->fixed == 0)){
                $result['status'] = 1;
                $result['amount'] = $amount;
                $result['fee']   = 0;
            }elseif( $fee->percent != 0){
                $result['amount']     = $amount * (100+ +  $fee->percent)  / 100;
                $result['fee']        = $result['amount'] - $amount;
                $result['status']     = 1;
                $result['fee_type']   ='percent';
            }else{
                if($fee->fixed > $amount){
                    $result['status'] = 0;
                    $result['errors'] = 1; // result 
                }
                else{
                    $result['status']  = 1;
                    $result['amount']  =  $amount + $fee->fixed; // result 
                    $result['fee']     =  $fee->fixed; // result 
                    $result['fee_type']= 'fixed';
                }
            }
        }
        else{
            $result['status'] = 0; // 
            $result['errors'] = 0; // wrong type
        }

        return $result;
    }


    public static function checkbalance($userid, $type = "real"){
        $valance = 0;
        $total_in   =  Transactions::where('operator_id', $userid)
                    ->where('transtype', 0)
                    ->sum('final_amount');
    
        $total_out   =  Transactions::where('operator_id', $userid)
                        //        ->where('status', 1)
                                ->where('transtype', 1)
                                ->sum('final_amount');
        
        $current = $total_in - $total_out;
        $current = round( $current, 2);
        return $current;
    }

    public  static  function adminbalance(){
        $total_balance =    Transactions::sum('fee_amount') + Transactions::where('type', 5)->sum('final_amount') -  Transactions::whereIn('type', [3, 9, 8])->sum('final_amount');
        return $total_balance;
    }
}
