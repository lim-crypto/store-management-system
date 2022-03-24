@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 order-md-2  mb-4 p-3">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your Order Summary</span>
                <span class="badge badge-secondary badge-pill">{{$products->count()}}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$product->name}}</h6>
                        <small class="text-muted">&#8369;{{$product->price}}</small>
                        <small class="text-muted">Qty : {{$product->quantity}}</small>
                    </div>
                    <span class="text-muted"> &#8369;{{$product->price * $product->quantity}} </span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-primary">
                        <h6 class="my-0"> Sub total </h6>
                    </div>
                    <span class="text-primary"> &#8369;{{$cartSubTotal}} </span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-info">
                        <h6 class="my-0">Shipping Fee</h6>
                    </div>
                    <span class="text-info"> &#8369;{{$shippingFee}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (PHP)</span>
                    <strong> &#8369;<span id="total">{{$cartFinalTotal}}</span> </strong>
                </li>
            </ul>
        </div>
        <div class="col-md-8 order-md-1 border shadow p-3">
            <h4 class="mb-3">Shipping address</h4>
            <form id="checkout-form" class="needs-validation" novalidate="" action="{{route('place-order')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="{{Auth::user()->first_name}}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="{{Auth::user()->last_name}}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="{{Auth::user()->email}}" disabled>
                </div>
                <div class="mb-3">
                    <label for="address">Address</label> <span class="text-danger">*</span>
                    <select name="shippingAddress" class="form-control" id="address" required>
                        @foreach($shippingAddresses as $shippingAddress )
                        <option value=" {{$shippingAddress->completeAddress()}} "> {{$shippingAddress->completeAddress()}} </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add">
                        <i class="fas fa-plus"></i> Add New Address
                    </button>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Payment</h4>
                <div class="my-3">
                    <div class="form-check">
                        <input id="cod" name="paymentMethod" type="radio" class="form-check-input" value="COD" checked="" required="">
                        <label class="form-check-label" for="cod">Cash on delivery</label>
                    </div>
                    <div class="form-check">
                        <input id="pay-pal" name="paymentMethod" type="radio" class="form-check-input" value="Paypal" required="">
                        <label class="form-check-label" for="pay-pal">PayPal</label>
                        <input type="hidden" name="transaction_id" id="transaction_id">
                        <input type="hidden" name="paymentStatus" id="paymentStatus">
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn custom-bg-color btn-lg btn-block mb-3" type="submit" id="placeOrder">Place order now</button>
            </form>


            <p class="note d-none text-danger small text-italic">note: you cannot cancel order if the transaction are done <br> note: no refund </p>

            <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
            <script src="https://www.paypal.com/sdk/js?client-id=ATEicUepoC2VdhOOVWRwjwZRrfrOq4AT0UeEMCdrrc0CqDApne-va_i9eYPQPZC2h_lfaa6-uYFeQ5CG&currency=PHP"></script>

            <!-- Set up a container element for the button -->
            <div id="paypal-button-container" class="d-none"></div>

            <script>
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: document.getElementById('total').innerText
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {
                            var transaction = orderData.purchase_units[0].payments.captures[0];
                            document.getElementById('transaction_id').value = transaction.id;
                            document.getElementById('paymentStatus').value = 'Paid';
                            document.getElementById("checkout-form").submit();
                            document.getElementById('loading').style.display='';
                        });
                    }
                }).render('#paypal-button-container');
            </script>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="add" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add shipping address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('shippingAddresses.store')}}" method="POST" class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="houseNumber">House number</label>
                            <input type="text" class="form-control" id="houseNumber" name="houseNumber">
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" name="street">
                        </div>
                        <div class="form-group">
                            <label for="brgy">Brgy</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="brgy" name="brgy" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- form-validation -->
<script src="{{asset('js/form-validation.js')}}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
    $(function() {
        $('#checkout-form').submit(function() {
            $('#loading').show();
        });
        $('input[type=radio][name=paymentMethod]').change(function() {
            if ($('#pay-pal').is(':checked')) {
                $('.note').removeClass('d-none');
                $('#paypal-button-container').removeClass('d-none');
                $('#placeOrder').addClass('d-none');
            } else {
                $('.note').addClass('d-none');
                $('#paypal-button-container').addClass('d-none');
                $('#placeOrder').removeClass('d-none');
            }
        })
    });
</script>
@endsection