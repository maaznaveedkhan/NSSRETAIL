<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockQuantity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockQuantityController extends Controller
{
    //
    public function qty_in(Request $request){
        
        $adds = DB::table('stock_quantities')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->get();
        
        $balance_total = DB::table('stock_quantities')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->first();
        
        $qty_out_total = $qty_in_total = 0;
        foreach($adds as $add){
            $qty_out_total += $add->qty_out;
            $qty_in_total += $add->qty_in;
        }
        
        if($balance_total != null){
            if($qty_in_total > $qty_out_total){
                $total = $balance_total->balance + $request->qty_in;
            }else{

                $total = $balance_total->balance - $request->qty_in;
            }
            
            $data_array = array(
                'item_id'=> $request->item_id,
                'detail'=>$request->detail,
                'qty_in'=>$request->qty_in,
                'purchase_rate'=>$request->rate,
                'party' =>$request->party,
                'amount'=>$request->qty_in * $request->rate,
                'date'=>$request->date,
                'bill_no'=>$request->bill_no,
                'balance' => abs($total),
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            );

            $result = DB::table('stock_quantities')->insert($data_array);

        }else{
           $data_array = array(
            'item_id'=> $request->item_id,
            'detail'=>$request->detail,
            'qty_in'=>$request->qty_in,
            'purchase_rate'=>$request->rate,
            'party' =>$request->party,
            'amount'=>$request->qty_in * $request->rate,
            'date'=>$request->date,
            'bill_no'=>$request->bill_no,
            'balance' => $request->qty_in,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        );

            $result = DB::table('stock_quantities')->insert($data_array);

        }

        return redirect()->back()->withInput(['tab' => 'item'. $request->item_id]);
    }

    public function qty_out(Request $request){

        $adds = DB::table('stock_quantities')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('stock_quantities')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->first();

        $qty_out_total = $qty_in_total = 0;
        foreach($adds as $add){
            $qty_out_total += $add->qty_out;
            $qty_in_total += $add->qty_in;
        }

        if($balance_total != null){
            
            if($qty_in_total < $qty_out_total){
                $total = $balance_total->balance + $request->qty_out;
            }else{

                $total = $balance_total->balance - $request->qty_out;
            }    
            

            $data_array = array(
                'item_id'=> $request->item_id,
                'detail'=>$request->detail,
                'qty_out'=>$request->qty_out,
                'sale_rate'=>$request->rate,
                'amount'=>$request->amount,
                'party' =>$request->party,
                'date'=>$request->date,
                'bill_no'=>$request->bill_no,
                'balance' => abs($total),
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            );

            $result = DB::table('stock_quantities')->insert($data_array);

        }else{
           $data_array = array(
            'item_id'=> $request->item_id,
            'detail'=>$request->detail,
            'qty_out'=>$request->qty_out,
            'sale_rate'=>$request->rate,
            'amount'=>$request->amount,
            'party' =>$request->party,
            'date'=>$request->date,
            'bill_no'=>$request->bill_no,
            'balance' => $request->qty_out,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        );

            $result = DB::table('stock_quantities')->insert($data_array);

        }

        return redirect()->back()->withInput(['tab' => 'item'. $request->item_id]);
    }

}
