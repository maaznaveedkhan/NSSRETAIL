<?php

namespace App\Http\Controllers;

use App\Models\BillBook;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Bool_;

class BillBookController extends Controller
{
    //
    public function add_bill(Request $request){

        $b = $request->business_id;
        $bill = new BillBook();
        $bill->business_id = $b;
        $bill->amount = $request->amount;
        $bill->detail = $request->detail;
        $bill->date = $request->date;
        $bill->party = $request->party;
        $bill->item = implode(',' , $request->item_name);
        $bill->quantity = implode(',' , $request->item_quantity);
        $bill->rate = implode(',' , $request->item_rate);
        $bill->method = $request->method;
        // return $request;
        $bill->save();

        return redirect()->back()->with('success','Bill has been created!');
    }

    public function edit_bill($id){
        $bill = BillBook::find($id);
        return view('layout.business_page', compact('bill'));
    }
    
    public function update_bill(Request $request,$id){

        $bill = BillBook::find($id);
        $b = $request->business_id;
        $bill = new BillBook();
        $bill->business_id = $b;
        $bill->amount = $request->amount;
        $bill->detail = $request->detail;
        $bill->date = $request->date;
        $bill->party = $request->party;
        $bill->item = $request->item;
        $bill->quantity = $request->quantity;
        $bill->rate = $request->rate;
        $bill->method = $request->method;
        
        $bill->save();

        return redirect()->back()->with('success','Bill has been updated!');
    }

    public function delete_bill($id)
    {
        $bill = BillBook::find($id);
        $bill->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Bill has been deleted!');
    }
}
