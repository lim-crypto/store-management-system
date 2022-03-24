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
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="title">{{ __('Reset Password') }}</h3>
                    <hr>
                </div>
                <div class="card-body pt-0">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}"  class="needs-validation" novalidate="">
                        @csrf

                        <label for="email" class="font-weight-normal">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn custom-bg-color  mt-3" style="width: 100%;"> {{ __('Send Password Reset Link') }}</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('login') }}"  class="btn btn-default mt-3 " style="width: 100%;" >{{ __('Back to Login') }}</a>
                            </div>
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