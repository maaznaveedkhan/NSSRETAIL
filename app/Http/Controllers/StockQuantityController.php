<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockQuantityController extends Controller
{
    //
    public function qty_in(Request $request){

       

        $stock_quantity = new StockQuantity();
        $stock_quantity->item_id = $request->item_id;
        $stock_quantity->business_id = $request->business_id;
        $stock_quantity->qty_in = $request->qty_in;
        $stock_quantity->purchase_rate = $request->rate;
        $stock_quantity->amount = $request->amount;
        $stock_quantity->detail = $request->detail;
        $stock_quantity->date = $request->date;
        $stock_quantity->bill_no = $request->bill_no;
        $stock_quantity->party = $request->party;
        // return $stock_quantity;
        $stock_quantity->save();

        return redirect()->back()->with('success','Data Entered!');
    }

    public function qty_out(Request $request){

        $stock_quantity = new StockQuantity();
        $stock_quantity->item_id = $request->item_id;
        $stock_quantity->business_id = $request->business_id;
        $stock_quantity->qty_out = $request->qty_out;
        $stock_quantity->sale_rate = $request->rate;
        $stock_quantity->amount = $request->amount;
        $stock_quantity->detail = $request->detail;
        $stock_quantity->date = $request->date;
        $stock_quantity->bill_no = $request->bill_no;
        $stock_quantity->party = $request->party;
        // return $stock_quantity;
        $stock_quantity->save();

        return redirect()->back()->with('success','Data Entered!');
    }

}
