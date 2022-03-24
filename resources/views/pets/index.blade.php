@extends('layouts.app')
@section('style')
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endsection
@section('content')
<div class="container py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            @if($pets->count() > 0)
            <h1 class="text-center py-5">
                @if(session()->has('pet'))
                {{session()->get('pet')}}
                {{session()->forget('pet')}}
                @else
                Pets
                @endif
                Collections
            </h1>
            @else
            <h1 class="text-center text-muted py-5">
                No
                @if(session()->has('pet'))
                {{session()->get('pet')}}
                {{session()->forget('pet')}}
                @else
                Pets
                @endif
                Available
            </h1>
            @endif
        </div>
        @foreach($pets as $pet)
        <div class="col-md-3 mb-5">
            <div class="card">
                @foreach($pet->images as $image)
                <a href="{{asset('storage/images/pets/'.$image)}}" data-toggle="lightbox{{$pet->id}}" data-gallery="gallery{{$pet->id}}">
                    <img src="{{asset('storage/images/pets/'.$image)}}" class="card-img-top {{++$loop->index == 1 ? '':'d-none'}} " alt=" {{$pet->name}}" style="height:250px; object-fit:cover;">
                </a>
                @endforeach
                <div class="card-body">
                    <h5 class="card-title">{{ $pet->breed->name }}</h5>
                    <p class="card-text">{{ $pet->breed->type->name }}</p>
                    <p class="card-text">{{ $pet->name }}</p>
                    <a href="{{route('petDetails',$pet->slug)}}" class="btn custom-bg-color rounded-pill">View Pet Details</a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12 d-flex justify-content-center">
            {{$pets->links()}}
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Ekko Lightbox -->
<script src="{{ asset('Adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
@foreach($pets as $pet)
<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox{{$pet->id}}"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    })
</script>
@endforeach
@endsection