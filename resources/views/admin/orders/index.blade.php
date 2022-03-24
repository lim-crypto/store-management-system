@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orders</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="orders-table" class="table table-sm table-hover table-head-fixed">
                                <thead>
                                    <tr>
                                        <th>Placed order</th>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Total</th>
                                        <th>Order Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->created_at->format('m/d/Y H:i:s')}}
                                            <span class="text-xs text-muted"> {{ $order->created_at->diffForHumans() }} </span>
                                        </td>
                                        <td> <a href="{{ route('order', $order->id) }}"> {{$order->order_id}} </a> </td>
                                        <td>{{ $order->user->getName() }}</td>
                                        <td> &#8369; {{ $order->total }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                            <span class="badge badge-pill badge-warning py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'packed')
                                            <span class="badge badge-pill badge-info py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'shipped')
                                            <span class="badge badge-pill badge-secondary py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'delivered')
                                            <span class="badge badge-pill badge-success py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'cancelled')
                                            <span class="badge badge-pill badge-danger py-1 px-2">{{$order->status}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('order', $order->id) }}" class="btn btn-sm btn-primary">View</a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<!-- DataTables & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>


<script>
    $(function() {
        $("#orders-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ],

        });

    });
</script>
@endsection