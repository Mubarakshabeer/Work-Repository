<?php

namespace App\Http\Controllers\frontController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\subcategory;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    public function shopIndex(Request $request , $categorySlug = null, $subCategorySlug = null)
    {
        $categories = Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name','ASC')->where('status',1)->get();

        // apply filters
        $Product = Product::where('status',1);

        // if(!empty($categorySlug)){
        //     $category = Category::where('slug',$categorySlug)->first();
        //     $Product = $Product->where('category_id', $category->id);
        //    }
        return view('front.shop',compact('categories','brands','Product'));
    }

}
