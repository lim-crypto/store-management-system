@extends('layouts.app')
@section('style')
<style>
    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <!-- Section: Sidebar -->
            <section class="mb-5 d-none d-sm-block">
                <h5 class="my-3">Categories</h5>
                <div class="text-muted small text-uppercase">
                    @forelse($categories as $category)
                    <p class="mb-3"><a href="{{route('productByCategory' , $category->id)}}" class="card-link-secondary">{{$category->name}}</a></p>
                    @empty
                    <p class="mb-3">No Category</p>
                    @endforelse
                </div>
            </section>
        </div>
        <!-- Products -->
        <div class="col-md-9">
            <section class="row">
                @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-6 mb-2 mb-lg-0">
                    <div class="card">
                        <a href="{{ route('product', $product->id) }}"> <img src="{{ asset('storage/images/products/'.$product->image) }}" class="card-img-top" alt="..."> </a>
                        <div class="card-body">
                            <a href="{{ route('product', $product->id) }}">
                                <h5 class="text-dark  text-truncate "> {{ $product->name }} </h5>
                                <p class="small text-muted text-truncate">{{$product->description}}</p>
                                <p class="text-muted small mb-0">&#8369; {{ $product->price }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <h5 class="text-center">No products found</h5>
                </div>
                @endforelse
            </section>
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection