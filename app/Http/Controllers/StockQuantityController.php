<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockQuantityController extends Controller
{
    //
    public function qyt_out(Request $request){

        $adds = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->first();

        $given_amount_total = $got_amount_total = 0;
        foreach($adds as $add){
            $given_amount_total += $add->given_amount;
            $got_amount_total += $add->got_amount;
        }


        if($balance_total != null){
            
            if($got_amount_total < $given_amount_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            

            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'given_amount'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
            );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }else{
           $data_array = array(
            'customer_id'=> $request->customer_id,
            'detail'=>$request->detail,
            'given_amount'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
        );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }

        return Redirect::back();

    }
}
