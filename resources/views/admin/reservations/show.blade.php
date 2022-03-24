@extends('admin.layouts.app')
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservation</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="{{route('petDetails', $reservation->pet->slug)}}">
                            <img src="{{asset('storage/images/pets/'.$reservation->pet->images[0])}}" class="card-img-top" alt="{{$reservation->pet->name}}" title="view info" style="height:250px; object-fit:cover;">
                        </a>
                    </div>
                    <div class="col-md-8">
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
                            <p class="card-text mb-0">{{$reservation->pet->name}} </p>
                            <p class="text-muted small mb-0">{{$reservation->pet->type->name}}</p>
                            <p class="text-muted small mb-0">{{date( 'm/d/y h a', strtotime($reservation->date))}}</p>
                            <span class="text-muted small">{{ $reservation->created_at->diffForHumans()}}</span>
                            <p class="card-text mb-0">Name: {{$reservation->user->getName()}}</p>
                            <p class="card-text mb-0">Email: {{$reservation->user->email}}</p>
                            <p class="card-text mb-0">Phone: {{$reservation->user->contact_number}}</p>
                        </div>
                    </div>
                </div>
                @if($reservation->status == 'pending' || $reservation->status == 'approved')
                <div class="card-footer">
                    <!-- approved -->
                    <button title="approve" type="button" class="btn btn-info btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="approved">
                        <i class="fas fa-thumbs-up"></i>
                    </button>
                    <!-- rejected -->
                    <button title="reject" type="button" class="btn btn-danger btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="rejected">
                        <i class="fas fa-thumbs-down"></i>
                    </button>
                    <!-- completed -->
                    <button title="complete" type="button" class="btn btn-success btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="completed">
                        <i class="fas fa-check"></i>
                    </button>
                    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusModalLabel">Confirm update</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="statusModalText"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <form id="status-form" action="{{route('reservation.status',$reservation->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" id="status" value="">
                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<!-- Page specific script -->
<script>
    $('.statusModal').click(function() {
        const status = $(this).attr('data-status');
        $('#statusModalText').text(`Are you sure you want to update reservation status to be ${status}?`);
        $('#status').val(status);
    });
</script>
@endsection