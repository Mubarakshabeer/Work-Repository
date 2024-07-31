<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;



class BrandController extends Controller
{
    public function index(){

        $brandData = Brand::latest()->paginate(10);

        return view('admin.brand.index' ,compact('brandData'));
    }

    public function create(){

        return view('admin.brand.create');
    }

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'slug' => 'required|unique:brand,slug', 
		]);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ], 422);
        }
        if ($validation->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
        }
        $request->session()->flash('success', 'Brand added successfully');


		return response()->json([
			'status' => true,
			'message' => 'Brand created successfully!'
		]);

    }

    public function Edit($brandid, Request $request){

        $brandEdit = Brand::find($brandid);

        if (empty($brandEdit)) {
            return redirect()->route('brand.index');
        }
        
        return view('admin.brand.edit', compact('brandEdit'));
    }

    public function update($brandid, Request $request){

        $brand = Brand::find($brandid);

        
	if (!($brandid)) {
		return response()->json([
			'status' => true,
			'notfound' => true,
			'message' => 'Brand Not Found'
		]);
	}
        $validation = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
		]);
        if ($validation->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ], 422);
        }
        if ($validation->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
        }
        $request->session()->flash('success', 'Brand Edit successfully');


		return response()->json([
			'status' => true,
			'message' => 'Brand Edit successfully!'
		]);
    }

    public function destroy($brandid, Request $request){
        $brandDelete = Brand::find($brandid);
        if (!($brandDelete)) {
            return response()->json([
                'status' => true,
                'notfound' => true,
                'message' => 'Brand Not Found'
            ]);
        }

        $brandDelete->delete();

        $request->session()->flash('success', 'Brand Delete successfully');


        return response()->json([
			'status' => true,
			'message' => 'Brand Delete successfully!'
		]);

    }

}
