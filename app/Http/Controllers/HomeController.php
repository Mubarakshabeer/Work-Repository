<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){
        
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard');

        // echo 'welcome dashboard'.$admin->name. '<a href="'.route('admin.logout').'">Loogout</a>' ;

    }

    public function logout(){
        $admin = Auth::guard('admin')->logout();
				return redirect()->route('admin.login');

    }
}
