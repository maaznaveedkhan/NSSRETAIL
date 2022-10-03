<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CashController extends Controller
{
    ////

    public function cash_book($id){
        $b = $id;
        $cashes = Cash::where('business_id', $b)->get();
        $customers = Customer::where('business_id', $b)->get();
        $suppliers = Supplier::where('business_id', $b)->get();
        return view('frontend.cashbook',compact('cashes','b','customers','suppliers'));
    }

    public function add_entry(Request $request){

        $entry = new Cash();
        $entry->business_id = $request->business_id;
        $entry->party = $request->party;
        $entry->date = $request->date;
        // return $request;
        $entry->save();

        return redirect()->back()->with('success','Entry has been created!');
    }

    public function cash_in(Request $request){

        $adds = DB::table('cash_details')->select('*')->where('cash_id', '=', $request->cash_id)->orderby('id', 'DESC')->get();

        $balance_total = DB::table('cash_details')->select('*')->where('cash_id', '=', $request->cash_id)->orderby('id', 'DESC')->first();

        $cash_out_total = $cash_in_total = 0;
        foreach($adds as $add){
            $cash_out_total += $add->cash_out;
            $cash_in_total += $add->cash_in;
        }

        if($balance_total != null){
            if($cash_in_total > $cash_out_total){
                $total = $balance_total->balance + $request->cash_in;
            }else{

                $total = $balance_total->balance - $request->cash_in;
            }

            $data_array = array(
                'cash_id'=> $request->cash_id,
                'detail'=>$request->detail,
                'cash_in'=>$request->cash_in,
                'party' =>$request->party,
                'date'=>$request->date,
                'balance' => abs($total),
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            );

            $result = DB::table('cash_details')->insert($data_array);

        }else{
           $data_array = array(
            'cash_id'=> $request->cash_id,
            'detail'=>$request->detail,
            'cash_in'=>$request->cash_in,
            'party' =>$request->party,
            'date'=>$request->date,
            'balance' => $request->cash_in,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        );

            $result = DB::table('cash_details')->insert($data_array);

        }

        return redirect()->back()->with('success','Data Entered!');
    }

    public function cash_out(Request $request){

        $adds = DB::table('cash_details')->select('*')->where('cash_id', '=', $request->cash_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('cash_details')->select('*')->where('cash_id', '=', $request->cash_id)->orderby('id', 'DESC')->first();

        $cash_out_total = $cash_in_total = 0;
        foreach($adds as $add){
            $cash_out_total += $add->cash_out;
            $cash_in_total += $add->cash_in;
        }

        if($balance_total != null){

            if($cash_in_total < $cash_out_total){
                $total = $balance_total->balance + $request->cash_out;
            }else{

                $total = $balance_total->balance - $request->cash_out;
            }


            $data_array = array(
                'cash_id'=> $request->cash_id,
                'detail'=>$request->detail,
                'cash_out'=>$request->cash_out,
                'party' =>$request->party,
                'date'=>$request->date,
                'balance' => abs($total),
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            );

            $result = DB::table('cash_details')->insert($data_array);

        }else{
           $data_array = array(
            'cash_id'=> $request->cash_id,
            'detail'=>$request->detail,
            'cash_out'=>$request->cash_out,
            'party' =>$request->party,
            'date'=>$request->date,
            'bill_no'=>$request->bill_no,
            'balance' => $request->cash_out,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        );

            $result = DB::table('cash_details')->insert($data_array);

        }

        return redirect()->back()->with('success','Data Entered!');
    }

    public function allCash(Request $request){
        $all_businesses = Business::all();
        $b = $request->business_id;
        $cashes = Cash::where('business_id', $b)->get();
        return view('layout.all_cash',compact('cashes','b','all_businesses'));
    }

    public function addCash(Request $request){

        $b = $request->business_id;

        $data = new Cash();
        $data->business_id = $b;
        $data->name = $request->name;
        $data->detail = $request->detail;
        $data->cash_in = $request->cash_in;
        $data->cash_out = $request->cash_out;
        $data->date = $request->date;
// dd($request);
        $data->save();

        return Redirect::back();
    }
}
