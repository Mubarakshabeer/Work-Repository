<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\subcategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
	public function index(){
        $productlist = Product::latest('id')->with('product_images')->paginate(10);
		return view('admin.product.index', compact('productlist'));
	}

	public function create(){
		$category = Category::latest()->get();
		$subcategory = subcategory::latest()->get();
		$brands = Brand::latest()->get(); 

		return view('admin.product.create', compact('category', 'subcategory','brands' ));
	}

    public function store(Request $request){
        // Validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'images.*' => 'required|mimes:jpg,jpeg,png|max:2048',
            'sku' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'qty' => 'nullable|numeric',
            'category_id' => 'required|exists:category,id', 
            'is_featured' => 'required|in:Yes,No',
        ];
                if ($request->track_qty === 'Yes') {
                    $rules['qty'] = 'required|numeric';
                }

        $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }
        // Create and save the product
        $productCreate = new Product();
        $productCreate->title = $request->title;
        $productCreate->slug = $request->slug;
        $productCreate->description = $request->description;
        $productCreate->price = $request->price;
        $productCreate->compare_price = $request->compare_price;
        $productCreate->sku = $request->sku;
        $productCreate->barcode = $request->barcode;
        $productCreate->track_qty = $request->track_qty;
        $productCreate->qty = $request->qty;
        $productCreate->status = $request->status;
        $productCreate->category_id = $request->category_id;
        $productCreate->sub_category_id = $request->sub_category_id;
        $productCreate->brand_id = $request->brand_id;
        $productCreate->is_featured = $request->is_featured;

        $productCreate->save();


        // dd($request->hasfile('images'));
        $uploadedImages = [];
        if($request->hasfile('images')) {
            foreach($request->file('images') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $filePath = public_path('/product/images/' . $name);
                $file->move(public_path('/product/images'), $name);

                $uploadedImages[] = $name;
                $productImage = new ProductImage();
                $productImage->product_id = ($productCreate->id);
                $productImage->image = $name;
                $productImage->sort_order = 0;
                $productImage->save();
            }
        }
        $request->session()->flash('success', 'Product added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully!'
            ], 201);        
    }           


        public function Edit($productid, Request $request){

            $productsedit = Product::find($productid);
        
                if(empty($productsedit)){
                    return redirect()->route('product.index');
                }
            $productImages = ProductImage::where('product_id', $productid)->get();
            $productcategory = Category::all();
            $productsubcategory = Subcategory::all();
    		$Productbrands = Brand::all(); 

            // dd($productcategory, $productsubcategory);

            return view('admin.product.edit', compact('productsedit','productImages','productcategory', 'productsubcategory','Productbrands'));
        }

        public function update($productid, Request $request)
        {
            $productsupdate = Product::find($productid);
            //  dd($productsupdate);

                if (empty($productsupdate)) {
                    return response()->json([
                        'status' => false,
                        'notfound' => true,
                        'message' => 'Product Not Found'
                    ]);
                }
                // Update product details
                $productsupdate->title = $request->title;
                $productsupdate->slug = $request->slug;
                $productsupdate->description = $request->description;
                $productsupdate->price = $request->price;
                $productsupdate->compare_price = $request->compare_price;
                $productsupdate->sku = $request->sku;
                $productsupdate->barcode = $request->barcode;
                $productsupdate->track_qty = $request->track_qty;
                $productsupdate->qty = $request->qty;
                $productsupdate->status = $request->status;
                $productsupdate->category_id = $request->category_id;
                $productsupdate->sub_category_id = $request->sub_category_id;
                $productsupdate->brand_id = $request->brand_id;
                $productsupdate->is_featured = $request->is_featured;
                $productsupdate->save();

                
              // Handle image updates
                $productImages = ProductImage::where('product_id', $productid)->get();                    
                foreach ($productImages as $imageRecord) {
                    $imagePath = public_path('/product/images/' . $imageRecord->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $imageRecord->delete();
                }
            
            // Save new images
                $uploadedImages = [];
            // dd($request->hasfile('images'));

                if($request->hasfile('images')) {
                    foreach($request->file('images') as $file) {
                        $name = time().'_'.$file->getClientOriginalName();
                        $filePath = public_path('/product/images/' . $name);
                        $file->move(public_path('/product/images'), $name);

                        $uploadedImages[] = $name;
                        $productImage = new ProductImage();
                        $productImage->product_id = ($productsupdate->id);
                        $productImage->image = $name;
                        $productImage->sort_order = 0;
                        $productImage->save();
                    }
                }

            $request->session()->flash('success', 'Product updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully!'
            ], 200);
        }

        public function destroy($productid, Request $request)
        {
            $product = Product::find($productid);
        
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'notfound' => true,
                    'message' => 'Product Not Found'
                ]);
            }
        
            // Delete associated images
            $productImages = ProductImage::where('product_id', $productid)->get();
            foreach ($productImages as $image) {
                $imagePath = public_path('product/images/' . $image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the file
                }
                $image->delete(); // Delete the image record from the database
            }
            // Delete the product
            $product->delete();
            $request->session()->flash('success', 'Product deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully!'
            ]);
        }
}
