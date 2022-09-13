<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CashController extends Controller
{
    ////
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
