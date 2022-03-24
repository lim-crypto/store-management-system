<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')
<style>
    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #14a800;
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #14a800;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    .track .text {
        display: block;
        margin-top: 7px
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ asset('images/kennel-logo.png') }}" width="40" alt="" class="float-left">
                            <h4 class="align-middle">
                                {{ config('app.name', 'PremiumKennel') }}
                                <small class="float-right">Date: {{$order->created_at->format('d M  Y ')}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <header class="card-header">
                            <h4 class="card-title"> My Orders / Tracking</h4>
                            <div class="card-tools">
                                @if($order->status == 'pending')
                                <span class="text-xs text-muted font-weight-light ">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                                <span class="badge badge-pill badge-secondary ml-2 py-1 px-2">{{$order->status}}</span>
                                @elseif($order->status == 'packed')
                                <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->packed_at))}}</span>
                                <span class="badge badge-pill badge-info ml-2 py-1 px-2">{{$order->status}}</span>
                                @elseif($order->status == 'shipped')
                                <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->shipped_at))}}</span>
                                <span class="badge badge-pill badge-warning ml-2 py-1 px-2">{{$order->status}}</span>
                                @elseif($order->status == 'delivered')
                                <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->arrival_time))}} </span>
                                <span class="badge badge-pill badge-success ml-2 py-1 px-2">{{$order->status}}</span>
                                @elseif($order->status == 'cancelled')
                                <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->cancelled_time))}} </span>
                                <span class="badge badge-pill badge-danger ml-2 py-1 px-2">{{$order->status}}</span>
                                @endif
                            </div>
                        </header>
                        <div class="card-body pb-5">
                            <h6>Order ID: {{$order->order_id}}</h6>
                            <div class="track">
                                @if($order->status != 'cancelled')
                                <div class="step active">
                                    <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                                    <span class="text">Placed Order</span>
                                    <span class="text-xs text-muted font-weight-light ">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                                </div>
                                <div class="step {{$order->status != 'pending' ? 'active' : ''}}">
                                    <span class="icon"><i class="fa fa-box"></i></span>
                                    <span class="text">Packed</span>
                                    <span class="text-xs text-muted font-weight-light "> {{$order->packed_at ? date('d M Y h:i:s A', strtotime($order->packed_at)) : ''}}</span>
                                </div>
                                <div class="step {{$order->status=='shipped' ? 'active' : ($order->status=='delivered' ? 'active' : '') }}">
                                    <span class="icon"> <i class="fa fa-truck"></i> </span>
                                    <span class="text"> On the way </span>
                                    <span class="text-xs text-muted font-weight-light "> {{$order->shipped_at ? date('d M Y h:i:s A', strtotime($order->shipped_at)) : ''}}</span>
                                </div>
                                <div class="step {{$order->status=='delivered' ? 'active':''}}">
                                    <span class="icon"> <i class="fa fa-check"></i> </span>
                                    <span class="text">Delivered</span>
                                    <span class="text-xs text-muted font-weight-light "> {{ $order->delivered_time ? date('d M Y h:i:s A', strtotime($order->delivered_time)) : ''}} </span>
                                </div>
                                @else
                                <div class="step active">
                                    <span class="icon"> <i class="fa fa-times"></i> </span>
                                    <span class="text">Cancelled</span>
                                    <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->cancelled_time))}} </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products as $product)
                                    <tr>
                                        <td>
                                            <img class="img-size-50" src="/storage/images/products/{{$product->attributes->image}}" alt="">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>&#8369; {{$product->price}}</td>
                                        <td><span class="text-muted"></span> {{$product->quantity }}</td>
                                        <td>&#8369; {{$product->price * $product->quantity  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 invoice-col">
                            <p class="lead">Shipping address</p>
                            <address>
                                <strong>{{$order->user->getName()}}</strong><br>
                                {{$order->shipping_address}}
                                <br> Email: {{$order->user->email}}
                                <br> {{$order->user->contact_number}}
                            </address>
                        </div>
                        <div class="col-sm-3">
                            <p class="lead">Payment Methods:</p>
                            @if($order->payment_method == 'COD')
                            <p class="h6">Cash on Delivery</p>
                            @else
                            <p class="h6">{{$order->payment_method}}</p>
                            <p class="lead">Payment Status:</p>
                            <p class="h6">{{$order->payment_status}}</p>
                            <p class="lead">Transaction id:</p>
                            <p class="h6">{{$order->transaction_id}}</p>
                            @endif
                        </div>
                        <div class="col-sm-4">
                            <p class="lead">Order Summary</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>&#8369; {{$order->subTotal}}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping fee:</th>
                                        <td>&#8369; {{$order->shippingFee}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><strong> &#8369; {{$order->total}}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>