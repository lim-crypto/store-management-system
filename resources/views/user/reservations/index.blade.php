@extends('layouts.app')
@section('style')
<!-- sweetalert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-sweetalert />
@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @if($reservations->count() > 0)
        <div class="col-lg-10 col-md-12">
            <div class="float-right btn-group mt-2">
                <div class="dropdown">
                    <button class="btn btn-sm custom-bg-color" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="all"> All items </a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="pending"> Pending</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="approved"> Approved</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="cancelled"> Cancelled</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="rejected"> Rejected</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="expired"> Expired</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="completed"> Completed</a>
                    </div>
                </div>
                <select class="custom-select" style="width: auto; display:none;" data-sortOrder>
                    <option value="sortData"> Sort by Custom Data </option>
                </select>
                <a class="btn btn-sm btn-default sort-btn asc" href="javascript:void(0)" data-sortAsc> <i class="fas fa-sort"></i> Sort </a>
                <a class="btn btn-sm btn-default sort-btn desc d-none" href="javascript:void(0)" data-sortDesc> <i class="fas fa-sort"></i> Sort </a>
            </div>
            <div class="h1">Reservations</div>
            <div class="filter-container">
                @foreach($reservations as $reservation)
                <div class="filtr-item col-lg-3 col-md-4 col-6" data-category="{{$reservation->status}}" data-sort="{{date( 'm/d/y', strtotime($reservation->created_at))}}">
                    <div class="card h-100 ">
                        <a href="{{route('petDetails', $reservation->pet->slug)}}">
                            <img src="{{asset('storage/images/pets/'.$reservation->pet->images[0])}}" class="card-img-top" alt="{{$reservation->pet->name}}" title="view info" style="height:250px; object-fit:cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{$reservation->pet->breed->name}} </h5>
                            @if($reservation->status == 'pending')
                            <span class="badge badge-warning float-right">Pending</span>
                            @elseif($reservation->status == 'cancelled')
                            <span class="badge badge-danger float-right">Cancelled</span>
                            @elseif($reservation->status == 'rejected')
                            <span class="badge badge-danger float-right">Rejected</span>
                            @elseif($reservation->status == 'approved')
                            <span class="badge badge-success float-right">Approved</span>
                            @elseif($reservation->status == 'expired')
                            <span class="badge badge-danger float-right">Expired</span>
                            @else
                            <span class="badge badge-success float-right">Completed</span>
                            @endif
                            <p class="card-text custom-color mb-0">{{$reservation->pet->name}} </p>
                            <p class="text-muted small mb-0">{{$reservation->pet->type->name}}</p>
                            <p class="text-muted small mb-0">{{date( 'm/d/y h a', strtotime($reservation->date))}}</p>
                            <span class="text-muted small">{{ $reservation->created_at->diffForHumans()}}</span>
                            @if($reservation->status == 'pending')
                            <button title="cancel" type="button" class="btn btn-outline-danger btn-sm cancelModal float-right" data-toggle="modal" data-target="#cancelModal" data-reservation="{{$reservation->pet->breed->name.' '.$reservation->pet->name}}" data-link="{{route('reservation.cancel',$reservation->id)}}">
                                cancel
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="col-lg-10 col-md-12">
            <div class="d-flex justify-content-center pt-4">
                <div class="h1">You don't have reservation</div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- cancel modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="cancelModalText">Are you sure you want to cancel this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form id="cancel-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Filterizr-->
<script src="{{ asset('Adminlte/plugins/filterizr/jquery.filterizr.min.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
    $(function() {
        $('.filter-container').filterizr({
            gutterPixels: 3
        });
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
        // sort toggle
        $('.sort-btn').on('click', function() {
            console.log(1);
            if ($(this).hasClass('asc')) {
                $('.asc').hide();
                $('.desc').show();
                $('.desc').removeClass('d-none')
            } else {
                $('.desc').hide();
                $('.asc').show();
            }
        });
        // cancel
        $('.cancelModal').click(function() {
            const reservation = $(this).attr('data-reservation');
            const link = $(this).attr('data-link');
            $('#cancelModalText').text(`Are you sure you want to cancel ${reservation}?`);
            $('#cancel-form').attr('action', link);
        });
    });
</script>
@endsection