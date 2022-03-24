@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate="">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">{{ __('Confirm Password') }}</label>
                            <input id="confirm_password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn custom-bg-color">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
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