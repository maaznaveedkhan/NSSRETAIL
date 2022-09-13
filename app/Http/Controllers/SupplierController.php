<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Business;
use App\Models\Supplier;
use App\Models\Customer;

use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    public function AllSuppliers($id){
        $b = $id;
        $customer = Business::where('id', '=',$id)->latest()->first();
        $supplier = Supplier::where('business_id', '=', $id)->latest()->first();
        // dd($supplier);        
        $all_suppliers = Supplier::where('business_id', '=', $id)->get();        
        return view('layout/all_suppliers', compact('customer', 'b', 'all_suppliers', 'supplier'));            

    }

    public function AddSupplier(Request $request){
        
        $id = $request->business_id;
        $data = new Supplier;
        $data->business_id = $id;
        $data->name = $request->name_supplier;
        $data->phone_number = $request->phone_number;        
        $data->save();     
        
        return Redirect::back();
    }

    public function SupplierPage(Request $request, $id){
        $b  = $request->business_id;
        $customer = Business::where('id', '=', $request->business_id)->latest()->first();
        $supplier = Supplier::where('id', '=', $id)->latest()->first();
        $all_suppliers = Supplier::where('business_id', '=', $request->business_id)->get();
        $payment = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', $supplier->id)->get();

        $details = DB::table('suppliers')
                ->join('bussinesses_suppliers', 'suppliers.id', '=', 'bussinesses_suppliers.supplier_id')
                ->get();

        // dd($details);
        if(sizeof($payment) != 0 || sizeof($details) != 0 ){
            return view('layout/all_suppliers', compact('customer', 'b', 'all_suppliers', 'supplier', 'payment', 'details'));
        }else{
            return view('layout/all_suppliers', compact('customer', 'b', 'all_suppliers', 'supplier'));
        }

    }

    public function Purchase(Request $request){
        $adds = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->orderby('id', 'DESC')->first();

        $given_amount_total = $got_amount_total = 0;
        foreach($adds as $add){
            $given_amount_total += $add->purchase;
            $got_amount_total += $add->payment;
        }


        if($balance_total != null){
            
            if($got_amount_total < $given_amount_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            
            $data_array = array(
                'supplier_id'=> $request->supplier_id,
                'detail'=>$request->detail,
                'purchase'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
            );

            $result = DB::table('bussinesses_suppliers')->insert($data_array);

        }else{
           $data_array = array(
            'supplier_id'=> $request->supplier_id,
            'detail'=>$request->detail,
            'purchase'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
        );

            $result = DB::table('bussinesses_suppliers')->insert($data_array);

        }

        return Redirect::back();

    }

    public function Payment(Request $request){

        $adds = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->orderby('id', 'DESC')->get();
        
        $balance_total = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->orderby('id', 'DESC')->first();
        
        $given_amount_total = $got_amount_total = 0;
        foreach($adds as $add){
            $given_amount_total += $add->purchase;
            $got_amount_total += $add->payment;
        }

        if($balance_total != null){
            if($got_amount_total > $given_amount_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }
            
            $data_array = array(
                'supplier_id'=> $request->supplier_id,
                'detail'=>$request->detail,
                'payment'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
            );

            $result = DB::table('bussinesses_suppliers')->insert($data_array);

        }else{
           $data_array = array(
            'supplier_id'=> $request->supplier_id,
            'detail'=>$request->detail,
            'payment'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
        );

            $result = DB::table('bussinesses_suppliers')->insert($data_array);

        }

        return Redirect::back();

    }

    public function UpdatePayment(Request $request){
        $adds = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->where('id', '!=', $request->id)->orderby('id', 'DESC')->get();

        $total_given_amount = $total_got_amount = $total_balance_amount = 0;
        
        foreach($adds as $add){
            $total_given_amount += $add->purchase;
            $total_got_amount += $add->payment;
            $total_balance_amount += $add->balance;
        }
        
        $balance_total = DB::table('bussinesses_suppliers')->select('*')->where('id', '=', $request->id)->orderby('id', 'DESC')->first();

        if($balance_total->purchase != 0){
            if(sizeof($adds) == 0){
                $data_array = array(
                    'supplier_id'=> $request->supplier_id,
                    'detail'=>$request->detail,
                    'purchase'=>$request->amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($total_given_amount+$request->amount),
                );  
            }else{
                $data_array = array(
                    'supplier_id'=> $request->supplier_id,
                    'detail'=>$request->detail,
                    'purchase'=>$request->amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($total_given_amount+$request->amount),
                );
            }        

            DB::table('bussinesses_suppliers')->where('id', $request->id)->update($data_array);


            $all_records = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->get();

            $sum_amount = $got_sum = $given_sum = 0;
            foreach($all_records as $record){
                $sum_amount += $record->balance;
                $got_sum += $record->payment;
                $given_sum += $record->purchase;

                $record_array = array(
                    'supplier_id'=> $record->supplier_id,
                    'detail'=>$record->detail,
                    'purchase'=>$record->purchase,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($given_sum-$got_sum),
                );                


                DB::table('bussinesses_suppliers')->where('id', $record->id)->update($record_array);            
            }
        }
        else{
            $query = DB::table('bussinesses_suppliers')->select('*')->where('id', $request->id)->orderby('id', 'DESC')->first();

            
            $data_array = array(
                'supplier_id'=> $request->supplier_id,
                'detail'=>$request->detail,
                'payment'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($query->balance),
            );


            DB::table('bussinesses_suppliers')->where('id', $request->id)->update($data_array);

            $all_records = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', '=', $request->supplier_id)->get();


            $sum_amount = $got_sum = $given_sum = 0;

            foreach($all_records as $record){
                $sum_amount += $record->balance;
                $got_sum += $record->payment;
                $given_sum += $record->purchase;

                $record_array = array(
                    'supplier_id'=> $record->supplier_id,
                    'detail'=>$record->detail,
                    'purchase'=>$record->purchase,
                    'payment'=>$record->payment,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($given_sum-$got_sum),
                );               

                DB::table('bussinesses_suppliers')->where('id', $record->id)->update($record_array);            
            }


        }

        return Redirect::back();
    }

    public function DeletePayment(Request $request){
        $delete = DB::table('bussinesses_suppliers')->where('id', $request->id)->delete();
        $all_records = DB::table('bussinesses_suppliers')->select('*')->where('supplier_id', $request->supplier_id)->get();

        $sum_amount = $got_sum = $given_sum = 0;

        foreach($all_records as $record){
            $sum_amount += $record->balance;
            $got_sum += $record->payment;
            $given_sum += $record->purchase;

            $record_array = array(
                'supplier_id'=> $record->supplier_id,
                'detail'=>$record->detail,
                'purchase'=>$record->purchase,
                'payment'=>$record->payment,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($given_sum-$got_sum),
            );               

            DB::table('bussinesses_suppliers')->where('id', $record->id)->update($record_array);            
        }

        return Redirect::back();
    }
}
