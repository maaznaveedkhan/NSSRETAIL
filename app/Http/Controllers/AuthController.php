<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function user(Request $request){
        $user = new User();
        $user = $request->phone;
        $user->save();

        return redirect('all_business')->with('success','You have logged in!');
    }

    public function update(){
        $user = User::where('phone', request('phone'))->first();
 
        if ($user !== null) {
            $user->update(['phone' => request('phone')]);
        } else {
            $user = User::create([
              'phone' => request('phone'),
            ]);
        }

        return redirect('all_business')->with('success','You have logged in!');
    }
}