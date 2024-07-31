<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempImage;

class TempImageController extends Controller
{
	public function create(Request $request)
	{
		$image = $request->image;
		if (!empty($image)) {
			$ext = $image->getClientOriginalExtension();
			$newName = time() . '.' . $ext;

			$tempImage = new TempImage();
			$tempImage->name = $newName;
			$tempImage->save();


			$image->move(public_path() . '/temp', $newName);

			return response()->json([
				'status' => true, 
				'image_id' => $tempImage->id,
				'message' => 'Image Updated Successfully'
			]);
		}

		return response()->json([
			'status' => false,
			'message' => 'No image provided'
		], 400);
	}
}
