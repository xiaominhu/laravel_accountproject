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

    public static function calculatefee($amount, $feetype)
    {
        $fee = Fees::where('fee_key', $feetype)->first();
        $result = array();
        if(($fee->percent == 0) && ($fee->fixed == 0)){
            $result['status'] = 1;
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
                $result['status']  = 0;
                $result['amount']  =  $amount - $fee->fixed; // result 
                $result['fee']     =  $fee->fixed; // result 
                $result['fee_type']= 'fixed';
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
                $result['amount']     = $amount * 100 / (100 - $fee->percent);
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
        if($type == "real")
          $total_in   =  Transactions::where('operator_id', $userid)
                                ->where('status', 1)
                                ->where('transtype', 0)
                                ->sum('final_amount');
        else
            $total_in   =  Transactions::where('operator_id', $userid)
            ->whereIn('status', [1,2])
            ->where('transtype', 0)
            ->sum('final_amount');
    
        $total_out   =  Transactions::where('operator_id', $userid)
                                ->where('status', 1)
                                ->where('transtype', 1)
                                ->sum('final_amount');

      
        $current = $total_in - $total_out;
       
        return $current;
    }
}
