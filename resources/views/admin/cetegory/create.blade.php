@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
	<section class="content-header"> 
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Category</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
		</section>
		<!-- Main content -->
		<section class="content">
			<!-- Default box -->
			<div class="container-fluid">
				<form action="" id="categoryForm" name="categoryForm">

				<div class="card">
					<div class="card-body"> 
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" class="form-control" placeholder="Name">
									<p></p> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="email">Slug</label>
									<input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly>
									<p></p> 
								</div>
							</div>
							<div class="col-md-6">

								<div class="mb-3">
									<label for="image">Image</label>
									<div id="image" class="dropzone dz-clickable">
										<div class="dz-message needsclick">
											<br>Drop Your File or Click to upload<br>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" id="image_id" name="image">

							<div class="col-md-6">
								<div class="mb-3">
									<label for="status">Status</label>
									<select name="status" id="status" class="form-control">
									<option value="1">Active</option> 
									<option value="0">Block</option> 
									</select> 
								</div>
							</div> 
							<div class="col-md-6">
								<div class="mb-3">
									<label for="status">Show Home</label>
									<select name="showhome" id="showhome" class="form-control">
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
					<a href="" class="btn btn-outline-dark ml-3">Cancel</a>
				</div>
			</form>

			</div>
			<!-- /.card -->
		</section>
		<!-- /.content -->

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>
	// submit 
$('#categoryForm').submit(function(e) {
	e.preventDefault();
	var element = $(this);
	$('button[type=submit]').prop('disabled', true);

	function handleValidationError(field, error) {
		var inputField = $("#" + field);
		var feedback = inputField.siblings('p');
		if (error) {
			inputField.addClass('is-invalid');
			feedback.addClass('invalid-feedback').html(error[0]);
		} else {
			inputField.removeClass('is-invalid');
			feedback.removeClass('invalid-feedback').html("");
		}
	}

	$.ajax({
		url: '{{ route('categories.store') }}',
		type: 'post',
		data: element.serialize(),
		dataType: 'json',
		success: function(response) {
			$('button[type=submit]').prop('disabled', false);

			if (response.status === true) {
				window.location.href = '{{ route('categories.index') }}';
				handleValidationError('name', null);
				handleValidationError('slug', null);
			} else {
				var errors = response.errors;
				handleValidationError('name', errors ? errors.name : null);
				handleValidationError('slug', errors ? errors.slug : null);
			}
		},
		error: function(jqXHR, exception) {
			$('button[type=submit]').prop('disabled', false);
			console.log('Something went wrong', exception);
		}
	});
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


// dropzone
Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#image", {
	url: "{{ route('temp-image.create') }}",
	maxFiles: 1,
	paramName: 'image',
	addRemoveLinks: true,
	acceptedFiles: "image/jpeg,image/png,image/gif",
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	init: function() {
		this.on('addedfile', function(file) {
			if (this.files.length > 1) {
				this.removeFile(this.files[0]);
			}
		});
		this.on('success', function(file, response) {
			$("#image_id").val(response.image_id);
		});
	}
});


</script>
</div>

@endsection

