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
    public function shopIndex(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        // Fetch categories and brands
        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();

        // Start the product query
        $productQuery = Product::where('status', 1);

        // Filter by category
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $productQuery->where('category_id', $category->id);
            } else {
                // If category does not exist, return an empty result set
                $productQuery->whereNull('id');
            }
        }

        // Filter by subcategory
        if (!empty($subCategorySlug)) {
            $subcategory = Subcategory::where('slug', $subCategorySlug)->first();
            if ($subcategory) {
                // Assuming a product belongs to a subcategory, make sure your products have 'subcategory_id'
                $productQuery->where('sub_category_id', $subcategory->id);
            } else {
                // If subcategory does not exist, return an empty result set
                $productQuery->whereNull('id');
            }
        }

        // Fetch the products
        $products = $productQuery->orderBy('id', 'DESC')->get();

        // Return the view with the filtered products
        return view('front.shop', compact('categories', 'brands', 'products'));
    }



}
