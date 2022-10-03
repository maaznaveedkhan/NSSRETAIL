<?php

namespace App\Http\Controllers;

use App\Models\BillDetail;
use App\Models\Stock;
use App\Models\StockQuantity;
use Illuminate\Http\Request;

class BillDetailController extends Controller
{
    //
    public function bill_detail(Request $request){
        // return $request;
        $b = $request->business_id;
        // $amount = BillDetail::where('bill_id',$request->bill_id)->first();
        
        $bill_detail = new BillDetail();
        $bill_detail->bill_id = $request->bill_id;
        $bill_detail->business_id = $b;
        $bill_detail->item_name = $request->item_id;
        $stock = Stock::where('id', $bill_detail->item_name)->latest('created_at')->first();
        $item = StockQuantity::findOrFail($stock->id);
        $item = StockQuantity::where('item_id',$item->id)->orderby('id', 'DESC')->first();
        $balance = $item->balance;
        $bill_detail->rate = $request->rate;
        $bill_detail->quantity = $request->quantity;

        if(!empty($balance)){
            $total_balance = $balance - $bill_detail->quantity;
        }
        $item->balance = $total_balance;
        $bill_detail->amount = $bill_detail->quantity * $bill_detail->rate;
        // return $bill_detail;
        // return $item;
        $item->save();
        $bill_detail->save();
        return redirect()->back()->with('success','Item has been added in bill'); 

    }
}
