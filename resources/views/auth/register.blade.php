@extends('layouts.app')

@section('style')
<style>
    .container .title {
        font-size: 25px;
        font-weight: 500;
        position: relative;
    }

    .container .title::before {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 25px;
        border-radius: 5px;
        background: linear-gradient(to right, #053718, #006022, #008d28, #00bb26, #2feb12);
    }
</style>
@endsection

@section('content')
<div class="container py-4" data-aos="zoom-out">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="title">{{ __('Register') }}</h3>
                    <hr>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="font-weight-normal">{{ __('First Name') }}</label><span class="text-danger">*</span>
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                    <span class="invalid-feedback" role="alert">
                                        @if($errors->has('first_name'))
                                        {{ $errors->first('first_name') }}
                                        @else
                                        First Name is required
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="font-weight-normal">{{ __('Last Name') }}</label><span class="text-danger">*</span>
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                    <span class="invalid-feedback" role="alert">
                                        @if($errors->has('last_name'))
                                        {{ $errors->first('last_name') }}
                                        @else
                                        Last Name is required
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number" class="font-weight-normal">{{ __('Contact Number') }}</label><span class="text-danger">*</span>
                                    <input id="contact_number" type="number"  placeholder="09xxxxxxxxx" min="09000000000" max="09999999999" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number">
                                    <span class="invalid-feedback" role="alert">
                                        @if($errors->has('contact_number'))
                                        {{ $errors->first('contact_number') }}
                                        @else
                                        Please enter a valid Contact number e.g 09xxxxxxxxx
                                        @endif
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-normal">{{ __('E-Mail Address') }}</label><span class="text-danger">*</span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+">
                                    <span class="invalid-feedback" role="alert">
                                        @if($errors->has('email'))
                                        {{ $errors->first('email') }}
                                        @else
                                        Please enter a valid email address
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="font-weight-normal">{{ __('Password') }}</label><span class="text-danger">*</span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">
                                    <span class="invalid-feedback" role="alert">
                                        @if($errors->has('password'))
                                        {{ $errors->first('password') }}
                                        @else
                                        Password must contain at least 8 characters, at least 1 number and 1 uppercase letter
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password" class="font-weight-normal">{{ __('Confirm Password') }}</label><span class="text-danger">*</span>
                                    <input id="confirm_password" type="password" class="form-control" name="password_confirmation" required autocomplete="confirm_password">
                                    <span class="invalid-feedback" role="alert">
                                        Password must match
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4 mb-0">
                        <button type="submit" class="btn custom-bg-color my-4 register" style="width: 100%;">{{ __('Register') }}</button>
                        <br>

                        <p class="text-center mb-2"> Already have an account? Login in <a href="login">here!</a></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- jquery validation -->
<script src="{{ asset('Adminlte/plugins/jquery-validation/jquery-validation.js') }}"></script>

<script src="{{asset('js/jquery-validation.js')}}"></script>
<script>
    $('form').submit(function() {
        $('button[type=submit]').attr('disabled', true);
    });
    $('input').on('keydown', function() {
        $('button[type=submit]').removeAttr('disabled');
    });

    (function() {
        // validate password
        $('#password').on('keyup', function() {
            var pass = $(this).val();
            var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (regex.test(pass)) {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
                //password must match
                comparePassword();
            } else {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').show();
            }
        });
        // password must match
        $('#confirm_password').on('keyup', function() {
            var confirm_pass = $('#confirm_password').val();
            var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (regex.test(confirm_pass)) {
                comparePassword();
            }
        });
        // password must match
        function comparePassword() {
            var pass = $('#password').val();
            var confirm_pass = $('#confirm_password').val();
            if (confirm_pass != '' && pass != '') {
                if (pass == confirm_pass) {
                    $('#confirm_password').removeClass('is-invalid');
                    $('#confirm_password').addClass('is-valid');
                    $('#confirm_password').siblings('.invalid-feedback').hide();
                    $('.register').attr('disabled', false);
                } else {
                    $('#confirm_password').removeClass('is-valid');
                    $('#confirm_password').addClass('is-invalid');
                    $('#confirm_password').siblings('.invalid-feedback').show();
                    $('.register').attr('disabled', true);
                }
            }
        }
    }());
</script>
@endsection