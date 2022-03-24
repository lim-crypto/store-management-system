@extends('layouts.app')

@section('style')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8" data-aos="zoom-in">
            <div class="card">
                <h1 class="card-header text-success">Appointment Form</h1>
                <div class="card-body">
                    <form action="{{route('appointment.store')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">First name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                    <div class="invalid-feedback">
                                        Please enter your first name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Last name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control  {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name}}" required>
                                    <div class="invalid-feedback">
                                        Please enter your last name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" value="{{  auth()->user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Contact number</label> <span class="text-danger">*</span>
                                    <input type="number" class="form-control  {{ $errors->has('contact_number') ? ' is-invalid' : '' }}" name="contact_number" placeholder="09xxxxxxxxx" min="09000000000" max="09999999999" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>

                                    <div class="invalid-feedback">
                                        Please enter your contact number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Date of visit:</label> <span class="text-danger">*</span>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input id="date" type="text" name="date" class="form-control datetimepicker-input {{ $errors->has('date') ? ' is-invalid' : '' }}" data-target="#reservationdate" data-toggle="datetimepicker" required autocomplete="off" value="{{old('date')}}">
                                        <span class="invalid-feedback" role="alert">
                                            Date is required
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="time">Time:</label> <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                        </div>
                                        <select class="form-control  {{ $errors->has('time') ? ' is-invalid' : '' }}" name="time" id="time" required {{old('time') ? '':'disabled'}}>
                                            <option disabled selected value="">Select time</option>
                                            <option {{old('time') == "7:00 AM" ? 'selected' : ''}} value="7:00 AM">7:00 AM</option>
                                            <option {{old('time') == "8:00 AM" ? 'selected' : ''}} value="8:00 AM">8:00 AM</option>
                                            <option {{old('time') == "9:00 AM" ? 'selected' : ''}} value="9:00 AM">9:00 AM</option>
                                            <option {{old('time') == "10:00 AM" ? 'selected' : ''}} value="10:00 AM">10:00 AM</option>
                                            <option {{old('time') == "11:00 AM" ? 'selected' : ''}} value="11:00 AM">11:00 AM</option>
                                            <option {{old('time') == "12:00 PM" ? 'selected' : ''}} value="12:00 PM">12:00 PM</option>
                                            <option {{old('time') == "1:00 PM" ? 'selected' : ''}} value="1:00 PM">1:00 PM</option>
                                            <option {{old('time') == "2:00 PM" ? 'selected' : ''}} value="2:00 PM">2:00 PM</option>
                                            <option {{old('time') == "3:00 PM" ? 'selected' : ''}} value="3:00 PM">3:00 PM</option>
                                            <option {{old('time') == "4:00 PM" ? 'selected' : ''}} value="4:00 PM">4:00 PM</option>
                                            <option {{old('time') == "5:00 PM" ? 'selected' : ''}} value="5:00 PM">5:00 PM</option>
                                        </select>
                                        <span class="invalid-feedback" role="alert">
                                            Time is required
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="service">Service</label> <span class="text-danger">*</span>
                                    <select id="service" class="form-control" name="service" required>
                                        <option selected disabled value="">Select Service</option>
                                        @foreach ($services as $service)
                                        <option {{old('service') == $service->service ? 'selected' : ''  }} value="{{$service->service}}">{{$service->service}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select your service.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="offer">Offer</label> <span class="text-danger">*</span>
                                    <select class="form-control" name="offer" id="offer" required {{old('time') ? '':'disabled'}}>
                                        <option selected disabled data-service="" value="">Select offer</option>
                                        @foreach($services as $service)
                                        @foreach($service->offer as $offer)
                                        <option data-service="{{$service->service}}" {{old('offer') == $offer->offer .' -  ₱'. $offer->price ? 'selected' : ''  }} value="{{$offer->offer .' -  ₱'. $offer->price}}">{{$offer->offer }}&nbsp;&nbsp;&nbsp; &#8369; &nbsp;{{$offer->price }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select your offer.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn custom-bg-color float-right">Book now</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- InputMask -->
<script src="{{ asset('Adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('Adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>

    //  var disabledDates = {!!$disabledDates!!};
     var disabledDates = {!!$disabledDates!!};
    // var dates = {!!$dates!!};
    var dates = {!!$dates!!};

    $(function() {
        $('#reservationdate').datetimepicker({
            minDate: new Date(),
            format: 'L',
            disabledDates: disabledDates,
        });
        $('#date').blur(function() {
            var date = $(this).val();
            if (date == moment().format('L')) {
                $(this).val(''); // if today is selected, clear the field
            }
            var date_format = moment(date, 'MM-DD-YYYY').format('YYYY-MM-DD');
            $('#time').removeAttr('disabled');
            $('div.form-group').find('#time').find('option').each(function() {
                if ($(this).val() != '') { // if not empty || <option disabled value="">Select time</option>
                    var time = $(this).val();
                    var time_format = moment(time, 'hh:mm A').format('HH:mm:ss');
                    if (dates.includes(date_format + ' ' + time_format)) {
                        $(this).attr('disabled', 'disabled').text(time + ' not available');
                        $('#time').val('');
                    } else {
                        $(this).removeAttr('disabled').text(time);
                    }
                }
            });
        });

        function getOffer() {
            var service = $('#service').val().toLowerCase();
            $('div.form-group').find('#offer').find('option').each(function() {
                if ($(this).attr('data-service').toLowerCase() == service) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        $('#service').change(function() {
            $('#offer').removeAttr('disabled').val('');
            getOffer();
        });
        getOffer();
    });
</script>
@endsection