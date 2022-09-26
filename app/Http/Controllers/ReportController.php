<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Business;

use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use Redirect;

class ReportController extends Controller
{
    public function ViewReport($id){
        $business = Business::where('id', $id)->get();
        $all_customers = Customer::where('business_id', $id)->get();

        $details = DB::table('customers')->join('bussinesses_customers', 'customers.id', '=', 'bussinesses_customers.customer_id')->get();

        $payment = DB::select('SELECT * FROM `bussinesses_customers`, `customers`, `businesses`
            WHERE bussinesses_customers.`customer_id` = customers.`id`
            AND businesses.`id` = customers.`business_id`
            AND businesses.`id` = ?', [$id]);
                    
        return view('layout.view_report', compact('business', 'details', 'all_customers', 'id', 'payment'));
    }
}
