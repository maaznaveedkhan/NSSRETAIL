<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Cash;
use App\Models\CashBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CashBookController extends Controller
{
    //

    public function cash_book(Request $request){

        $all_businesses = Business::all();
        $b = $request->business_id;
        $period = now()->subMonths(12)->monthsUntil(now());

        $data = [];
        foreach ($period as $date)
        {
        $data[] = [
            'month' => $date->shortMonthName,
            'year' => $date->year,
        ];
        }
        dd($data);
        $cash = CashBook::where('business_id',$b)->select('date')->distinct()->get();
        return view('frontend.cashbook',compact('cash','b','all_businesses'));
    }

    public function cash_in(Request $request){
        $b = $request->business_id;
        $cash_in = new CashBook();
        $cash_in->business_id = $b;
        $cash_in->amount = $request->amount;
        $cash_in->detail = $request->detail;
        $cash_in->cash_in = $cash_in->amount;
        $cash_in->date = $request->date;
        $cash_in->bill_no = $request->bill_no;
        $cash_in->party = $request->party;
        // dd($cash_in);
        $cash_in->save();

        return redirect()->back()->with('success','Entry has been created!');
    }

    public function cash_out(Request $request){
        $b = $request->business_id;
        $cash_out = new CashBook();
        $cash_out->business_id = $b;
        $cash_out->amount = $request->amount;
        $cash_out->detail = $request->detail;
        $cash_out->cash_out = $cash_out->amount;
        $cash_out->date = $request->date;
        $cash_out->bill_no = $request->bill_no;
        $cash_out->party = $request->party;
        // dd($cash_out);
        $cash_out->save();
        return redirect()->back()->with('success','Entry has been created!');
    }
}
