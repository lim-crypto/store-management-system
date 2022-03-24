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
          <h1 class="m-0">Appointments</h1>
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
            <a class="dropdown-item" href="{{route('appointmentByStatus','pending')}}">Pending</a>
            <a class="dropdown-item" href="{{route('appointmentByStatus','approved')}}">Approved</a>
            <a class="dropdown-item" href="{{route('appointmentByStatus','cancelled')}}">Cancelled</a>
            <a class="dropdown-item" href="{{route('appointmentByStatus','rejected')}}">Rejected</a>
            <a class="dropdown-item" href="{{route('appointmentByStatus','completed')}}">Completed</a>
            <a class="dropdown-item" href="{{route('appointments')}}">All</a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table id="table" class="table table-hover table-striped">
            <thead>
              <tr>
                <th>created at</th>
                <th>Name</th>
                <th>Service</th>
                <th>Date of visit</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($appointments as $appointment)
              <tr>
                <td>{{date('m/d/Y H:i',strtotime($appointment->created_at))}}
                <span class="text-xs text-muted"> {{$appointment->created_at->diffForHumans() }} </span>
                </td>
                <td>{{$appointment->user->getName()}}</td>
                <td class="text-truncate" style="max-width: 150px;" >{{$appointment->service}} - {{$appointment->offer}}</td>
                <td>{{date('M d, Y - gA', strtotime($appointment->date))}}</td>
                <td>
                  @if($appointment->status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                  @elseif($appointment->status == 'approved')
                  <span class="badge badge-success">Approved</span>
                  @elseif($appointment->status == 'rejected')
                  <span class="badge badge-danger">Rejected</span>
                  @elseif($appointment->status == 'cancelled')
                  <span class="badge badge-danger">Cancelled</span>
                  @elseif($appointment->status == 'completed')
                  <span class="badge badge-success">Completed</span>
                  @endif
                </td>
                <td>
                  <button title="view" type="button" class="btn btn-info btn-sm viewModal" data-toggle="modal" data-target="#viewModal" data-appointment="{{$appointment}}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button title="approve" type="button" class="btn btn-primary btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="approved" data-link="{{route('appointment.status',$appointment->id)}}" @if($appointment->status != 'pending' ) disabled @endif>
                    <i class="fas fa-thumbs-up"></i>
                  </button>
                  <button title="reject" type="button" class="btn btn-danger btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="rejected" data-link="{{route('appointment.status',$appointment->id)}}" @if($appointment->status != 'pending') disabled @endif>
                    <i class="fas fa-thumbs-down"></i>
                  </button>
                  <button title="complete" type="button" class="btn btn-success btn-sm statusModal" data-toggle="modal" data-target="#statusModal" data-status="completed" data-link="{{route('appointment.status',$appointment->id)}}" @if($appointment->status != 'pending' && $appointment->status != 'approved') disabled @endif>
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
              <button type="sumbit" class="btn btn-primary" id="submit">Confirm</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
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
              <br>
              <b id="service"></b><br>
              <span id="offer"></span><br>
              <span>Status : </span> <span id="appointmentStatus"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function() {
    $("#table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "order": [[ 0, "desc" ]]
    });
  });
  $('.statusModal').click(function() {
    const status = $(this).attr('data-status');
    const link = $(this).attr('data-link');
    $('#status').val(status);
    $('#status-form').attr('action', link);

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
      $('#statusModalText').text('Are you sure you want to approve this  appointment?');
      changeClass('bg-primary', 'btn-primary');
    } else if (status == 'rejected') {
      $('#statusModalText').text('Are you sure you want to reject this  appointment?');
      changeClass('bg-danger', 'btn-danger');
    } else if (status == 'completed') {
      $('#statusModalText').text('Are you sure this appointment is complete?');

      changeClass('bg-success', 'btn-success');
    }
  });
  $('#status-form').submit(function() {
    $('#submit').attr('disabled', true);
  });

  $('.viewModal').click(function() {
    let appointment = $(this).attr('data-appointment');
    appointment = JSON.parse(appointment);
    console.log(appointment);
    $('#name').text(appointment.user.first_name + ' ' + appointment.user.last_name);
    $('#contact_number').text(appointment.user.contact_number);
    $('#email').text(appointment.user.email);
    $('#service').text(appointment.service);
    $('#offer').text(appointment.offer);
    if (appointment.status == 'pending') {
      $('#appointmentStatus').text(appointment.status).css('color', 'orange');
    } else if (appointment.status == 'approved' || appointment.status == 'completed') {
      $('#appointmentStatus').text(appointment.status).css('color', 'green');
    } else if (appointment.status == 'rejected' || appointment.status == 'cancelled') {
      $('#appointmentStatus').text(appointment.status).css('color', 'red');
    } else {
      $('#appointmentStatus').text(appointment.status).css('color', 'black');
    }

    // $('#created_at').text(appointment.created_at);
    let created_at = new Date(appointment.created_at);
    $('#created_at').text(formatDateTime(created_at));
    let date = new Date(appointment.date);
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