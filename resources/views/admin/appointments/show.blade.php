@extends('admin.layouts.app')
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0">Appointment</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="card-header">
                    {{date( 'm/d/y h a', strtotime($appointment->date))}}
                    <div class="card-tools">
                        @if($appointment->status == 'pending')
                        <span class="badge badge-warning float-right">Pending</span>
                        @elseif($appointment->status == 'cancelled')
                        <span class="badge badge-danger float-right">Cancelled</span>
                        @elseif($appointment->status == 'rejected')
                        <span class="badge badge-danger float-right">Rejected</span>
                        @elseif($appointment->status == 'approved')
                        <span class="badge badge-success float-right">Approved</span>
                        @elseif($appointment->status == 'expired')
                        <span class="badge badge-danger float-right">Expired</span>
                        @else
                        <span class="badge badge-success float-right">Completed</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text mb-0">Name: {{$appointment->user->getName()}}</p>
                    <p class="card-text mb-0">Email: {{$appointment->user->email}}</p>
                    <p class="card-text mb-0">Phone: {{$appointment->user->contact_number}}</p>
                    <p class="card-text mb-0">{{$appointment->service}} </p>
                    <p class="text-muted small mb-0">{{$appointment->offer}}</p>
                    <span class="text-muted small">{{ $appointment->created_at->diffForHumans()}}</span>
                </div>
                @if($appointment->status == 'pending' || $appointment->status == 'approved')
                <div class="card-footer">
                    <button title="approve" type="button" class="btn btn-info btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="approved">
                        <i class="fas fa-thumbs-up"></i>
                    </button>
                    <button title="reject" type="button" class="btn btn-danger btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="rejected">
                        <i class="fas fa-thumbs-down"></i>
                    </button>
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
                                    <form id="status-form" action="{{route('appointment.status',$appointment->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" id="status" value="">
                                        <button type="sumbit" class="btn btn-primary">Confirm</button>
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
<!-- Page specific script -->
<script>
    $('.statusModal').click(function() {
        const status = $(this).attr('data-status');
        $('#statusModalText').text(`Are you sure you want to update appointment status to be ${status}?`);
        $('#status').val(status);
    });
</script>
@endsection