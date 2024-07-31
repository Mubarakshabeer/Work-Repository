@extends('admin.layout.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('brand.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="" id="brandCreate" class="brandCreate">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ $brandEdit->name }}" class="form-control" placeholder="Name">
								<p class="error-message text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ $brandEdit->slug }}"  class="form-control" placeholder="Slug" readonly>	
								<p class="error-message text-danger"></p>

                            </div>
                        </div>	
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                <option value="1"  {{ ($brandEdit->status == 1) ? 'selected' : '' }}>Active</option> 
                                <option value="0"  {{ ($brandEdit->status == 0) ? 'selected' : '' }}>Block</option> 
                                </select> 
                            </div>
                        </div> 
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
        </div>
        <!-- /.card -->
    </section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- /.content -->
</div>

<script>
   $('#brandCreate').submit(function(e) {
    e.preventDefault();
    var element = $(this);
    $('button[type=submit]').prop('disabled', true);

    function handleValidationError(field, error) {
        var inputField = $("#" + field);
        var feedback = inputField.next('.error-message');
        if (error) {
            inputField.addClass('is-invalid');
            feedback.html(error[0]);
        } else {
            inputField.removeClass('is-invalid');
            feedback.html("");
        }
    }

    $.ajax({
        url: '{{ route('brand.update', $brandEdit->id) }}',
        type: 'put',
        data: element.serialize(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false);

            if (response.status === true) {
                window.location.href = '{{ route('brand.index') }}';
                handleValidationError('name', null);
                handleValidationError('slug', null);
            } else {
                var errors = response.errors;
                handleValidationError('name', errors ? errors.name : null);
                handleValidationError('slug', errors ? errors.slug : null);
            }
        },
        error: function(jqXHR) {
            $('button[type=submit]').prop('disabled', false);
            if (jqXHR.status === 422) {
                var errors = jqXHR.responseJSON.errors;
                handleValidationError('name', errors ? errors.name : null);
                handleValidationError('slug', errors ? errors.slug : null);
            } else {
                console.log('Something went wrong');
            }
        }
    });
});


$('#name, #slug, #category, #status').on('focus', function() {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-message').removeClass('text-danger').html("");
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