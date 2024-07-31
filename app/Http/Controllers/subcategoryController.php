<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\subcategory;


class subcategoryController extends Controller
{
	public function index(Request $request)
	{
		$query = Subcategory::with('category');

		$subCategories = $query->latest()->paginate(10);

		if ($request->ajax()) {
			return view('admin.subcategory.subcategory', compact('subCategories'))->render();
		}

		return view('admin.subcategory.subcategory', compact('subCategories'));
	}

	public function create(){

		$categories = Category::latest()->get();
		$data['category'] = $categories;

		return view('admin.subcategory.subcatcreate',$data);
	}

	public function store(Request $request)
	{
			$validation = Validator::make($request->all(), [
				'name' => 'required|string|max:255',
				'slug' => 'required|unique:category,slug', 
				'category_id' => 'required',
				'status' => 'required',
			]);

			if ($validation->fails()) {
				return response()->json([
					'status' => false,
					'errors' => $validation->errors()
				], 422);
			}

			if($validation->passes()){
				$SubCategories = new subcategory();
				$SubCategories->name = $request->name;
				$SubCategories->slug = $request->slug;
				$SubCategories->category_id = $request->category_id;
				$SubCategories->status = $request->status;
				$SubCategories->showhome = $request->showhome;
				$SubCategories->save();
				}

			$request->session()->flash('success', 'Subcategory added successfully');


		return response()->json([
			'status' => true,
			'message' => 'Subcategory created successfully!'
		]);
	}


	public function edit($subcategoryId, Request $request) {
			// Fetch the specific subcategory
			$subCategory = Subcategory::find($subcategoryId);

			if (empty($subCategory)) {
				return redirect()->route('subcategories.index');
			}

			// Fetch all categories to populate the dropdown
			$categories = Category::all();

			return view('admin.subcategory.subcatedit', compact('subCategory', 'categories'));
	}
		

	public function update($subcategory, Request $request) {
			$SubCategories = Subcategory::find($subcategory);

			if (empty($SubCategories)) {
				return response()->json([
					'status' => true,
					'notfound' => true,
					'message' => 'Sub Category Not Found'
				]);
			}

			$validation = Validator::make($request->all(), [
				'name' => 'required|string|max:255',
				'slug' => 'required|unique:category,slug,' . $SubCategories->id,
			]);

			if ($validation->passes()) {
				$SubCategories->name = $request->name;
				$SubCategories->slug = $request->slug;
				$SubCategories->category_id = $request->category_id;
				$SubCategories->status = $request->status;
				$SubCategories->showhome = $request->showhome;
				$SubCategories->save();
			}

			$request->session()->flash('success', 'Subcategory added successfully');

				return response()->json([
					'status' => true,
					'message' => 'Subcategory created successfully!'
				]);

	}


	public function destroy($subcategory, Request $request){

		$subcategory = Subcategory::find($subcategory);

		$subcategory->delete();

		$request->session()->flash('success', 'Category deleted successfully');
	
		return response()->json([
			'status' => true,
			'message' => 'Category deleted successfully'
		]);

		

	}

}
