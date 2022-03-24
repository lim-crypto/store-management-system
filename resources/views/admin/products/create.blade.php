@extends('admin.layouts.app')
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add New Product</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Product Name</label> <span class="text-danger">*</span>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                                            <span class="invalid-feedback" role="alert">
                                                Product name is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label> <span class="text-danger">*</span>
                                            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ old('description') }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                Description is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label> <span class="text-danger">*</span>
                                            <input id="price" type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required>
                                            <span class="invalid-feedback" role="alert">
                                                Price is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label> <span class="text-danger">*</span>
                                            <div class="custom-file">
                                                <input id="image" type="file" accept="image/*" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" required value="{{ old('image') }}" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                                <label class="custom-file-label" for="image">Choose Image</label>
                                                <span class="invalid-feedback" role="alert">
                                                    Please choose image
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Category</label> <span class="text-danger">*</span>
                                            <select id="category" class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                Category is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label> <span class="text-danger">*</span>
                                            <input id="quantity" type="number" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}" required>
                                            <span class="invalid-feedback" role="alert">
                                                Quantity is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="featured">Featured</label> <span class="text-danger">*</span>
                                            <select id="featured" class="form-control{{ $errors->has('is_featured') ? ' is-invalid' : '' }}" name="is_featured" required>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                Featured is required
                                            </span>
                                        </div>
                                        <a href="{{route('products.index')}}" class="btn btn-warning"> <i class="fas fa-arrow-circle-left"></i> Back</a>
                                        <button type="submit" class="btn btn-primary float-right">Save</button>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <img src="" class="product-image" id="preview" alt="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('Adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection