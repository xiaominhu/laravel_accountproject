<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Fees;
use App\User;
use App\Operation;
use Carbon\Carbon;
use App\Transactions;
use App\Setting;
use App\Withdraw;
use App\Subfeemanagement;
use App\Voucher;

class CronController extends Controller
{
    //
    public function pending(){
        $operations = Operation::where('operation.status', 0)->get();
        $now = Carbon::now();
       // echo $after->toDateTimeString();
        foreach($operations as $operation){
            $after = new Carbon( $operation ->created_at);
            if($now->diffInMinutes($after) < 30) continue;
            $operation->status = 1;
            $operation->save();
            
            $fee_data =  Fees::calculatefee($operation->amount, 'posrev', 1, $operation->owner_id);
            $transaction = new Transactions;
            $transaction->operator_id  =  $operation->owner_id;
            $transaction->reference_id = $operation->id;
            $transaction->type         = 4;
            $transaction->amount       =  $operation->amount;
            $transaction->fee_amount   =  $fee_data['fee'];
            $transaction->final_amount =  $fee_data['amount'];
            $transaction->transtype    = 0; //in 
            $transaction->no = Transactions::generatevalue();
            $transaction->save();
            Subfeemanagement::collectingFee($operation->owner_id);
        }
        //return response()->json(['error' => 0 ,  'results' => $operations]);
    }
    public function changeExpireStatus(){
        // voucher
        $vouchers = Voucher::whereDate('limit_date', '<', Carbon::now())->get();
        foreach($vouchers as $voucher){
            $voucher->status = 0;
            $voucher->save();
        }
    }

    public function withdraw(){
        $setting = Setting::where('name', 'withdraw_limit')->first();
        $limittime = new Carbon(date("Y-m-d") . $setting->value . ':00');
        $now = Carbon::now();

        
       if(($limittime->diffInMinutes($now, false) > 10) || ($limittime->diffInMinutes($now, false) < -5)){
           echo "Not payment time";
           return;
        } 
   
        $users = User::where('usertype', 1)->where('phone_verify', 1)->get();
        
        foreach($users as $user){
            $balance =  Fees::checkbalance($user->id);
            
            if($balance <= 0) continue;

            $withdraws = Withdraw::where('user_id', $user->id)
                        ->where('status', 0)
                        ->get();
            foreach($withdraws as $withdraw)
                $withdraw->delete();
            
            $withdraw  = new Withdraw;
               //$withdraw->user_id 
            $fee_data =  Fees::calculatefee($balance, 'withrawal', 1);

            $withdraw->fee_amount   =  $fee_data['fee'];
            $withdraw->final_amount =  $fee_data['amount'];
            $withdraw->user_id      =  $user->id;
            $withdraw->no           =  Withdraw::generatevalue();
            $withdraw->amount       =  $balance;
            $withdraw->save();
        }
        //$q->whereDate('created_at', '=', Carbon::today()->toDateString());
    }

    public function collectingsubscription(){
        //$limittime =  date("m-d");
        //echo $limittime;
        $subfeemanagements = Subfeemanagement::where('status', 1)->get();

        foreach($subfeemanagements as $subfeemanagement){
            $user_id = $subfeemanagement->user_id;
            $user = User::find($user_id);
            if(!isset($user)) {
                $subfeemanagement->status = 0;
                continue;
            }
            Subfeemanagement::collectingFee($user_id);
        }
    }    
}
