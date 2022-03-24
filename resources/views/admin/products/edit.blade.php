@extends('admin.layouts.app')
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Product</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $product->name }}" required autofocus>
                                            <span class="invalid-feedback" role="alert">
                                                Product name is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required autofocus>{{ $product->description }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                Description name is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input id="price" type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ $product->price }}" required autofocus>
                                            <span class="invalid-feedback" role="alert">
                                                Price name is required
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="custom-file">
                                                <input type="file" accept="image/*" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                                <label class="custom-file-label" for="image">Choose Image</label>
                                                <span class="invalid-feedback" role="alert">
                                                    Please choose image
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select id="category" class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ $product->quantity }}" required autofocus>
                                            @if ($errors->has('quantity'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('quantity') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="featured">Featured</label>
                                            <select class="form-control" name="is_featured" id="featured">
                                                <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <a href="{{route('products.index')}}" class="btn btn-warning"> <i class="fas fa-arrow-circle-left"></i> Back</a>
                                        <button type="submit" class="btn btn-primary float-right">Update</button>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <img src="{{asset('/storage/images/products/'.$product->image)}}" class="product-image" id="preview" alt="">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
@endsection