<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('admin.layouts.head')
  @include('admin.layouts.script')
  <!-- fullCalendar -->
  <script src="{{asset('Adminlte/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('Adminlte/plugins/fullcalendar/main.min.js')}}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><a href="{{route('admin.home')}}">Dashboard</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$reservation}}</h3>
                  <p>Reservations</p>
                </div>
                <div class="icon">
                  <i class="fas fa-paw"></i>
                </div>
                <a href="{{route('reservations')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$appointment}}</h3>
                  <p>Appointments</p>
                </div>
                <div class="icon">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{route('appointments')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-secondary">
                <div class="inner">
                  <h3>{{$orders}}</h3>
                  <p>Orders</p>
                </div>
                <div class="icon">
                  <i class="nav-icon fas fa-cash-register"></i>
                </div>
                <a href="{{route('orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$users}}</h3>
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
              <div class="card card-outline card-primary h-100">
                <div class="card-header">
                  <h1 class="card-title">
                    Latest Reservations
                  </h1>
                </div>
                <div class="card-body">
                  @forelse($latestReservations as $reservation)
                  <span>{{$reservation->user->getName()}}</span>
                  <!-- view -->
                  <a title="view" href="#" class="viewModal text-body" data-toggle="modal" data-target="#viewModal" data-for="reservation" data-breed="{{$reservation->pet->breed->name}}" data-type="{{$reservation->pet->type->name}}" data-reservation="{{$reservation}}" data-link="{{route('reservation.status',$reservation->id)}}">
                    <span class="text-muted small">{{ $reservation->created_at->diffForHumans()}}</span> <br>
                    <span>{{$reservation->pet->breed->name}}</span>
                    <span>{{$reservation->pet->name}}</span>
                    <span>{{$reservation->pet->name}}</span>
                    <p class="card-text mb-2"> {{date('m/d/Y h a',strtotime($reservation->date))}}
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
                      <span class="badge badge-success">Completed</span>
                      @endif
                    </p>
                  </a>
                  <hr class="mb-2">
                  @empty
                  <p class="card-text">No Reservations</p>
                  @endforelse
                </div>
                <div class="card-footer">
                  <a href="{{route('reservations')}}" class="btn btn-primary">View All</a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
              <div class="card card-outline card-success h-100">
                <div class="card-header">
                  <h1 class="card-title">
                    Latest Appointment
                  </h1>
                </div>
                <div class="card-body">
                  @forelse($latestAppointments as $appointment)
                  <span>{{$appointment->user->getName()}}</span>
                  <a title="view" href="#" class="viewModal text-body" data-toggle="modal" data-target="#viewModal" data-for="appointment" data-appointment="{{$appointment}}" data-link="{{route('appointment.status',$appointment->id)}}">
                    <span class="text-muted small">{{ $appointment->created_at->diffForHumans()}}</span><br>
                    <span>{{$appointment->service}}</span>
                    <p class="card-text mb-2"> {{date('m/d/Y h a',strtotime($appointment->date))}}
                      @if($appointment->status == 'pending')
                      <span class="badge badge-warning">Pending</span>
                      @elseif($appointment->status == 'approved')
                      <span class="badge badge-success">Approved</span>
                      @elseif($appointment->status == 'rejected')
                      <span class="badge badge-danger">Rejected</span>
                      @elseif($appointment->status == 'cancelled')
                      <span class="badge badge-danger">Cancelled</span>
                      @elseif($appointment->status == 'expired')
                      <span class="badge badge-danger">Expired</span>
                      @else
                      <span class="badge badge-success">Completed</span>
                      @endif
                    </p>
                  </a>
                  <hr class="mb-2">
                  @empty
                  <p class="card-text">No Appointments</p>
                  @endforelse
                </div>
                <div class="card-footer">
                  <a class="btn btn-success" href="{{route('appointments')}}">View All</a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 ">
              <div class="card card-outline card-warning">
                <div class="card-header">
                  <h1 class="card-title">
                    Latest Orders
                  </h1>
                </div>
                <div class="card-body">
                  <table id="orders-table" class="table table-sm table-hover table-head-fixed">
                    <thead>
                      <tr>
                        <th>Placed order</th>
                        <th>Order ID</th>
                        <th>Order Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach( $latestOrders as $order)
                      <tr>
                        <td>{{$order->created_at->format('m/d/Y h:i:s')}}
                          <span class="text-xs text-muted"> {{ $order->created_at->diffForHumans() }} </span>
                        </td>
                        <td> <a href="{{ route('order', $order->id) }}"> {{$order->order_id}} </a> </td>
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
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-4">
              <div class="card card-outline card-secondary">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
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
                <div class="col-md-6" id="details">
                </div>

              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- approved -->
                <button title="approve" type="button" class="btn btn-info  statusModal ml-4" data-toggle="modal" data-target="#statusModal" data-status="approved">
                  <i class="fas fa-thumbs-up"></i>
                </button>
                <!-- rejected -->
                <button title="reject" type="button" class="btn btn-danger statusModal ml-4" data-toggle="modal" data-target="#statusModal" data-status="rejected">
                  <i class="fas fa-thumbs-down"></i>
                </button>
                <!-- completed -->
                <button title="complete" type="button" class="btn btn-success statusModal ml-4" data-toggle="modal" data-target="#statusModal" data-status="completed">
                  <i class="fas fa-check"></i>
                </button>

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
      </div>
    </div>
    @include('admin.layouts.footer')
  </div>
  <script>
    $('.statusModal').click(function() {
      const status = $(this).attr('data-status');
      const a_or_r = $(this).attr('data-for'); // appointment or reservation
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
        $('#statusModalText').text(`Are you sure you want to approve this ${a_or_r}?`);
        changeClass('bg-primary', 'btn-primary');
      } else if (status == 'rejected') {
        $('#statusModalText').text(`Are you sure you want to reject this ${a_or_r}?`);
        changeClass('bg-danger', 'btn-danger');
      } else if (status == 'completed') {
        $('#statusModalText').text(`Are you sure this ${a_or_r} is complete?`);
        changeClass('bg-success', 'btn-success');
      }
    });
    $('#status-form').submit(function() {
      $('#submit').attr('disabled', true);
    });
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
    $('.viewModal').click(function() {
      const a_or_r = $(this).attr('data-for'); // appointment or reservation
      let details;
      $('#details').html('');
      if (a_or_r == 'reservation') {
        details = $(this).attr('data-reservation');
        details = JSON.parse(details);
        const breed = $(this).attr('data-breed');
        const type = $(this).attr('data-type');
        $('<small></small>').text(type).append('<br>').appendTo('#details');
        $('<span>Breed : </span>').appendTo('#details');
        $('<span></span>').text(breed).append('<br>').appendTo('#details');
        $('<span>Pet Name : </span>').appendTo('#details');
        $('<span></span>').text(details.pet.name).append('<br>').appendTo('#details');
      } else {
        details = $(this).attr('data-appointment');
        details = JSON.parse(details);
        $('<br>').appendTo('#details');
        $('<span></span>').text(details.service).append('<br>').appendTo('#details');
        $('<span></span>').text(details.offer).append('<br>').appendTo('#details');
      }
      let created_at = new Date(details.created_at);
      $('#created_at').text(formatDateTime(created_at));
      let date = new Date(details.date);
      $('#date').text(formatDateTime(date));
      $('#name').text(details.user.first_name + ' ' + details.user.last_name);
      $('#contact_number').text(details.user.contact_number);
      $('#email').text(details.user.email);
      if (details.status == 'pending') {
        $('<span>Status : </span>').appendTo('#details');
        $('<span></span>').text(details.status).addClass('badge badge-warning').appendTo('#details');
      } else if (details.status == 'approved' || details.status == 'completed') {
        $('<span>Status : </span>').appendTo('#details');
        $('<span></span>').text(details.status).addClass('badge badge-success').appendTo('#details');
      } else if (details.status == 'rejected') {
        $('<span>Status : </span>').appendTo('#details');
        $('<span></span>').text(details.status).addClass('badge badge-danger').appendTo('#details');
      } else if (details.status == 'cancelled') {
        $('<span>Status : </span>').appendTo('#details');
        $('<span></span>').text(details.status).addClass('badge badge-danger').appendTo('#details');
      } else if (details.status == 'completed') {
        $('<span>Status : </span>').appendTo('#details');
        $('<span></span>').text(details.status).addClass('badge badge-success').appendTo('#details');
      }
      $('#viewModal .modal-footer button').each(function() {
        if ($(this).attr('data-status') == 'approved' || $(this).attr('data-status') == 'rejected') {
          if (details.status != 'pending') {
            $(this).attr('disabled', true);
          } else {
            $(this).attr('disabled', false);
          }
        } else if ($(this).attr('data-status') == 'completed') {
          if (details.status != 'pending' && details.status != 'approved') {
            $(this).attr('disabled', true);
          } else {
            $(this).attr('disabled', false);
          }
        }
      });
      const link = $(this).attr('data-link');
      $('#status-form').attr('action', link);
    });
  </script>
</body>

</html>