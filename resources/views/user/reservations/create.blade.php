@extends('layouts.app')

@section('style')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/select2/css/select2.min.css')}}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/daterangepicker/daterangepicker.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header text-success">Reservation Form</h1>

                <div class="card-body">
                    <form action="{{route('reservation.store')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <input type="hidden" value="{{$pet->id}}" name="pet_id" required>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">First name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control  {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                    <div class="invalid-feedback">
                                        Please enter your first name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Last name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name}}" required>
                                    <div class="invalid-feedback">
                                        Please enter your last name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" value="{{auth()->user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Contact number</label> <span class="text-danger">*</span>
                                    <input type="number" class="form-control  {{ $errors->has('contact_number') ? ' is-invalid' : '' }} " name="contact_number" placeholder="09xxxxxxxxx" min="09000000000" max="09999999999" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>
                                    <div class="invalid-feedback">
                                        Please enter your contact number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Date -->
                                <div class="form-group">
                                    <label>Date of visit:</label> <span class="text-info small">please pick a date within 7 days from now</span>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" name="date" id="date" class="form-control datetimepicker-input {{ $errors->has('date') ? ' is-invalid' : '' }}" data-target="#reservationdate" data-toggle="datetimepicker" required autocomplete="off" value="{{old('date')}}">
                                        <span class="invalid-feedback" role="alert">
                                            Date is required
                                        </span>

                                    </div>
                                </div>
                                <span class="text-info small float-right mb-1"><i>note: your reservation will expire after 7days from now if not process</i></span>
                            </div>
                            <!-- time -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="time">Time:</label>
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
                        </div>
                        <button type="submit" class="btn custom-bg-color float-right">Submit</button>
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
    $(function() {
        //Date picker
        $('#reservationdate').datetimepicker({
            minDate: new Date(new Date().getTime() + (1 * 24 * 60 * 60 * 1000)),
            maxDate: new Date(new Date().getTime() + (7 * 24 * 60 * 60 * 1000)),
            format: 'L'
        });

    });

    var disabledDates = {!!$disabledDates!!};
    $('#reservationdate').datetimepicker({
        minDate: new Date(),
        format: 'L',
        disabledDates: disabledDates,
    });

    var dates = {!!$dates!!};
    $('#date').blur(function() {
        var date = $(this).val();
        if (date == moment().format('L')) {
            $(this).val(''); // if today is selected, clear the field
        }
        var date_format = moment(date, 'MM-DD-YYYY').format('YYYY-MM-DD');
        $('#time').removeAttr('disabled');
        $('div.form-group').find('#time').find('option').each(function() {

            if ($(this).val() != '') {
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
</script>
@endsection