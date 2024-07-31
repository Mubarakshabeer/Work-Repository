@extends('admin.layout.app')

@section('content')


<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header"> 
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Sub Category</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>

	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
			<form action="" class="SubCatForm" id="SubCatForm" name="subcategory">
			<div class="card">
				<div class="card-body"> 
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name">Category</label>
								<select name="category_id" id="subcategory" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="error-message"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Name</label>
								<input type="text" name="name" value="{{ $subCategory->name }}" id="name" class="form-control" placeholder="Name"> 
                                <p class="error-message"></p>
							</div>

						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="email">Slug</label>
								<input type="text" name="slug" id="slug" class="form-control" value="{{ $subCategory->slug }}" placeholder="Slug" readonly> 
                                <p class="error-message"></p>

							</div>
						</div> 
						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
								<option value="1" {{ ($subCategory->status == 1) ? 'selected' : '' }}>Active</option> 
								<option value="0" {{ ($subCategory->status == 0) ? 'selected' : '' }}>Block</option> 
								</select> 
                                <p class="error-message"></p>
							</div>
						</div> 
						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Show Home</label>
								<select name="showhome" id="showhome" class="form-control">
								<option value="1" {{ ($subCategory->showhome == 'Yes' ) ? 'selected' : ' ' }}>Yes</option> 
								<option value="0" {{ ($subCategory->showhome == 'No' ) ? 'selected' : ' ' }}>No</option> 
								</select> 
							</div>
						</div> 
					</div>
				</div> 
			</div>

			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Create</button>
				<a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
		</form>
		</div>
		<!-- /.card -->
	</section>

</div>
<!-- /.content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


$('#SubCatForm').submit(function(e) {
    e.preventDefault();

    var element = $(this);
    $('button[type=submit]').prop('disabled', true);

    function handleValidationError(field, error) {
        var inputField = $("#" + field);
        var feedback = inputField.siblings('.error-message');
        if (error) {
            inputField.addClass('is-invalid');
            feedback.addClass('invalid-feedback').html(error[0]);
        } else {
            inputField.removeClass('is-invalid');
            feedback.removeClass('invalid-feedback').html("");
        }
    }

    $.ajax({
        url: '{{ route('subcategories.update', $subCategory->id) }}',
        type: 'put',
        data: element.serialize(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false);

            if (response.status === true) {
                window.location.href = '{{ route('subcategories.index') }}';
                handleValidationError('name', null);
                handleValidationError('slug', null);
            }
        },
        error: function(jqXHR) {
            $('button[type=submit]').prop('disabled', false);
            
            if (jqXHR.status === 422) {
                var errors = jqXHR.responseJSON.errors;
                handleValidationError('name', errors ? errors.name : null);
                handleValidationError('slug', errors ? errors.slug : null);
                handleValidationError('category', errors ? errors.category : null);
                handleValidationError('status', errors ? errors.status : null);
            } else {
                console.log('Something went wrong');
            }
        }
    });
});

$('#name, #slug, #category, #status').on('focus', function() {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-message').removeClass('invalid-feedback').html("");
});


	// get automaitically slug 

$('#name').change(function() {

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
