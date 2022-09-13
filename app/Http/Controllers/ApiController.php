<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class ApiController extends Controller
{
    public function getCustomer(Request $request){
         $customer = Customer::where('business_id',$request->business_id)->get();
         foreach($customer as $customers){

         }
         return $customers;
    }
}
