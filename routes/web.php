<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\subcategoryController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsubCategory;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\frontController\FrontHomePageController;
use App\Http\Controllers\frontController\ShopController;
use App\Http\Controllers\frontController\MyaccountController;
use App\Http\Controllers\frontController\CartController;
use App\Http\Controllers\frontController\MyorderController;
use App\Http\Controllers\frontController\RegisterController;
use App\Http\Controllers\frontController\ContactusController;
use Illuminate\Http\Request;



// Front end
Route::get('/',[FrontHomePageController::Class, 'index'])->name('front.home');
// shop
Route::get('front/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::Class, 'shopIndex'])->name('front.shop');
// account
Route::get('front/account',[MyaccountController::Class, 'index'])->name('front/account');
// cart
Route::get('front/cart',[CartController::Class, 'index'])->name('front/cart');

// my-orders
Route::get('front/myOrders',[ContactusController::Class, 'index'])->name('front/myOrders');

// register
Route::get('front/register',[RegisterController::Class, 'index'])->name('front/register');

// aboutus
Route::get('front/aboutus',[FrontHomePageController::Class, 'aboutus'])->name('front.aboutus');

// contact us 
Route::get('front/contactus',[ContactusController::Class, 'index'])->name('front.contactus');

// forget password
Route::get('front/contactus',[ContactusController::Class, 'index'])->name('front.contactus');





// debug
Route::get('/debug', function () {
    $controller = \App\Http\Controllers\frontController\FrontHomePageController::class;
    if (class_exists($controller)) {
        return "Class exists!";
    } else {
        return "Class does not exist.";
    }
});


// backend Admin panal:-

Route::group(['prefix' => 'admin'], function () {
	Route::group(['middleware' => 'admin.guest'], function () {
		Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
		Route::post('authendicate', [AdminLoginController::class, 'athendicate'])->name('admin.authendicate');
	});

	Route::group(['middleware' => 'admin.auth'], function () {
		// Add your authenticated admin routes here
		Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
		Route::get('logout', [HomeController::class, 'logout'])->name('admin.logout');

		// category Routes module
		Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
		Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
		// edit
		Route::get('/categories/{category}/edit', [CategoryController::class, 'Edit'])->name('categories.edit');
		Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
		// update
		Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        // delete
		Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


		// temp-image file 
		Route::post('/upload-temp-image', [TempImageController::class, 'create'])->name('temp-image.create');

		// get slug automaitically
		Route::get('getSlug', function(Request $request) {
			$slug = '';
			if (!empty($request->title)) {
				$slug = Str::slug($request->title);
			}
			return response()->json([
				'status' => true,
				'slug' => $slug
			]);
		})->name('getSlug');


		// sub category module
		Route::get('/sub_categories', [subcategoryController::class, 'index'])->name('subcategories.index');
		Route::get('/sub_categories/create', [subcategoryController::class, 'create'])->name('sub_categories.create');
		Route::post('/sub_categories', [subcategoryController::class, 'store'])->name('subcategories.store');
		// edit
		Route::get('/sub_categories/{subcategory}/edit', [subcategoryController::class, 'Edit'])->name('subcategory.subcatedit');
		Route::put('/sub_categories/{subcategory}', [subcategoryController::class, 'update'])->name('subcategories.update');
		// delete
		Route::delete('/sub_categories/{subcategory}', [subcategoryController::class, 'destroy'])->name('subcategories.destroy');


		// brand module 
		Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
		Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
		Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
		Route::get('/brand/{brandid}/edit', [BrandController::class, 'Edit'])->name('brand.edit');
		Route::put('/brand/{brandid}', [BrandController::class, 'update'])->name('brand.update');
		Route::delete('/brand/{brandid}', [BrandController::class, 'destroy'])->name('brand.destroy');


		// Product Module
		Route::get('/product', [ProductController::class, 'index'])->name('product.index');
		Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
		Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
		// subcategory fetch
		Route::get('/product_subcategory/index', [ProductsubCategory::class, 'index'])->name('product_subcategory.index');

		// temp-image file 
		Route::post('/upload-product-image', [ProductImageController::class, 'create'])->name('product-image.create');
		
		Route::get('/product/{productid}/edit', [ProductController::class, 'Edit'])->name('product.edit');
		Route::put('/product/{productid}', [ProductController::class, 'update'])->name('product.update');
		Route::delete('/product/{productid}', [ProductController::class, 'destroy'])->name('product.destroy');




	});
});
