<nav class="navbar navbar-expand-md navbar-white navbar-light sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{asset('images/kennel-logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a href="{{route('home')}}#home" class="nav-link">Home</a>
                </li>
                @if(App\Model\Category::count() > 1)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Shop
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(App\Model\Category::all() as $category)
                        <li><a class="dropdown-item" href="{{route('productByCategory' , $category->id)}}">{{$category->name}}</a></li>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a href="{{route('products')}}" class="dropdown-item"> All Products</a>
                    </ul>
                </li>
                @else
                <li class="nav-item ">
                    <a href="{{route('products')}}" class="nav-link">Shop</a>
                </li>
                @endif
                @if(App\Model\Type::all()->count() > 1)
                <li class="nav-item dropdown d-flex flex-nowrap">
                    <a href="{{route('home')}}#pets" class="nav-link pr-0">Pets</a>
                    <a class="nav-link dropdown-toggle pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre></a>
                    <ul class="dropdown-menu">
                        @foreach(App\Model\Type::all() as $type )
                        <a class="dropdown-item" href="{{route('petType',$type->slug)}}">
                            {{$type->name}}
                        </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a href="{{route('pets')}}" class="dropdown-item"> All Pets</a>
                    </ul>
                </li>
                @else
                <li class="nav-item ">
                    <a href="{{route('pets')}}" class="nav-link">Pets</a>
                </li>
                @endif
                <li class="nav-item ">
                    <a href="{{route('home')}}#services" class="nav-link">Services</a>
                </li>
                <li class="nav-item ">
                    <a href="{{route('home')}}#about" class="nav-link">About</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="btn custom-bg-color border rounded-pill px-4 d-none d-md-block" href="{{ route('register') }}">{{ __('Register') }}</a>
                    <a class="nav-link d-block d-md-none" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                @if(Auth::user()->is_admin)
                <li class="nav-item ">
                    <a href="{{ route('admin.home') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link " href="{{route('carts.index')}}">
                        <i class="fas fa-shopping-cart  ">
                            @if( Cart::session(auth()->id())->getContent()->count() )
                            <span class="badge badge-danger navbar-badge">{{ Cart::session(auth()->id())->getContent()->count() }}</span>
                            @endif
                        </i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->getName() }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('profile')}}">Profile</a>
                        <a class="dropdown-item" href="{{route('user.reservations')}}">Reservation</a>
                        <a class="dropdown-item" href="{{route('user.appointments')}}">Appointment</a>
                        <a class="dropdown-item" href="{{route('orders.index')}}">Orders</a>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>