<?php

namespace App\Http\Controllers;

use App\Models\BillBook;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\CashBook;
use App\Models\Customer;
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
        $cash = CashBook::select('date')->distinct()->get();
        if($customer != null){
            return view('layout.business_page', compact('customer', 'all_customers', 'b', 'payment', 'details','suppliers','bills','cash'));
        }else{
            return view('layout.all_customers', compact('b'));
        }
    }

}
