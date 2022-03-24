<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('admin.home')}}" class="brand-link">
    <img src="{{asset('images/kennel-logo.png')}}" alt="Premium kennel Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">Premium Kennel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{route('home')}}" class="nav-link">
            <i class="fas fa-home nav-icon"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.home')}}" class="nav-link">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('orders')}}" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>
              Orders
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('reservations')}}" class="nav-link">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>
              Reservation
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('appointments')}}" class="nav-link">
            <i class="fas fa-calendar-check nav-icon"></i>
            <p>
              Appointment
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('services.index')}}" class="nav-link">
            <i class="fab fa-buffer nav-icon"></i>
            <p>
              Services
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('pets.index')}}" class="nav-link">
            <i class="fas fa-paw nav-icon"></i>
            <p>
              Pets
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('breed.index')}}" class="nav-link">
            <i class="fas fa-border-all nav-icon"></i>
            <p>
              Breed
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('type.index')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Type
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('products.index')}}" class="nav-link">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>
              Products
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('category.index')}}" class="nav-link">
            <i class="fas fa-list nav-icon"></i>

            <p>
              Category
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('users.index')}}" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>