<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\Business;
use App\Models\CashBook;
use App\Models\Customer;
use App\Models\MoneyReceiveBook;
use App\Models\Stock;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyReceiveBookController extends Controller
{
    // public function money_receive_book($id){
    //     $b = $id;
    //     // $all_money = MoneyReceiveBook::where('business_id', $b)->get();
    //     $customers = Customer::where('business_id', $b)->get();
    //     $suppliers = Supplier::where('business_id', $b)->get();
    //     return view('frontend.money_receive_book',compact('b','customers','suppliers'));
    // }

    public function money_receive_book($id){
        $b = $id;
        $business = Business::where('id',$b)->first();
        
        $all_customers = Customer::where('business_id', $b)->get();
        if(sizeof($all_customers) == 0 ){
            return view('layout.all_customers', compact('b'));            
        }
        $customer = Customer::where('id', '=',$id)->latest()->first();
        
        $suppliers = Supplier::where('business_id',$id)->get();
        $data = $all_customers->concat($suppliers);
        foreach($data as $key => $item){

        }
        $payment = DB::table('money_receive_books')->select('*')->where('customer_id', '=', $key)->get();
        $bills = Bill::where('business_id',$id)->get();
        $details = DB::table('customers')
                ->join('bussinesses_customers', 'customers.id', '=', 'bussinesses_customers.customer_id')
                ->get();
        $cash = CashBook::where('business_id',$id)->select('date')->distinct()->get();
        $stock = Stock::where('business_id',$id)->get();
        // $items = Stock::with('quantity')->where('business_id',$id)->get();
        //   return  $items = Stock::with('quantity')->where('business_id',$id)->get();
        //   dd($items);
        $bank_accounts = BankAccount::where('business_id',$id)->select('account')->distinct()->get();
        foreach($cash as $item){
            $cash_detail = CashBook::where('date',$item->date)->get();

        }
        if($customer != null){
            return view('frontend.money_receive_book', compact('business','customer', 'all_customers', 'b', 'payment', 'details','suppliers','bills','cash','stock','bank_accounts','data'));
            // return view('layout.business_page', compact('business','customer', 'all_customers', 'b', 'payment', 'details','suppliers','bills','cash','stock','bank_accounts'));
        }else{
            return view('frontend.money_receive_book', compact('b'));
        }
    }

    public function add_party(Request $request){

        $entry = new MoneyReceiveBook();
        $entry->business_id = $request->business_id;
        $entry->party = $request->party;
        $entry->date = $request->date;
        // return $request;
        $entry->save();

        return redirect()->back()->with('success','Entry has been created!');
    }

    public function money_out(Request $request){
        // return $request;
        $adds = DB::table('money_receive_books')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('money_receive_books')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->first();

        $money_out_total = $money_in_total = 0;
        foreach($adds as $add){
            $money_out_total += $add->money_out;
            $money_in_total += $add->money_in;
        }


        if($balance_total != null){
            
            if($money_in_total < $money_out_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            

            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'money_out'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            // return $data_array;
            $result = DB::table('money_receive_books')->insert($data_array);

        }else{
           $data_array = array(
            'customer_id'=> $request->customer_id,
            'detail'=>$request->detail,
            'money_out'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
            
            $result = DB::table('money_receive_books')->insert($data_array);

        }

        return redirect()->back()->withInput(['tab' => 'customer'. $request->customer_id]);
    }

    public function money_in(Request $request){

        $adds = DB::table('money_receive_books')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->get();
        
        $balance_total = DB::table('money_receive_books')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->first();
        
        $money_out_total = $money_in_total = 0;
        foreach($adds as $add){
            $money_out_total += $add->money_out;
            $money_in_total += $add->money_in;
        }

        if($balance_total != null){
            if($money_in_total > $money_out_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }
            
            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'money_in'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            // return $data_array;
            $result = DB::table('money_receive_books')->insert($data_array);

        }else{
           $data_array = array(
            'customer_id'=> $request->customer_id,
            'detail'=>$request->detail,
            'money_in'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

            $result = DB::table('money_receive_books')->insert($data_array);

        }

        return redirect()->back()->withInput(['tab' => 'customer'. $request->customer_id]);

    }
}
