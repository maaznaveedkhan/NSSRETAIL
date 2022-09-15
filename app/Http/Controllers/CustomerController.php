<?php

namespace App\Http\Controllers;

use App\Models\BillBook;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Business;
use App\Models\CashBook;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use Illuminate\Support\Facades\Redirect;


class CustomerController extends Controller
{
    public function AddCustomer(Request $request){
        
        $id = $request->business_id;

        $data = new Customer;
        $data->business_id = $id;
        $data->name = $request->name_customer;
        $data->phone_number = $request->phone_number;        
        $data->save();     
        
        return Redirect::back();
    }

    public function CustomerPage(Request $request, $id){

        $b = $request->business_id;
        $all_customers = Customer::where('business_id', $request->business_id)->get();
        $customer = Customer::where('id', $id)->latest()->first();
        $payment = DB::table('bussinesses_customers')->select('*')->where('customer_id', $customer->id)->get();
        $suppliers = Supplier::where('business_id',$id)->get();
        $bills = BillBook::where('business_id',$id)->get();
        $cash = CashBook::where('business_id',$id)->select('date')->distinct()->get();
        $details = DB::table('customers')
                ->join('bussinesses_customers', 'customers.id', '=', 'bussinesses_customers.customer_id')
                ->get();                
        return view('layout.business_page', compact('customer', 'all_customers', 'b', 'payment', 'details','bills','cash','suppliers'));
    }

    public function GivenAmount(Request $request){

        $adds = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->get();
        $balance_total = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->first();

        $given_amount_total = $got_amount_total = 0;
        foreach($adds as $add){
            $given_amount_total += $add->given_amount;
            $got_amount_total += $add->got_amount;
        }


        if($balance_total != null){
            
            if($got_amount_total < $given_amount_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }    
            

            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'given_amount'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
            );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }else{
           $data_array = array(
            'customer_id'=> $request->customer_id,
            'detail'=>$request->detail,
            'given_amount'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
        );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }

        return Redirect::back();

    }

    public function GotAmount(Request $request){

        $adds = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->get();
        
        $balance_total = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->orderby('id', 'DESC')->first();
        
        $given_amount_total = $got_amount_total = 0;
        foreach($adds as $add){
            $given_amount_total += $add->given_amount;
            $got_amount_total += $add->got_amount;
        }

        if($balance_total != null){
            if($got_amount_total > $given_amount_total){
                $total = $balance_total->balance + $request->amount;
            }else{

                $total = $balance_total->balance - $request->amount;
            }
            
            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'got_amount'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($total),
            );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }else{
           $data_array = array(
            'customer_id'=> $request->customer_id,
            'detail'=>$request->detail,
            'got_amount'=>$request->amount,
            'date'=>$request->date,
            'bill'=>$request->bill,
            'balance' => $request->amount,
        );

            $result = DB::table('bussinesses_customers')->insert($data_array);

        }

        return Redirect::back();

    }

    public function UpdateAmount(Request $request){

        $adds = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->where('id', '!=', $request->id)->orderby('id', 'DESC')->get();


        $total_given_amount = $total_got_amount = $total_balance_amount = 0;
        
        foreach($adds as $add){
            $total_given_amount += $add->given_amount;
            $total_got_amount += $add->got_amount;
            $total_balance_amount += $add->balance;
        }
        
        $balance_total = DB::table('bussinesses_customers')->select('*')->where('id', '=', $request->id)->orderby('id', 'DESC')->first();

        if($balance_total->given_amount != 0){
            if(sizeof($adds) == 0){
                $data_array = array(
                    'customer_id'=> $request->customer_id,
                    'detail'=>$request->detail,
                    'given_amount'=>$request->amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($total_given_amount+$request->amount),
                );  
            }else{
                $data_array = array(
                    'customer_id'=> $request->customer_id,
                    'detail'=>$request->detail,
                    'given_amount'=>$request->amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($total_given_amount+$request->amount),
                );
            }        

            DB::table('bussinesses_customers')->where('id', $request->id)->update($data_array);


            $all_records = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->get();

            $sum_amount = $got_sum = $given_sum = 0;
            foreach($all_records as $record){
                $sum_amount += $record->balance;
                $got_sum += $record->got_amount;
                $given_sum += $record->given_amount;

                $record_array = array(
                    'customer_id'=> $record->customer_id,
                    'detail'=>$record->detail,
                    'given_amount'=>$record->given_amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($given_sum-$got_sum),
                );
               


                DB::table('bussinesses_customers')->where('id', $record->id)->update($record_array);            
            }
        }
        else{
            $query = DB::table('bussinesses_customers')->select('*')->where('id', $request->id)->orderby('id', 'DESC')->first();

            
            $data_array = array(
                'customer_id'=> $request->customer_id,
                'detail'=>$request->detail,
                'got_amount'=>$request->amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($query->balance),
            );

            // dd($data_array);

            DB::table('bussinesses_customers')->where('id', $request->id)->update($data_array);

            $all_records = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->get();


            $sum_amount = $got_sum = $given_sum = 0;

            foreach($all_records as $record){
                $sum_amount += $record->balance;
                $got_sum += $record->got_amount;
                $given_sum += $record->given_amount;

                $record_array = array(
                    'customer_id'=> $record->customer_id,
                    'detail'=>$record->detail,
                    'given_amount'=>$record->given_amount,
                    'got_amount'=>$record->got_amount,
                    'date'=>$request->date,
                    'bill'=>$request->bill,
                    'balance' => abs($given_sum-$got_sum),
                );               

                DB::table('bussinesses_customers')->where('id', $record->id)->update($record_array);            
            }


        }

        return Redirect::back();
    }

    public function DeleteAmount(Request $request){

        $delete = DB::table('bussinesses_customers')->where('id', $request->id)->delete();
        $all_records = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $request->customer_id)->get();

        $sum_amount = $got_sum = $given_sum = 0;

        foreach($all_records as $record){
            $sum_amount += $record->balance;
            $got_sum += $record->got_amount;
            $given_sum += $record->given_amount;

            $record_array = array(
                'customer_id'=> $record->customer_id,
                'detail'=>$record->detail,
                'given_amount'=>$record->given_amount,
                'got_amount'=>$record->got_amount,
                'date'=>$request->date,
                'bill'=>$request->bill,
                'balance' => abs($given_sum-$got_sum),
            );               

            DB::table('bussinesses_customers')->where('id', $record->id)->update($record_array);            
        }

        return Redirect::back();
        
    }



    public function ImportFile(){
        return view('layout/import_file');
    }

    public function File(Request $request){
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('files', $filename);
        $pathes = storage_path('app\files'.'/'.$filename);

        if($filename[0] != 'E'){
            if($path){
               $users = [];

                if (($open = fopen($pathes, "r")) !== FALSE) {

                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                        $users[] = $data;
                    }

                    fclose($open);
                }
                if (count($users)) {

                    $array = array_slice($users,6,count($users)-6, true);
                    $removed_a = array_pop($array);
                    $removed_b = array_pop($array);

                    $sum_givenn = $sum_gotten = 0;

                    /*foreach ($array as $key => $value) {                        

                        $customer[] = [
                            'name' => empty($value[2])?0:$value[2],
                            'business_id' => '2',
                        ];

                        for ($e = 0; $e < count($customer); $e++)
                        {
                          $duplicate = null;
                          for ($ee = $e+1; $ee < count($customer); $ee++)
                          {
                            if (strcmp($customer[$ee]['name'],$customer[$e]['name']) === 0)
                            {
                              $duplicate = $ee;
                              break;
                            }
                          }
                          if (!is_null($duplicate))
                            array_splice($customer,$duplicate);
                        }                        
                    }

                    $customer_table = Customer::insert($customer);*/


                    $unique_idd = uniqid();

                    $arr = [];
                    foreach($array as $key => $value){
                        
                        /*if($value[0] == "Date                       Details"){
                          continue;
                        }*/

                        if($value[0] != "Date                       Details"){

                            $yes = $value[0];
                            $middle = strtotime($yes); 
                            $date = date('Y-m-d', $middle);

                            $got = empty($value[5])?0:$value[5];
                            $gott = trim($got, '"');
                            $gottt = str_replace('$', '', $gott);
                            $gottt = str_replace(',', '', $gott);
                            $gottt = (float)$gottt;

                            $sum_given = empty($value[3])?0:$value[3];
                            $sum_given = trim($sum_given, '"');
                            $sum_given = str_replace('$', '', $sum_given);
                            $sum_given = str_replace(',', '', $sum_given);
                            $sum_given = (float)$sum_given;

                            $sum_givenn += $sum_given;
                            $sum_gotten += $gottt;
                            

                            $arr[] = [
                                'date' => $result = empty($date)?null:$date, 
                                'given_amount' => $sum_given, 
                                // 'customer_name' => $value[2],
                                'got_amount' => $gottt, 
                                'created_at' => date('Y-m-d'),
                                'updated_at' => date('Y-m-d'),
                                'unique_id' => $unique_idd,
                            ];
                        }

                    }

                    dd($arr);

                    foreach($arr as $ar){
                        $insert_data = DB::table('temp_record')->insert($ar);

                    }                    

                    $temp_record_customers = DB::select('SELECT customers.`id`, temp_record.`date`, temp_record.`given_amount`, temp_record.`got_amount`, temp_record.`bill`, temp_record.`detail`,temp_record.`balance`, temp_record.`created_at`, temp_record.`updated_at`
                        FROM customers, temp_record
                        WHERE customers.`name` = temp_record.`customer_name`
                        AND customers.`business_id` = 2
                        AND temp_record.`unique_id` = ?', [$unique_idd]);
                    

                    $given_amount_sum = $got_amount_sum = $total_amount_sum = 0;

                    foreach($temp_record_customers as $temp_record_customer){
                        
                        $given_amount_sum += $temp_record_customer->given_amount;
                        $got_amount_sum += $temp_record_customer->got_amount;

                        $data_array = array(
                            'date' => $temp_record_customer->date,                            
                            'customer_id' => $temp_record_customer->id,
                            'detail' => $temp_record_customer->detail,                            
                            'given_amount' => $temp_record_customer->given_amount,                            
                            'got_amount' => $temp_record_customer->got_amount,                            
                            'bill' => $temp_record_customer->bill,                            
                            'balance' => abs($given_amount_sum-$got_amount_sum),
                            'created_at' => $temp_record_customer->created_at,                            
                            'updated_at' => $temp_record_customer->updated_at,                            
                        );

                        $insert_data = DB::table('bussinesses_customers')->insert($data_array);
                        

                        $all_records = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $temp_record_customer->id)->get();

                        $sum_amount = $got_sum = $given_sum = 0;

                        foreach($all_records as $record){
                            $sum_amount += $record->balance;
                            $got_sum += $record->got_amount;
                            $given_sum += $record->given_amount;

                            $record_array = array(
                                'customer_id'=> $record->customer_id,
                                'detail'=>$record->detail,
                                'given_amount'=>$record->given_amount,
                                'got_amount'=>$record->got_amount,
                                'date'=>$request->date,
                                'bill'=>$request->bill,
                                'balance' => abs($given_sum-$got_sum),
                            );               

                            DB::table('bussinesses_customers')->where('id', $record->id)->update($record_array);            
                        }
                    }                    
                    
                    $delete = DB::table('temp_record')->where('unique_id', $unique_idd)->delete();                
                }

            }
        }
    }

    /*public function File(Request $request){
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('files', $filename);
        $pathes = storage_path('app\files'.'/'.$filename);

        if($filename[0] != 'E'){
            if($path){
               $users = [];

                if (($open = fopen($pathes, "r")) !== FALSE) {

                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                        $users[] = $data;
                    }

                    fclose($open);
                }

                if (count($users)) {

                    $array = array_slice($users,7,count($users)-7, true);
                    $removed_a = array_pop($array);
                    $removed_b = array_pop($array);
                    $removed_c = array_pop($array);
                    $removed_d = array_pop($array);
                    $removed_e = array_pop($array);

                    $sum_givenn = $sum_gotten = 0;

                    foreach ($array as $key => $value) {                        

                        $customer[] = [
                            'name' => empty($value[2])?0:$value[2],
                            'business_id' => '2',
                        ];

                        for ($e = 0; $e < count($customer); $e++)
                        {
                          $duplicate = null;
                          for ($ee = $e+1; $ee < count($customer); $ee++)
                          {
                            if (strcmp($customer[$ee]['name'],$customer[$e]['name']) === 0)
                            {
                              $duplicate = $ee;
                              break;
                            }
                          }
                          if (!is_null($duplicate))
                            array_splice($customer,$duplicate);
                        }                        
                    }

                    $customer_table = Customer::insert($customer);


                    $unique_idd = uniqid();

                    $arr = [];

                    foreach($array as $key => $value){

                        if($value[2]){

                            $yes = $value[0];
                            $middle = strtotime($yes); 
                            $date = date('Y-m-d', $middle);

                            $got = empty($value[4])?0:$value[4];
                            $gott = trim($got, '"');
                            $gottt = str_replace(',', '', $gott);
                            $gottt = (float)$gottt;

                            $sum_given = empty($value[3])?0:$value[3];
                            $sum_given = trim($sum_given, '"');
                            $sum_given = str_replace(',', '', $sum_given);
                            $sum_given = (float)$sum_given;

                            $sum_givenn += $sum_given;
                            $sum_gotten += $gottt;
                            

                            $arr[$value[2]][] = [
                                'date' => $result = empty($date)?null:$date, 
                                'given_amount' => $sum_given, 
                                'customer_name' => $value[2],
                                'got_amount' => $gottt, 
                                'created_at' => date('Y-m-d'),
                                'updated_at' => date('Y-m-d'),
                                'unique_id' => $unique_idd,
                            ];
                        }

                    }
                    foreach($arr as $ar){
                        $insert_data = DB::table('temp_record')->insert($ar);

                    }                    

                    $temp_record_customers = DB::select('SELECT customers.`id`, temp_record.`date`, temp_record.`given_amount`, temp_record.`got_amount`, temp_record.`bill`, temp_record.`detail`,temp_record.`balance`, temp_record.`created_at`, temp_record.`updated_at`
                        FROM customers, temp_record
                        WHERE customers.`name` = temp_record.`customer_name`
                        AND customers.`business_id` = 2
                        AND temp_record.`unique_id` = ?', [$unique_idd]);
                    

                    $given_amount_sum = $got_amount_sum = $total_amount_sum = 0;

                    foreach($temp_record_customers as $temp_record_customer){
                        
                        $given_amount_sum += $temp_record_customer->given_amount;
                        $got_amount_sum += $temp_record_customer->got_amount;

                        $data_array = array(
                            'date' => $temp_record_customer->date,                            
                            'customer_id' => $temp_record_customer->id,
                            'detail' => $temp_record_customer->detail,                            
                            'given_amount' => $temp_record_customer->given_amount,                            
                            'got_amount' => $temp_record_customer->got_amount,                            
                            'bill' => $temp_record_customer->bill,                            
                            'balance' => abs($given_amount_sum-$got_amount_sum),
                            'created_at' => $temp_record_customer->created_at,                            
                            'updated_at' => $temp_record_customer->updated_at,                            
                        );

                        $insert_data = DB::table('bussinesses_customers')->insert($data_array);
                        

                        $all_records = DB::table('bussinesses_customers')->select('*')->where('customer_id', '=', $temp_record_customer->id)->get();

                        $sum_amount = $got_sum = $given_sum = 0;

                        foreach($all_records as $record){
                            $sum_amount += $record->balance;
                            $got_sum += $record->got_amount;
                            $given_sum += $record->given_amount;

                            $record_array = array(
                                'customer_id'=> $record->customer_id,
                                'detail'=>$record->detail,
                                'given_amount'=>$record->given_amount,
                                'got_amount'=>$record->got_amount,
                                'date'=>$request->date,
                                'bill'=>$request->bill,
                                'balance' => abs($given_sum-$got_sum),
                            );               

                            DB::table('bussinesses_customers')->where('id', $record->id)->update($record_array);            
                        }
                    }                    
                    
                    $delete = DB::table('temp_record')->where('unique_id', $unique_idd)->delete();                
                }

            }
        }else{
            
           if($path){
               $users = [];

                if (($open = fopen($pathes, "r")) !== FALSE) {

                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                        $users[] = $data;
                    }

                    fclose($open);
                }

                if(count($users)) {
                    $array = array_slice($users,1,count($users)-1, true);                    
                    
                    $sum_given = $sum_got = 0;

                    foreach ($array as $key => $value) {                        

                        $customer[] = [
                            'name' => empty($value[0])?0:$value[0],
                            'business_id' => '2',
                        ];

                        for ($e = 0; $e < count($customer); $e++)
                        {
                          $duplicate = null;
                          for ($ee = $e+1; $ee < count($customer); $ee++)
                          {
                            if (strcmp($customer[$ee]['name'],$customer[$e]['name']) === 0)
                            {
                              $duplicate = $ee;
                              break;
                            }
                          }
                          if (!is_null($duplicate))
                            array_splice($customer,$duplicate);
                        }                        
                    }

                    dd($customer);

                    $customer_table = Customer::insert($customer);


                    foreach ($array as $key => $value) {
                        
                        $date = empty($value[0])?null:$value[0];
                        $date = substr($date, -8);

                        $sum_given += $value[2];
                        $sum_got += $value[3];



                        if(!($key == 0)){
                            $arr[] = [
                                'date' => $date, 
                                'customer_id' => 1, 
                                'given_amount' => empty($value[2])?0:$value[2], 
                                'got_amount' => empty($value[3])?0:$value[3], 
                                'balance' => abs($sum_given-$sum_got), 
                            ];
                        
                        }
                    }

                    dd($arr);

                    $d = DB::table('bussinesses_customers')->insert($arr);
                }
            }

        }
    }*/




    public function exportCsv(Request $request)
    {
       $fileName = 'tasks.csv';
       $tasks = DB::select('SELECT * FROM `bussinesses_customers`,`businesses`,`customers`
                WHERE `businesses`.`id` = `customers`.`business_id`
                AND`bussinesses_customers`.`customer_id` = `customers`.`id`
                AND `businesses`.`id` = 2
            ');


        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Date', 'Name', 'Details', 'Debit(+)', 'Credit(-)');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
                foreach ($tasks as $task) {
                    $row['date']  = $task->date;
                    $row['name']    = $task->name;
                    $row['detail']    = $task->detail;
                    $row['given_amount']  = $task->given_amount;
                    $row['got_amount']  = $task->got_amount;

                    fputcsv($file, array($row['date'], $row['name'], $row['detail'], $row['given_amount'], $row['got_amount']));
                }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
