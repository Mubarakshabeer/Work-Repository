<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;


class ProductsubCategory extends Controller
{
    public function index(Request $request) {
        if (!empty($request->category_id)) {
            $subCategories = Subcategory::where('category_id', $request->category_id)
                ->orderBy('name', 'ASC')
                ->get();
    
            return response()->json([
                'status' => true,
                'subCategories' => $subCategories
            ]);
        } else {
            return response()->json([
                'status' => false,
                'subCategories' => []
            ]);
        }
    }
    
    
}
