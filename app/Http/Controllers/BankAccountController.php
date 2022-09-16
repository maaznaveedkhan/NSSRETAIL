<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{


    public function add_bank_ac(Request $request){

        $bank_ac = new BankAccount();
        if ($request->hasFile('cheque_img')) {
            $file = $request->file('cheque_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/cheque_images', $filename);
            $bank_ac->cheque_img = $filename;
        }
        $bank_ac->date = $request->date;
        $bank_ac->account = $request->account;
        $bank_ac->account_holder_id = $request->account_holder_id;
        $bank_ac->account_holder_name = $request->account_holder_name;
        $bank_ac->account_holder_phone = $request->account_holder_phone;
        $bank_ac->account_holder_bank = $request->account_holder_bank;
        $bank_ac->cheque_no = $request->cheque_no;
        $bank_ac->account_holder_id = $request->account_holder_id;

        $bank_ac->save();

        return redirect()->back()->with('success','Bank Account has been added!');
    }
}
