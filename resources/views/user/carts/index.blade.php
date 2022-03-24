@extends('layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container">
  <div class="row mt-5">
    <div class="col-md-8">
      <h1>Cart</h1>
      <table id="cart-table" class="table table-sm table-head-fixed ">
        <thead>
          <tr>
            <th>Product image</th>
            <th>Product name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr class="text-center">
            <td>
              <a href="{{route('product',$product->id)}}">
                <img class="rounded img-fluid" src="{{ asset('storage/images/products/'. $product->attributes->image) }}" alt="image" style="height:100px; object-fit:cover;">
              </a>
            </td>
            <td> <a href="{{route('product',$product->id)}}" class="d-inline-block text-truncate" style="max-width: 150px;"> {{ $product->name}} </a></td>
            <td> &#8369; {{$product->price}} </td>
            <td>
              <p class="d-none">{{ $product->quantity }}</p>
              <form action="{{ route('carts.update', $product->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="d-flex align-items-center">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <button type="button" class="btn btn-default btn-sm input-number" data-type="minus" data-field="quantity">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                    <input type="number" name="quantity" class="text-center input-number" value="{{ $product->quantity < App\Model\Product::where('id', '=', $product->id)->get()->first()->quantity ? $product->quantity : App\Model\Product::where('id', '=', $product->id)->get()->first()->quantity }}" min="1" max="{{ App\Model\Product::where('id', '=', $product->id)->get()->first()->quantity }}">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-default btn-sm input-number" data-type="plus" data-field="quantity">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <button type="submit" class="btn custom-bg-color btn-sm btn-save">Save</button>
                </div>
              </form>
            </td>
            <td> <a class="btn btn-outline-danger remove" href="{{ route('carts.remove', $product->id) }}"><i class="fas fa-trash"></i></a> </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">
              <h5>No item in cart</h5>
              <a class="btn custom-bg-color mt-5" href="{{route('products')}}"> Shop Now </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(count($products) > 0)
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3>Cart Summary</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p>Subtotal</p>
              <p>Shipping</p>
              <p>Total</p>
            </div>
            <div class="col-md-6">
              <p> &#8369; {{$cartSubTotal}}</p>
              <p> &#8369; {{number_format((float)$shippingFee, 2, '.', '')}}</p>
              <p> &#8369; {{$cartFinalTotal}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="{{route('checkout')}}" class="btn custom-bg-color btn-block">Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
  $(function() {
    $("#cart-table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": false,
    });
    //plugin bootstrap minus and plus
    //http://jsfiddle.net/laelitenetwork/puJ6G/
    $('.input-group .input-number').click(function(e) {
      e.preventDefault();
      type = $(this).attr('data-type');
      var input = $(this).parent().parent().find("input[name='quantity']");
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

    function changeValue() {
      var input = $(this);
      minValue = parseInt($(this).attr('min'));
      maxValue = parseInt($(this).attr('max'));
      valueCurrent = parseInt($(this).val());
      name = $(this).attr('name');
      if (valueCurrent >= minValue) {
        $(".input-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled');
      } else {
        input.val(minValue).change();
        $(this).val(1);
      }
      if (valueCurrent <= maxValue) {
        $(".input-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled');
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
  $('.remove').click(function() {
    $(this).addClass('disabled');
  })
</script>
@endsection