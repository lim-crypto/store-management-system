@extends('admin.layouts.app')
@section('style')
<!-- summernote -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/summernote/summernote-bs4.min.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/ekko-lightbox/ekko-lightbox.css')}}">
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .ekko-lightbox .modal-dialog .modal-content .modal-body {
        padding: 0px;
    }
</style>
@endsection
@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Pet Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('pets.index')}}">Pets</a></li>
                        <li class="breadcrumb-item active">Edit Pet Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-edit"></i>
                            Pet Details
                        </h3>
                    </div>
                    <form action="{{route('pets.update',$pet->slug)}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="card-body row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="type">Type</label> <span class="text-danger">*</span>
                                            <select name="type_id" id="type" class="form-control  {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required>
                                                <option value="" selected disabled>Select Pet type</option>
                                                @foreach($types as $type)
                                                <option {{($pet->type_id==$type->id) ? 'selected' : '' }} value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                Type is required
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="breed">Breed</label> <span class="text-danger">*</span>
                                            <select id="breed" name="breed_id" class="form-control  {{ $errors->has('breed_id') ? ' is-invalid' : '' }}" required>
                                                @foreach ($breeds as $breed)
                                                <option {{($pet->breed_id==$breed->id) ? 'selected' : '' }} data-breed_type_id="{{$breed->type->id}}" value="{{$breed->id}}">{{$breed->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                Breed is required
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name</label> <span class="text-danger">*</span>
                                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="Enter Name" required value="{{old('name') ? old('name') : ($pet->name ? $pet->name : '')}}">
                                            <span class="invalid-feedback" role="alert">
                                                Name is required
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Birthday </label> <span class="text-danger">*</span>
                                            <div class="input-group date" id="birthday" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input  {{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" data-target="#birthday" placeholder="Enter Birthday" required value="{{  old('birthday') ? date('m/d/Y', strtotime(old('birthday')))  : ($pet->birthday ? date('m/d/Y', strtotime($pet->birthday)) : '') }}" autocomplete="off">
                                                <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <span class="invalid-feedback" role="alert">
                                                    Birthday is required
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="gender">Gender</label> <span class="text-danger">*</span>
                                            <select class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" id="gender" name="gender" required>
                                                <option value="" selected disabled hidden>Select Gender</option>
                                                <option {{old('status') == 'male' ? 'selected' : ($pet->gender == 'male' ? 'selected' : '')}} value="male">Male </option>
                                                <option {{old('status') == 'female' ? 'selected' : ($pet->gender == 'female' ? 'selected' : '')}} value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="weight">Weight</label> <span class="text-info small">(kg)</span>
                                            <input type="number" step="any" min="0" class="form-control {{ $errors->has('weight') ? ' is-invalid' : '' }}" id="weight" name="weight" placeholder="Enter Weight" required value="{{old('weight') ? old('weight') : ($pet->weight ? $pet->weight : '') }}">
                                            <span class="invalid-feedback" role="alert">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="height">Height</label> <span class="text-info small">(cm)</span>
                                            <input type="number" step="any" min="0" class="form-control" id="height" name="height" placeholder="Enter Height" value="{{old('height') ? old('height') : ($pet->height ? $pet->height : '' )}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status">Status</label> <span class="text-danger">*</span>
                                            <select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" name="status" required>
                                                <option value="" selected disabled hidden>Select Status</option>
                                                <option value="available" {{ old('status') == 'available' ? 'selected' : ($pet->status == 'available' ? 'selected' : '') }}>Available</option>
                                                <option value="not available" {{ old('status') == 'not available' ? 'selected' : ($pet->status == 'not available' ? 'selected' : '') }}>Not Available</option>
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                Status is required
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="price">Price</label> <span class="text-muted small">(Optional)</span>
                                            <input type="number" step="any" min="0" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" name="price" placeholder="Enter Price" value="{{old('price') ? old('price') : ($pet->price ? $pet->price : '')}}">
                                            <span class="invalid-feedback" role="alert">
                                                Price is required
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="image">Upload Image</label> <span class="text-danger">*</span>
                                    <div class="custom-file">
                                        <input type="file" name="images[]" class="custom-file-input  {{ $errors->has('images.*') ? ' is-invalid' : ($errors->has('images')?' is-invalid':'') }}" id="gallery-photo-add" multiple accept="image/*">
                                        <label class="custom-file-label" for="gallery-photo-add">Choose Image</label>
                                        <div class="invalid-feedback">
                                            Please choose image
                                        </div>
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="gallery w-100 row m-0">
                                        @if($pet->images)
                                        @foreach($pet->images as $image)
                                        <a href="{{asset('storage/images/pets/'.$image)}}" data-toggle="lightbox" data-gallery="gallery" class="w-100 col-sm-4  ">
                                            <img src="{{asset('storage/images/pets/'.$image)}}" class="w-100 img-thumbnail h-100" style="object-fit: cover;">
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="summernote" name="description">{{old('description') ? old('description') : ($pet->description ? $pet->description : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('pets.index')}}" class="btn btn-warning">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<!-- Select2 -->
<script src="{{asset('Adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('Adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('Adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- InputMask -->
<script src="{{ asset('Adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('Adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('Adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- Ekko Lightbox -->
<script src="{{ asset('Adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function() {
        function findSameTypeId($type) {
            $('#breed').find('option').each(function() {
                if ($(this).attr('data-breed_type_id') == type) {
                    $(this).show();
                    $(this).removeAttr('disabled');
                } else {
                    $(this).hide();
                    $(this).attr('disabled', 'disabled');
                }
            });
        }
        //check the value of type
        var type = $('#type').val();
        findSameTypeId(type);
        $('#type').change(function() {
            type = $(this).val();
            $('#breed').val('');
            findSameTypeId(type);
        });
        // custom file input
        bsCustomFileInput.init();
        // Summernote
        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'help']]
            ]
        });
        //Date picker
        $('#birthday').datetimepicker({
            format: 'L',
            maxDate: new Date(),

        });
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('<a href="' + event.target.result + '" data-toggle="lightbox" data-gallery="gallery">').addClass('w-100 col-sm-4 preview-image')
                            .append($($.parseHTML('<img>')).attr('src', event.target.result).addClass('w-100 img-thumbnail h-100')
                                .css({
                                    "object-fit": "cover"
                                })).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#gallery-photo-add').on('change', function() {
            $('.gallery').empty();
            imagesPreview(this, 'div.gallery');
        });
        // lightbox
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    })
</script>
@endsection