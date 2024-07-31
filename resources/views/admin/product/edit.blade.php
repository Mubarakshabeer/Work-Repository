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
						<form action="{{ route('product.update', $productsedit->id) }}" method="post" name="productcreate" id="product_update" enctype="multipart/form-data">
							@method('PUT')
						<div class="card-body"> 
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="title">Title</label>
										<input type="text" value="{{ $productsedit->title }}" name="title" id="title" class="form-control" placeholder="Title">
										<p class="error-message text-danger"></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="slug">Slug</label>
										<input type="text" value="{{ $productsedit->slug }} "name="slug" id="slug" class="form-control" placeholder="Slug" readonly> 
										<p class="error-message text-danger"></p>

									</div>
								</div> 
								<div class="col-md-12">
									<div class="mb-3">
										<label for="description">Description</label>
										<textarea name="description" id="summernote" cols="30" rows="10" class="summernote w-100" placeholder="Description">{{ $productsedit->description }}</textarea>
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
							<p id="images_error" class="error-message text-danger"></p> 
						</div> 
					</div>
					<div class="card mb-3">
						<div class="card-body">
							<h2 class="h4 mb-3">Pricing</h2> 
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="price">Price</label>
										<input type="text" value="{{ $productsedit->price }}" name="price" id="price" class="form-control" placeholder="Price">
									<p class="error-message text-danger"></p>
										</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="compare_price">Compare at Price</label>
										<input type="text" value="{{ $productsedit->compare_price }}" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
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
										<input type="text" name="sku" value="{{ $productsedit->sku }}" id="sku" class="form-control" placeholder="sku"> 
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="barcode">Barcode</label>
										<input type="text" value="{{ $productsedit->barcode }}" name="barcode" id="barcode" class="form-control" placeholder="Barcode"> 
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
										<input type="number" value="{{ $productsedit->qty }}" min="0" name="qty" id="qty" class="form-control" placeholder="Qty"> 
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
									<option value="1" {{ ($productsedit->status == 1) ? 'selected' : '' }}>Active</option>
									<option value="0" {{ ($productsedit->status == 0) ? 'selected' : '' }}>Block</option>
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
									@foreach ($productcategory as $productcategories)
									<option value="{{ $productcategories->id }}" {{ $productsedit->category_id == $productcategories->id ? 'selected' : '' }}>{{ $productcategories->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-3">
								<label for="category">Sub category</label>
								<select name="sub_category_id" id="sub_category" class="form-control">
									<option value="">Select subcategories</option>
									@foreach ($productsubcategory as $productsubcategory)
									<option value="{{ $productsubcategory->id }}" {{ $productsedit->category_id == $productsubcategory->id ? 'selected' : '' }}>{{ $productsubcategory->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div> 
					<div class="card mb-3">
						<div class="card-body"> 
							<h2 class="h4 mb-3">Product brand</h2>
							<div class="mb-3">
								<select name="brand_id" id="status" class="form-control">
									@foreach ($Productbrands as $Productbrand)
									<option value="">Select brand</option>
									<option value="{{ $Productbrand->id }}" {{ $productsedit->sub_category_id == $productsubcategory->id ? 'selected' : '' }}>{{ $Productbrand->name }}</option>
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
									<option value="No" {{ ($productsedit->is_featured == 'No') ? 'selected' : '' }}>No</option>
									<option value="Yes" {{ ($productsedit->is_featured == 'Yes') ? 'selected' : '' }}>Yes</option>
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
	// submit 
	$('#product_update').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    $('button[type=submit]').prop('disabled', true);

    $.ajax({
        url: '{{ route('product.update', $productsedit->id) }}',
        type: 'POST', 
        data: formData,
        contentType: false, 
        processData: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT' 
        },
        success: function(response) {
            $('button[type=submit]').prop('disabled', false);

            if (response.status === true) {
                window.location.href = '{{ route('product.index') }}';
                handleValidationError('title', null);
                handleValidationError('slug', null);
            } else {
                var errors = response.errors;
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

function handleValidationError(field, errorMessage) {
    if (errorMessage) {
        $('#' + field + '_error').text(errorMessage);
    } else {
        $('#' + field + '_error').text('');
    }
}




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
