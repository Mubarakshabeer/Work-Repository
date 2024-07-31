<?php

namespace App\Http\Controllers\frontController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\subcategory;
use App\Models\Category;
use App\Models\Brand;



class FrontHomePageController extends Controller
{
    public function index()
    {
        $Product = Product::where('is_featured','Yes')->where('status',1)->get();
        $LatestProduct = Product::orderBy('id','ASC')->where('status',1)->take(8)->get();
        return view('front.home',compact('Product','LatestProduct'));
    }

    public function aboutus()
    {
        
        return view('front.aboutus');
    }

   
}
