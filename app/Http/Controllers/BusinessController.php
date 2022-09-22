<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BillBook;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\CashBook;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    public function AllBusinesses(Request $request){
        $user_id = Auth::id();
        $all_businesses = Business::where('user_id',$user_id)->get();
        return view('layout.all_business', compact('all_businesses'));
    }

    public function NewBusiness(Request $request){
        $data = new Business;
        $data->business_name = $request->business_name;
        $data->user_id = $request->user_id;
        $data->save();
        return Redirect::back();
    }

    public function BusinessPage($id){

        $b = $id;
        $business = Business::where('id',$b)->first();
        $all_customers = Customer::where('business_id', $b)->get();
        if(sizeof($all_customers) == 0 ){
            return view('layout.all_customers', compact('b'));            
        }
        $customer = Customer::where('id', '=',$id)->latest()->first();
        $payment = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $customer->id)->get();
        $suppliers = Supplier::where('business_id',$id)->get();
        $bills = BillBook::where('business_id',$id)->get();
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
            return view('layout.business_page', compact('business','customer', 'all_customers', 'b', 'payment', 'details','suppliers','bills','cash','stock','bank_accounts'));
        }else{
            return view('layout.all_customers', compact('b'));
        }
    }

}
