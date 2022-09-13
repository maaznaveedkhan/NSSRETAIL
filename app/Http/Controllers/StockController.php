<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
    //
    public function index($id){

        $stocks = Stock::where('business_id', $id)->get();
        $stock_details = DB::table('businesses_stocks')->get();

        return view('layout.all_stock',compact('stocks','stock_details'));
    }

    public function add_stock(Request $request,$id){
        $id = $request->business_id;
        $stock = new Stock();
        $stock->business_id = $id;
        $stock->item_name = $request->item_name;
        $stock->item_unit = $request->item_unit;
        $stock->sale_rate = $request->sale_rate;
        $stock->purchase_rate = $request->purchase_rate;
        $stock->save();
        
        // $id =$stock->id; 
        // $name =$stock->item_name; 
        // $unit =$stock->item_unit; 
        // $sale_rate = $stock->sale_rate;
        // $purchase_rate = $stock->purchase_rate;

        // $data_array = array(
        //     'item_id'=> $id,
        //     'item_name'=> $name,
        //     'item_unit'=> $unit,
        //     'sale_rate'=> $sale_rate,
        //     'purchase_rate'=> $purchase_rate,
        //     'in'=>$request->in,
        //     'out'=>$request->out,
        //     'date'=>$request->date,
        //     'balance'=>($request->in - $request->out),
        //     'party'=>$request->party,
        //     'bill'=>$request->bill,
        //     'amount'=>$request->amount,
        // );
    
        // $result = DB::table('businesses_stocks')->insert($data_array);

        
        return Redirect::back();
    }

    public function add_stockdetail(Request $request){
        $stock_detail = DB::table('bussinesses_stocks')->select('*')->where('id', '=', $request->id)->orderby('id', 'DESC')->first();

        $data_array = array(
            'in'=>$request->in,
            'out'=>$request->out,
            'date'=>$request->date,
            'balance'=>($request->in - $request->out),
            'party'=>$request->party,
            'bill'=>$request->bill,
            'amount'=>$request->amount,
        );

        $result = DB::table('businesses_stocks')->insert($data_array);

        return Redirect::back();
    }

    public function stock_page($id){
        $id = $id;
        $stocks = Stock::all();

        $stock_details = DB::table('businesses_stocks')->select('*')->where('item_id', '=',$id )->get();
        return view('layout.stock_detail', compact('id','stocks','stock_details'));
    }
// Quantity Purchase Function
    public function qty_in(Request $request, $id){
        $stocks = Stock::find($id);
        $id =$stocks->id; 
        $item_name =$stocks->item_name; 
        $item_unit =$stocks->item_unit; 
        $purchase_rate =$stocks->purchase_rate; 
        $adds = DB::table('businesses_stocks')->select('*')->where('item_id', '=', $id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('businesses_stocks')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->first();

        $out = $in = 0;
        foreach($adds as $add){
            $out += $add->out;
            $in += $add->in;
        }
        if($balance_total != null){
            
            if($in < $out){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            

            $data_array = array(
                'item_id'=>$id,
                'item_name'=>$item_name,
                'item_unit'=>$item_unit,
                'purchase_rate'=>$purchase_rate,
                'detail'=>$request->detail,
                'in'=>$request->in,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'party'=>$request->bill,
                'amount'=>($request->out * $request->sale_rate),
                'balance' => abs($total),
            );

            $result = DB::table('businesses_stocks')->insert($data_array);

        }else{
           $data_array = array(
            'detail'=>$request->detail,
            'out'=>$request->out,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'party'=>$request->bill,
            'amount'=>($request->out * $request->sale_rate),
            'balance' => $request->balance,
        );

            $result = DB::table('businesses_stocks')->insert($data_array);

        }

        return Redirect::back();

    }
// Quantity Sold Function
    public function qty_out(Request $request, $id){
        $stocks = Stock::find($id);
        $id =$stocks->id; 
        $item_name =$stocks->item_name; 
        $item_unit =$stocks->item_unit; 
        $sale_rate =$stocks->sale_rate; 
        $adds = DB::table('businesses_stocks')->select('*')->where('item_id', '=', $id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('businesses_stocks')->select('*')->where('item_id', '=', $request->item_id)->orderby('id', 'DESC')->first();

        $out = $in = 0;
        foreach($adds as $add){
            $out += $add->out;
            $in += $add->in;
        }
        if($balance_total != null){
            
            if($in < $out){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            

            $data_array = array(
                'item_id'=>$id,
                'item_name'=>$item_name,
                'item_unit'=>$item_unit,
                'sale_rate'=>$sale_rate,
                'detail'=>$request->detail,
                'out'=>$request->out,
                'out'=>$request->out,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'party'=>$request->bill,
                'amount'=>($request->out * $request->sale_rate),
                'balance' => abs($total),
            );

            $result = DB::table('businesses_stocks')->insert($data_array);

        }else{
           $data_array = array(
            'detail'=>$request->detail,
            'out'=>$request->out,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'party'=>$request->bill,
            'amount'=>($request->out * $request->sale_rate),
            'balance' => $request->balance,
        );

            $result = DB::table('businesses_stocks')->insert($data_array);

        }

        return Redirect::back();

    }
}

    
