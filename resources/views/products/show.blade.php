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
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="row no-gutters align-items-center shadow">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/images/products/'.$product->image) }}" class="img-fluid" style="height:400px; object-fit:cover;" alt="{{$product->name}}">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                            <p class="card-text mb-3"> &#8369; {{ $product->price }} </p>
                            <p class="lead">{{ $product->description }}</p>

                            @if(Cart::session((auth()->user()) ? auth()->id() : '_token')->get($product->id))
                            <form action="{{ route('carts.remove', $product->id) }}">
                                <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> Remove to cart</button>
                            </form>
                            @else
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-default btn-sm btn-number" disabled="disabled" data-type="minus" data-field="quantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" name="quantity" class=" text-center input-number" value="" min="1" max="{{$product->quantity}}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default btn-sm btn-number" data-type="plus" data-field="quantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <form action="{{ route('carts.add', $product->id) }}">
                                    <input type="hidden" name="quantity" class="quantity" value="">
                                    <button type="submit" class="btn btn-sm btn-success"> <i class="fas fa-cart-plus"> </i> Add to Cart</butt>
                                </form>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($products) > 0)
    <section class="py-5">
        <h2 class="my-5"> {{$product->category->name}}</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6 mb-2 mb-lg-0">
                <div class="card">
                    <a href="{{ route('product', $product->id) }}"> <img src="{{ asset('storage/images/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}"> </a>
                    <div class="card-body">
                        <a href="{{ route('product', $product->id) }}">
                            <h5 class="text-dark  text-truncate "> {{ $product->name }} </h5>
                            <p class="small text-muted text-truncate">{{ $product->description }}</p>
                            <p class="text-muted small mb-0"> &#8369; {{ $product->price }}</p>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </section>
    @endif
</div>
@endsection

@section('script')
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>

<script>
$(function(){
    $("input[name='quantity']").val(1);
    //plugin bootstrap minus and plus
    //http://jsfiddle.net/laelitenetwork/puJ6G/
    $('.btn-number').click(function(e) {
        e.preventDefault();

        type = $(this).attr('data-type');
        var input = $("input[name='quantity']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $("input[name='quantity']").focusin(function() {
        $(this).data('oldValue', $(this).val());
    });

    function changeValue() {
        var input = $("input[name='quantity']");
        input.val($(this).val());
        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled');
        } else {
            input.val(minValue).change();
            $(this).val(1);
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled');
        } else {
            input.val(maxValue).change();
            $(this).val(maxValue);
        }
    }

    $('.input-number').change(changeValue);
    $('.input-number').keyup(changeValue);
    $('.input-number').keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection