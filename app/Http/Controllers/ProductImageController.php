<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'images.*' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $uploadedImages = [];

        if($request->hasfile('images')) {
            foreach($request->file('images') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->storeAs('public/images', $name);

                $uploadedImages[] = $name;

                // Save the file information in the database
                ProductImage::create([
                    'product_id' => $request->input('product_id'), // make sure to pass product_id
                    'image' => $name,
                    'sort_order' => 0 // you can set it as needed
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'uploaded_images' => $uploadedImages
        ]);
    }
}

