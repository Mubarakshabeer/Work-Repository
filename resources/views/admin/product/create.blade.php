@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <form action="" method="post" name="productcreate" id="product_create" enctype="multipart/form-data">

                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                       <p class="error-message text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly>	
                                        <p class="error-message text-danger"></p>
        
                                    </div>
                                </div>	
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="summernote" cols="30" rows="10" class="summernote w-100" placeholder="Description"></textarea>
                                     <p class="error-message text-danger"></p>
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <input type="file" name="images[]" id="images" class="form-control" multiple> 
                            <p class="error-message text-danger"></p>   
                        </div>	                                                                      
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                		<p class="error-message text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select category</option>
                                    @foreach ($category as $categories)
                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="sub_category_id" id="sub_category" class="form-control">
                                    <option value="">Select subcategories</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand_id" id="status" class="form-control">
                                    @foreach ($brands as $brand)
                                    <option value="">Select brand</option>
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>                                                
                                </select>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<script>
   // Submit form
   $('#product_create').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('button[type=submit]').prop('disabled', true);

        $.ajax({
            url: '{{ route('product.store') }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('button[type=submit]').prop('disabled', false);

                if (response.status === true) {
                    window.location.href = '{{ route('product.index') }}';
                    handleValidationError('title', null);
                    handleValidationError('slug', null);
                } else {
                    let errors = response.errors;
                    handleValidationError('title', errors ? errors.title : null);
                    handleValidationError('slug', errors ? errors.slug : null);
                }
            },
            error: function(jqXHR, exception) {
                $('button[type=submit]').prop('disabled', false);
                console.log('Something went wrong', exception);
            }
        });
    });



// sub cetegory dropdown

$('#category').change(function () {
    var category_id = $(this).val();
    $.ajax({
        url: '{{ route('product_subcategory.index') }}',
        type: 'GET',
        data: { category_id: category_id },
        dataType: 'json',
        success: function(response) {

            $('#sub_category').find("option").not(":first").remove();
            $.each(response["subCategories"],function (key, item) {
                $("#sub_category").append(`<option value ='${item.id}'>${item.name}</option>`)
            });

        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
})

	// get automaitically slug 

	$('#title').change(function() {
	var element = $(this);
	$('button[type=submit]').prop('disable', true);

	$.ajax({
		url: '{{ route('getSlug') }}',
		type: 'get',
		data: { title: element.val() },
		dataType: 'json',
		success: function(response) {
	$('button[type=submit]').prop('disable', false);

		if (response.status === true) {
			$("#slug").val(response.slug);
		}
		},
		error: function(jqXHR, exception) {
			console.log('Something went wrong', exception);
		}
	});
});

</script>
@endsection