<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\TempImage;
use image;



class CategoryController extends Controller
{
	public function index(Request $request){

		
	$query = Category::query();

	if ($request->has('keywords') && !empty($request->keywords)) {
		$query->where('name', 'LIKE', '%' . $request->keywords . '%')
			->orWhere('slug', 'LIKE', '%' . $request->keywords . '%');
	}

	$categories = $query->latest()->paginate(10);

	if ($request->ajax()) {
		return view('admin\cetegory\list', compact('categories'))->render();
	}

	return view('admin\cetegory\list', compact('categories'));
}

	public function create(){

		return view('admin.cetegory.create');
	}

	public function store(Request $request) {
		$validation = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'slug' => 'required|unique:category,slug', 
			'image_id' => 'nullable|integer|exists:temp_images,id' 
		]);

		if ($validation->passes()) {
			$category = new Category();
			$category->name = $request->name;
			$category->slug = $request->slug;
			$category->status = $request->status;
			$category->showhome = $request->showhome;
			$category->save();

			// Image save
			if (!empty($request->image)) {
				$tempImage = TempImage::find($request->image);
				if ($tempImage) {
					$extArray = explode('.', $tempImage->name);
					$ext = end($extArray);
					$newImageName = $category->id . '.' . $ext;
					$sourcePath = public_path('/temp/' . $tempImage->name);
					$destinationPath = public_path('/upload/category/' . $newImageName);
					File::copy($sourcePath, $destinationPath); 
					// save
					$category->image = $newImageName;
					$category->save();
				}
			}

			$request->session()->flash('success', 'Category added successfully');

			return response()->json([
				'status' => true,
				'message' => 'Category added successfully'
			]);
		} else {
			return response()->json([
				'status' => false,
				'errors' => $validation->errors()->all()
			]);
		}
	}



	public function Edit($catId, Request $request){
		$CategoryID = Category::find($catId);
		if(empty($CategoryID)) {
			return redirect()->route('categories.index');
		}

		return view('admin.cetegory.edit', compact('CategoryID'));
	}


	public function update($subcategory, Request $request)
{
	$category = Category::find($subcategory);

	if (empty($category)) {
		return response()->json([
			'status' => true,
			'notfound' => true,
			'message' => 'Category Not Found'
		]);
	}

	$validation = Validator::make($request->all(), [
		'name' => 'required|string|max:255',
		'slug' => 'required|unique:category,slug,' . $category->id,
	]);

	if ($validation->passes()) {
		$category->name = $request->name;
		$category->slug = $request->slug;
		$category->status = $request->status;
		$category->showhome = $request->showhome;
		$category->save();

		// Image save
		if ($request->image) {
			$tempImage = TempImage::find($request->image);
			if ($tempImage) {
				$extArray = explode('.', $tempImage->name);
				$ext = end($extArray);
				$newImageName = $category->id . '.' . $ext;
				$sourcePath = public_path('/temp/' . $tempImage->name);
				$destinationPath = public_path('/upload/category/' . $newImageName);
				File::copy($sourcePath, $destinationPath);

				// Save image name to category
				$category->image = $newImageName;
				$category->save();
			}
		}

		$request->session()->flash('success', 'Category updated successfully');

		return response()->json([
			'status' => true,
			'message' => 'Category updated successfully'
		]);
	} else {
		return response()->json([
			'status' => false,
			'errors' => $validation->errors()->all()
		]);
	}
}


public function destroy($catId, Request $request)
{
    $category = Category::find($catId);

    if (empty($category)) {
		$request->session()->flash('error', 'Category not found');

        return response()->json([
            'status' => true,
            'message' => 'Category not found'
        ]);
    }

    // Delete the image
    if ($category->image) {
        File::delete(public_path() . '/upload/category/' . $category->image);
    }

    $category->delete();

    $request->session()->flash('success', 'Category deleted successfully');

    return response()->json([
        'status' => true,
        'message' => 'Category deleted successfully'
    ]);
}

}
