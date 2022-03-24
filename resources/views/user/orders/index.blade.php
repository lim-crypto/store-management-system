@extends('layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Your Orders</h2>
                </div>
                <div class="panel-body">
                    <table id="orders-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Placed order</th>
                                <th>Order id</th>
                                <th>Order Status</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->created_at->format('m/d/Y h:i A')}}
                                    <span class="text-xs text-muted"> {{ $order->created_at->diffForHumans() }} </span>
                                </td>
                                <td>   <a href="{{ route('orders.show', $order->id) }}" > {{$order->order_id}} </a> </td>
                                <td class="text-capitalize">
                                    @if($order->status == 'pending')
                                    <span class="badge badge-pill badge-secondary ml-2 py-1 px-2">{{$order->status}}</span>
                                    <span class="text-xs text-muted">{{$order->created_at->format('d M  Y h:i A')}}</span>
                                    @elseif($order->status == 'packed')
                                    <span class="badge badge-pill badge-info ml-2 py-1 px-2">{{$order->status}}</span>
                                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->packed_at))}}</span>
                                    @elseif($order->status == 'shipped')
                                    <span class="badge badge-pill badge-warning ml-2 py-1 px-2">{{$order->status}}</span>
                                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->shipped_at))}}</span>
                                    @elseif($order->status == 'delivered')
                                    <span class="badge badge-pill badge-success ml-2 py-1 px-2">{{$order->status}}</span>
                                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->delivered_at))}} </span>
                                    @elseif($order->status == 'cancelled')
                                    <span class="badge badge-pill badge-danger ml-2 py-1 px-2">{{$order->status}}</span>
                                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->cancelled_at))}} </span>
                                    @endif
                                </td>
                                <td> &#8369; {{ $order->total }}</td>
                                <td>
                                    <button title="Cancel order" href="#!" class="btn btn-outline-danger cancel" data-toggle="modal" data-target="#modal-danger" data-order="{{$order->order_id}}" data-link="{{route('orders.cancel' , $order->id)}}"  @if($order->status !='pending' || $order->payment_status=='Paid' ) disabled @endif >Cancel</button>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn custom-bg-color">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel order <b id="order_id">?</b></p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form action="" method="POST" id="cancel-form">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger"> Confirm </button>
                </form>
            </div>
        </div>
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
    // cancel
    $('.cancel').click(function() {
        const link = $(this).attr('data-link');
        const order = $(this).attr('data-order');
        $('#cancel-form').attr('action', link);
        $('#order_id').text(order);
    });
    $(function() {
        $("#orders-table").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
@endsection