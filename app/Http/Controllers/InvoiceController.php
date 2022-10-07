<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Stock;
use App\Models\StockQuantity;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function all_invoices($id){
        $b = $id;
        $invoices = Invoice::where('business_id',$b)->get();
        $stocks = Stock::where('business_id', $id)->get();
        $stock_details = DB::table('businesses_stocks')->get();
        $suppliers = Supplier::where('business_id',$b)->get();
        $customers = Customer::where('business_id',$b)->get();
        // return view('frontend.bill_book',compact('b','bills','stocks','stock_details','suppliers','customers'));
        return view('frontend.invoice',compact('b','invoices','stocks','stock_details','suppliers','customers'));
    }

    public function print_invoice($id){
        $b = Business::find($id);
        $id = Invoice::find($id);
        return view('frontend.print_invoice',compact('id','b' ));
    }

    public function new_invoice($id){
        $b = $id;
        $invoices = Invoice::where('business_id',$b)->get();
        $stocks = Stock::where('business_id', $id)->get();
        $stock_details = DB::table('businesses_stocks')->get();
        $suppliers = Supplier::where('business_id',$b)->get();
        $customers = Customer::where('business_id',$b)->get();
        return view('frontend.create_invoice',compact('b','invoices','stocks','stock_details','suppliers','customers'));
    }
    public function create_invoice(Request $request){

        $b = $request->business_id;
        $invoice = new invoice();
        $invoice->business_id = $b;
        $invoice->invoice_no = $request->invoice_no;
        $invoice->detail = $request->detail;
        $invoice->date = $request->date;
        $invoice->supplier = $request->supplier;
        $invoice->payment_type = $request->method;
        // return $request;
        $invoice->save();

        return redirect()->route('all_invoices',$b)->with('success','Invoice has been created!');
    }

    public function invoice_detail(Request $request){
        // return $request;
        $b = $request->business_id;
        $invoice_detail = new InvoiceDetail();
        $invoice_detail->invoice_id = $request->invoice_id;
        $invoice_detail->business_id = $b;
        $invoice_detail->item_name = $request->item_name;
        $invoice_detail->item_unit = $request->item_unit;
        $invoice_detail->party = $request->party;
        // $stock = Stock::where('id', $invoice_detail->item_name)->latest('created_at')->first();
        // $item = StockQuantity::findOrFail($stock->id);
        // $item = StockQuantity::where('item_id',$item->id)->orderby('id', 'DESC')->first();
        // $balance = $item->balance;
        $invoice_detail->rate = $request->rate;
        $invoice_detail->quantity = $request->quantity;

        // if(!empty($balance)){
        //     $total_balance = $balance - $invoice_detail->quantity;
        // }
        // $item->balance = $total_balance;
        $invoice_detail->amount = $invoice_detail->quantity * $invoice_detail->rate;
        // return $invoice_detail;
        // $item->save();
        $invoice_detail->save();
        return redirect()->back()->withInput(['tab' => 'item'. $invoice_detail->invoice_id]);
       
    }
}
