<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        if (Auth::user()->role == 'user') {
            return redirect()->route('all_business');
        } else {
            return redirect()->route('admin_dashboard');
        }
        
    }

    public function user_dashboard(){
        return view('dashboard.userdashboard');
    }
    public function admin_dashboard(){
        return 'You are not admin!';
    }
}
