@extends('layouts.app')

@section('style')
<style>
  .jumbotron {
    background-image: url("{{asset('images/Labrador_Grass.jpg')}}");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: white;
  }

  #about {
    background-image: url("{{asset('images/cat.jpg')}}");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    color: white;
  }
</style>
@endsection
@section('content')
<div class="jumbotron m-0" id="home">
  <div class="container">
    <h1 class="display-3" data-aos="fade-right">We care <br> <b>As you care</b></h1>
    <p data-aos="fade-right">Every Pet Needs A Good Owner</p>
    <p><a class="btn custom-bg-color " href="#about" role="button" data-aos="fade-up">Learn more &raquo;</a></p>
  </div>
</div>
<div class="container">
  @if(App\Model\Type::all()->count() > 0)
  <section id="pets" class="row justify-content-center">
    <div class="col-12">
      <h1 class="text-center text-success  pt-5">Our Pets</h1>
    </div>
    @foreach(App\Model\Type::all() as $type)
    <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="zoom-in">
      <a href="{{route('petType',$type->slug)}}">
        <div class="card custom-border  custom-bg-color  h-100">
          <img src="{{asset('storage/images/type/'.$type->image)}}" class="card-img-top" style="object-fit:cover;" height="250px" alt="{{$type->name}}">
          <div class="card-body text-center">
            <h1 class="text-capitalize">
              {{$type->name}}
            </h1>
          </div>
        </div>
      </a>
    </div>
    @endforeach
  </section>
  @endif

  @if(App\Model\Product::where('is_featured', 1)->count() > 0)
  <section id="products" class="row justify-content-center">
    <div class="col-12">
      <h1 class="text-center text-success  pt-5">Featured Products</h1>
    </div>
    @foreach(App\Model\Product::where('is_featured', 1)->take(3)->get() as $product)
    <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="fade-up">
      <div class="card">
        <a href="{{ route('product', $product->id) }}">
          <img src="{{ asset('storage/images/products/'.$product->image) }}" class="card-img-top" style="object-fit:cover;" height="250px" alt="{{$product->name}}">
        </a>
        <div class="card-body">
          <a href="{{ route('product', $product->id) }}">
            <h5 class="text-dark  text-truncate "> {{ $product->name }} </h5>
            <p class="text-muted small mb-0">&#8369; {{ $product->price }}</p>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </section>
  @endif

  @if(App\Model\Service::all()->count() > 0)
  <section id="services" class="row justify-content-center pt-5">
    <div class="col-12 text-center">
      <h1 class="text-center custom-color">Pet Services</h1>
    </div>
    @foreach(App\Model\Service::all() as $service)
    <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="fade-up">
      <div class="card custom-border h-100">
        <img src="{{asset('storage/images/service/'.$service->image)}}" class="card-img-top" style="object-fit:cover;" height="250px" alt="">
        <div class="card-body">
          <h5 class="card-title">
            <i class="fas fa-paw"></i>
            {{$service->service}}
          </h5>
          <p class="card-text text-truncate">{{$service->description}}</p>
        </div>
        <div class="card-footer">
          <a href="{{route('serviceDetails', $service->id)}}" class="btn btn-sm custom-bg-color">Read more</a>
        </div>
      </div>
    </div>
    @endforeach
    <div class="col-12 text-center py-5">
      <a href="{{route('appointment.create')}}" class="btn btn-lg custom-bg-color"> Book appointment now </a>
    </div>
  </section>
  @endif
</div>
<!-- ======= About Us Section ======= -->
<section id="about">
  <div class="container py-5">
    <div class="section-title pb-3" data-aos="fade-up">
      <h1 class="display-3">About Us</h1>
    </div>
    <div class="row content ">
      <div class="col-lg-6 p-3" data-aos="fade-up" data-aos-delay="300">
        <p>
        Premium Kennel Pet Store Management System is a web-based application system aimed to help a small home-based pet business Premium Kennel to expand and broaden their online presence by implementing the business online. We are the first to elevate a traditional pet store, by having a pet store management system that include better ways of selling a pet (our notable feature) and access to other services (e.g., grooming).
        </p>
      </div>
    </div>
  </div>
</section>
<!-- End About Us Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" data-aos="fade-up">
  <div class="container py-5 my-5">
    <div class="section-title text-center pb-5">
      <h1>Contact Us</h1>
    </div>
    <div class="row justify-content-md-center text-center">

      <div class="col-md-6 pb-4">
        <h2 class="font-weight-bold">
          Email
        </h2>
        <p> <i class="fas fa-envelope custom-color"></i> premuimkennel@gmail.com</p>
      </div>

      <div class="col-md-6  pb-4">
        <h2 class="font-weight-bold">
          Phone
        </h2>
        <p> <i class="fas fa-phone  custom-color"></i> +63 921 472 0591</p>
      </div>

      <div class="col-md-6  pb-4">
        <h2 class="font-weight-bold ">
          Location
        </h2>
        <p> <i class="fas fa-map-marker-alt custom-color"></i> 459 Villla Silangan, Calamba, 4027 Laguna</p>
      </div>

      <div class="col-md-6  pb-4">
        <h2 class="font-weight-bold">
          Working Hours
        </h2>
        <p> <i class="fas fa-clock custom-color"></i> 7:00 AM - 5:00 PM </p>
      </div>

    </div>
  </div>
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1933.8689731629743!2d121.16559305790793!3d14.210116497653816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63d4928bb879%3A0xce3e9ca02e88aa5d!2s459%20Villla%20Silangan%2C%20Calamba%2C%204027%20Laguna!5e0!3m2!1sen!2sph!4v1643646068942!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>
<section id="footer">
  <div class="container pt-5">
    <div class="copyright">
      <strong>Copyright &copy; {{Carbon\carbon::now()->year}}
        <a href="#" class="custom-color" target="_blank">PremiumKennel</a>
      </strong>
      All rights reserved.
    </div>
  </div>
</section>
@endsection