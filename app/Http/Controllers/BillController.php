<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class BillController extends Controller
{
    //
    public function create_bill(Request $request){

        $b = $request->business_id;
        $bill = new Bill();
        $bill->business_id = $b;
        $bill->amount = $request->amount;
        $bill->detail = $request->detail;
        $bill->date = $request->date;
        $bill->payment_type = $request->method;
        // return $bill;
        $bill->save();

        return redirect()->back()->with('success','bill is created!');
    }
}
