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

class CronController extends Controller
{
    //

    public function pending(){
        $operations = Operation::where('operation.status', 0)->get();
        $now = Carbon::now();
       // echo $after->toDateTimeString();
        foreach($operations as $operation){
            $after = new Carbon( $operation ->created_at);
            if($now->diffInMinutes($after) < 25) continue;
            $operation->status = 1;
            $operation->save();
            
            $fee_data =  Fees::calculatefee($operation->amount, 'posrev');
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

    public function withdraw(){
        $setting = Setting::where('name', 'withdraw_limit')->first();
        $limittime = new Carbon(date("Y-m-d") . $setting->value . ':00');
        $now = Carbon::now();
        if($limittime->diffInMinutes($now, false) < 0){
            $limittime->subDay(1);
        }
 
       // echo $limittime->toDateTimeString();
        $transactions = Transactions::whereIn('transactions.status', [1,2])
                                    ->where('users.usertype', 1)
                                    ->selectRaw('sum(transactions.final_amount) as sum, transactions.operator_id')
                                    ->leftJoin('users', 'users.id', '=', 'transactions.operator_id')
                                    ->whereDate('transactions.created_at', '<=', $limittime->toDateString())
                                    ->groupBy('transactions.operator_id')
                                    ->get();
        
        foreach($transactions as $transaction){
                $withdraw = Withdraw::where('user_id', $transaction->operator_id)
                                    ->where('status', 0)
                                    ->first();
                if(!isset($withdraw)) 
                    $withdraw  = new Withdraw;

                $transactions_inte = Transactions::whereIn('transactions.status', [1,2])
                    ->select('transactions.id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.operator_id')
                    ->whereDate('transactions.created_at', '<=', $limittime->toDateString())
                    ->where('transactions.operator_id', $transaction->operator_id)
                    ->get();

                foreach($transactions_inte as $transactionitem){
                    $internal_transcation = Transactions::find($transactionitem->id);
                    $internal_transcation->status = 2; // pending
                    $internal_transcation->save();
                }

                $fee_data =  Fees::calculatefee($transaction->sum, 'withrawal');
                $withdraw->fee_amount   =  $fee_data['fee'];
                $withdraw->final_amount =  $fee_data['amount'];
                $withdraw->user_id  = $transaction->operator_id;
				$withdraw->no       = Withdraw::generatevalue();
                $withdraw->amount   = $transaction->sum;
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
