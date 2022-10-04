<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class BillController extends Controller
{
    //
    public function new_bill($id){
        $b = $id;
        $bills = Bill::where('business_id',$b)->get();
        $stocks = Stock::where('business_id', $id)->get();
        $stock_details = DB::table('businesses_stocks')->get();
        $suppliers = Supplier::where('business_id',$b)->get();
        $customers = Customer::where('business_id',$b)->get();
        return view('frontend.create_bill',compact('b','bills','stocks','stock_details','suppliers','customers'));
    }

    public function create_bill(Request $request){

        $b = $request->business_id;
        $bill = new Bill();
        $bill->business_id = $b;
        $bill->bill_no = $request->bill_no;
        $bill->detail = $request->detail;
        $bill->date = $request->date;
        $bill->party = $request->party;
        $bill->payment_type = $request->method;
        // return $request;
        $bill->save();

        return redirect()->route('bill_book',$b)->with('success','Bill has been created!');
    }

    public function delete_bill($id)
    {
        $bill = Bill::find($id);
        $bill->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Bill has been deleted!');
    }

    public function bill_book($id){
        $b = $id;
        $bills = Bill::where('business_id',$b)->get();
        $stocks = Stock::where('business_id', $id)->get();
        $stock_details = DB::table('businesses_stocks')->get();
        $suppliers = Supplier::where('business_id',$b)->get();
        $customers = Customer::where('business_id',$b)->get();
        return view('frontend.bill_book',compact('b','bills','stocks','stock_details','suppliers','customers'));
    }
    // public function create_bill(Request $request){

    //     $b = $request->business_id;
    //     $bill = new Bill();
    //     $bill->business_id = $b;
    //     $bill->amount = $request->amount;
    //     $bill->detail = $request->detail;
    //     $bill->date = $request->date;
    //     $bill->payment_type = $request->method;
    //     // return $bill;
    //     $bill->save();

    //     return redirect()->back()->with('success','bill is created!');
    // }
}
