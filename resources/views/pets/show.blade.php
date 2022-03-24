@extends('layouts.app')

@section('style')
<!-- carousel -->
<link rel="stylesheet" href="{{asset('css/carousel.css')}}">
<!-- style for description -->
<link rel="stylesheet" href="{{asset('css/blog.css')}}">
<style>
  p img {
    width: 100% !important;
  }
</style>
@endsection
@section('content')
<div id="myCarousel" class="carousel slide shadow" data-ride="carousel">
  <ol class="carousel-indicators">
    @foreach($pet->images as $image)
    <li data-target="#myCarousel" data-slide-to="{{++$loop->index-1}}" class="{{++$loop->index == 1 ? 'active':''}}"></li>
    @endforeach
  </ol>
  <div class="carousel-inner">
    @foreach($pet->images as $image)
    <div class="carousel-item {{++$loop->index == 1 ? 'active':''}} " style="  height:100vh;">
      <img src="{{asset('storage/images/pets/'.$image)}}" alt="{{$pet->name}}" style="object-fit:cover; height:100vh; ">
    </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-target="#myCarousel" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-target="#myCarousel" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <h3 class="pb-4 mb-4 border-bottom">
        <span class="font-italic">
          {{ $pet->breed->type->name }} - {{ $pet->breed->name }}
        </span>
        @if($pet->user_id)
        <span class="btn  btn-outline-info disabled  rounded-pill float-right">Reserved</span>
        @else
        <a href="{{route('reservation.create',$pet->slug)}}" class="btn custom-bg-color  rounded-pill float-right">Reserve this pet</a>
        @endif
      </h3>
      <div class="blog-post">
        @if($pet->status == 'available')
        <span class="badge badge-success float-right">{{ $pet->status }}</span>
        @else
        <span class="badge badge-danger float-right">{{ $pet->status }}</span>
        @endif
        <h2 class="blog-post-title"> {{ $pet->name }}</h2>
        <p class="blog-post-meta">Gender : <span class="custom-color text-capitalize">{{$pet->gender}}</span> </p>
        @if($pet->price)
        <span class="font-italic p-0">
          ₱ {{ $pet->price}}
        </span>
        @endif
        <hr>
        <p>{!! $pet->description !!} </p>
      </div>
      <nav class="blog-pagination">
        <a class="btn btn-outline-secondary" href="#" onclick="history.back()">Back</a>
      </nav>
    </div>
    <aside class="col-md-4 blog-sidebar">
      <div class="p-4 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <ul>
          <li>
            Age : <span class="custom-color">{{$pet->getAge()}}</span>
          </li>
          <li>
            Birthday : <span class="custom-color">{{ date('F d, Y', strtotime($pet->birthday))  }}</span>
          </li>
          <li>
            Weight : {{ $pet->weight }} <span class="custom-color">kg</span>
          </li>
          <li>
            Height : {{ $pet->height }} <span class="custom-color">cm</span>
          </li>
        </ul>
      </div>
      <div class="p-4">
        @if($pet->breed->type->pets->count()>1 || $pet->breed->pets->count() > 1)
        <h4 class="font-italic">Find more pets</h4>
        <ol class="list-unstyled mb-0">
          @foreach($pet->breed->type->breed as $breed)
          <li><a href="{{route('petBreed',$breed->slug)}}">{{$breed->name}}</a></li>
          @endforeach
          <hr>
          @foreach($pet->breed->type->pets as $p)
          @if($pet->id != $p->id)
          <li><a href="{{route('petDetails',$pet->slug)}}">{{$p->name}}</a></li>
          @endif
          @endforeach
        </ol>
        @endif
      </div>
    </aside>
  </div>
</div>
@endsection