<?php

namespace App\Http\Controllers\frontController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetpasswordController extends Controller
{
    public function index(){
		return view('front.changepassword');
	}
}
