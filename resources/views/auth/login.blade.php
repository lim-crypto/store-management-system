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
        <div class="col-lg-4 col-md-6 col-10">
            <div class="card">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="title">{{ __('Login') }}</h3>
                    <hr>
                </div>


                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="font-weight-normal">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span class="invalid-feedback" role="alert">
                                @if($errors->has('email'))
                                {{ $errors->first('email') }}
                                @else
                                {{ __('Please enter a valid email address') }}
                                @endif
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-normal">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <span class="invalid-feedback" role="alert">
                                Password is required
                            </span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label for="remember" class="font-weight-normal">
                                {{ __('Remember Me') }}
                            </label>

                        </div>
                        <button type="submit" class="btn custom-bg-color" style="width: 100%;">{{ __('Login') }}</button>
                        <br>
                        <div class="text-center mt-3 ">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link pb-0" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                            <p class="text-center mb-0"> Doesn't have an account yet? Register <a href="register">here!</a></p>
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
</script>
@endsection