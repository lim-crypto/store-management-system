@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 text-center py-5">
            <h1 class="text-center">{{$service->service}}</h1>
            <p class="text-muted">{{$service->description}}</p>
        </div>
        @foreach($service->offer as $offer)
        <div class="col-md-4 p-2">
            <div class="card custom-border h-100">
                <div class="card-body text-center text-lg">
                    <div class="card-text">{{$offer->offer}}</div>
                    <div class="card-text h1 custom-color">&#8369; {{$offer->price}}</div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12 text-center py-5">
            <a href="{{route('appointment.create')}}" class="btn btn-lg custom-bg-color"> Book appointment now </a>
        </div>
    </div>
</div>
@endsection