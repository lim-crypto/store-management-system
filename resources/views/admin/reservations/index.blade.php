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
          <h1 class="m-0">Reservations</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="d-flex">
        <h4 class="text-muted">Filter : &nbsp; </h4>
        <div class="dropdown">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
            Status
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('reservationByStatus','pending')}}">Pending</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','approved')}}">Approved</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','cancelled')}}">Cancelled</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','rejected')}}">Rejected</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','expired')}}">Expired</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','completed')}}">Completed</a>
            <a class="dropdown-item" href="{{route('reservations')}}">All</a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table id="table" class="table  table-striped table-hover ">
            <thead>
              <tr>
                <th>created at</th>
                <th>Name</th>
                <th>Pet name</th>
                <th>Date of visit</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reservations as $reservation)
              <tr>
                <td>{{date('m/d/Y H:i:s',strtotime($reservation->created_at))}}
                  <span class="text-xs text-muted"> {{$reservation->created_at->diffForHumans() }} </span>
                </td>
                <td>{{$reservation->user->getName()}}</td>
                <td>{{$reservation->pet->name}}</td>
                <td>{{date('m/d/Y h a',strtotime($reservation->date))}}</td>
                <td>
                  @if($reservation->status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                  @elseif($reservation->status == 'approved')
                  <span class="badge badge-success">Approved</span>
                  @elseif($reservation->status == 'rejected')
                  <span class="badge badge-danger">Rejected</span>
                  @elseif($reservation->status == 'cancelled')
                  <span class="badge badge-danger">Cancelled</span>
                  @elseif($reservation->status == 'expired')
                  <span class="badge badge-danger">Expired</span>
                  @else
                  <span class="badge badge-success  ">Completed</span>
                  @endif
                </td>
                <td>
                  <button title="view" type="button" class="btn btn-info btn-sm viewModal" data-toggle="modal" data-target="#viewModal" data-breed="{{$reservation->pet->breed->name}}" data-type="{{$reservation->pet->type->name}}" data-reservation="{{$reservation}}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button title="approve" type="button" class="btn btn-info btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="approved" data-link="{{route('reservation.status',$reservation->id)}}" @if($reservation->status != 'pending' ) disabled @endif >
                    <i class="fas fa-thumbs-up"></i>
                  </button>
                  <button title="reject" type="button" class="btn btn-danger btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="rejected" data-link="{{route('reservation.status',$reservation->id)}}" @if($reservation->status != 'pending' ) disabled @endif >
                    <i class="fas fa-thumbs-down"></i>
                  </button>
                  <button title="complete" type="button" class="btn btn-success btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="completed" data-link="{{route('reservation.status',$reservation->id)}}" @if($reservation->status != 'pending' && $reservation->status != 'approved') disabled @endif>
                    <i class="fas fa-check"></i>
                  </button>
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
<!-- view -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header  bg-info">
        <h5 class="modal-title" id="statusModalLabel"><b>Date of visit : </b> <span id="date"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-md-6">
          <span class="text-muted small" id="created_at"></span><br>
          Name : <span id="name"></span><br>
          Phone : <small id="contact_number"></small> <br>
          Email : <small id="email"></small>
        </div>
        <div class="col-md-6">
          <small id="type"></small><br>
          Breed : <span id="breed"></span><br>
          Pet Name : <span id="petname"></span><br>
          <span>Status : </span> <span id="reservationStatus"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- status -->
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
        <form id="status-form" action="" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" id="status" value="">
          <button type="submit" class="btn" id="submit">Confirm</button>
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
<!-- Page specific script -->
<script>
  $(function() {
    $("#table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "order": [
        [0, "desc"]
      ]
    });
  });
  $('.statusModal').click(function() {
    const status = $(this).attr('data-status');
    const link = $(this).attr('data-link');
    $('#status-form').attr('action', link);
    $('#status').val(status);
    function changeClass(bg_class, btn_class) {
      $('#statusModal .modal-header').removeClass('bg-primary');
      $('#statusModal .modal-header').removeClass('bg-danger');
      $('#statusModal .modal-header').removeClass('bg-success');
      $('#status-form .btn').removeClass('btn-primary');
      $('#status-form .btn').removeClass('btn-danger');
      $('#status-form .btn').removeClass('btn-success');
      $('#statusModal .modal-header').addClass(bg_class);
      $('#status-form .btn').addClass(btn_class);
    }
    if (status == 'approved') {
      $('#statusModalText').text('Are you sure you want to approve this reservation?');
      changeClass('bg-primary', 'btn-primary');
    } else if (status == 'rejected') {
      $('#statusModalText').text('Are you sure you want to reject this reservation?');
      changeClass('bg-danger', 'btn-danger');
    } else if (status == 'completed') {
      $('#statusModalText').text('Are you sure this reservation is complete?');
      changeClass('bg-success', 'btn-success');
    }
  });
  $('.viewModal').click(function() {
    let reservation = $(this).attr('data-reservation');
    reservation = JSON.parse(reservation);
    const breed = $(this).attr('data-breed');
    const type = $(this).attr('data-type');
    console.log(reservation);
    $('#name').text(reservation.user.first_name + ' ' + reservation.user.last_name);
    $('#contact_number').text(reservation.user.contact_number);
    $('#email').text(reservation.user.email);
    $('#breed').text(breed);
    $('#petname').text(reservation.pet.name);
    $('#type').text(type);
    if (reservation.status == 'pending') {
      $('#reservationStatus').text(reservation.status).css('color', 'orange');
    } else if (reservation.status == 'approved' || reservation.status == 'completed') {
      $('#reservationStatus').text(reservation.status).css('color', 'green');
    } else if (reservation.status == 'rejected' || reservation.status == 'cancelled') {
      $('#reservationStatus').text(reservation.status).css('color', 'red');
    } else {
      $('#reservationStatus').text(reservation.status).css('color', 'black');
    }
    // $('#created_at').text(reservation.created_at);
    let created_at = new Date(reservation.created_at);
    $('#created_at').text(formatDateTime(created_at));
    let date = new Date(reservation.date);
    $('#date').text(formatDateTime(date));
    function formatDateTime(date) {
      var months = date.getMonth() + 1;
      months = months < 10 ? '0' + months : months;
      var days = date.getDate();
      days = days < 10 ? '0' + days : days;
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var seconds = date.getSeconds();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      hours = hours < 10 ? '0' + hours : hours;
      minutes = minutes < 10 ? '0' + minutes : minutes; // leading zero
      var strTime = hours + ':' + minutes + ' ' + ampm;
      let formattedDate = months + '/' + days + '/' + date.getFullYear() + ' ' + strTime;
      return formattedDate;
    }
  });
</script>
@endsection