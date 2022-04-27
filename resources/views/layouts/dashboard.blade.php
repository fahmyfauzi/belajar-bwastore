<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>@yield('title')</title>
  @stack('prepend-style')
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link href="/style/main.css" rel="stylesheet" />
  @stack('addon-style')
</head>

<body>
  <div class="page-dashboard">
    <div class="d-flex" id="wrapper" data-aos="fade-right">
      <!-- sidebar -->
      <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-center">
          <img src="/images/dashboard-store.svg" alt="" class="my-4" />
          <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}"
              class="list-group-item list-group-action {{ (request()->is('dashboard')) ? 'active' : ''  }}"> Dashboard
            </a>
            <a href="{{ route('dashboard-products') }}"
              class="list-group-item list-group-action {{ (request()->is('dashboard/products*')) ? 'active' : ''  }}">
              My
              Product </a>
            <a href="{{ route('dashboard-transactions') }}"
              class="list-group-item list-group-action {{ (request()->is('dashboard/transactions*')) ? 'active' : ''  }}">
              Transaction </a>
            <a href="{{ route('dashboard-settings-store') }}"
              class="list-group-item list-group-action {{ (request()->is('dashboard/settings')) ? 'active' : ''  }}">
              Store Setting
            </a>
            <a href="{{ route('dashboard-settings-account') }}"
              class="list-group-item list-group-action {{ (request()->is('dashboard/account')) ? 'active' : ''  }}"> My
              Account
            </a>
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-action"> Logout </a>
          </div>
        </div>
      </div>
      <!-- page content -->
      <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
          <div class="container-fluid">
            <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">&laquo;Menu</button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Desktop menu -->
              <ul class="navbar-nav d-none d-lg-flex ml-auto">
                <li class="nav-item dropdown">
                  <a href="" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <img src="/images/icon-user.png" alt="" class="rounded-circle m-2 profile-picture" />
                    Hi, {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu">
                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                    <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item">Setting</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                    @php
                    $carts = \App\Cart::where('users_id',Auth::user()->id)->count();
                    @endphp
                    @if($carts > 0)
                    <img src="/images/icon-cart-filled.svg" alt="" />
                    <div class="card-badge">{{ $carts }}</div>
                    @else
                    <img src="/images/icon-cart-empty.svg" alt="" />
                    @endif
                  </a>
                </li>
              </ul>

              <!-- Phone menu -->
              <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                  <a href="#" class="nav-link">Hi, {{ Auth::user()->name }}</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cart') }}" class="nav-link d-inline-block">Cart</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <!-- section content -->
        @yield('content')


      </div>
    </div>
  </div>
  @stack('prepend-script')
  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.slim.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <script>
    $('#menu-toggle').click(function (e) {
        e.preventDefault();
        $('#wrapper').toggleClass('toggled');
      });
  </script>
  @stack('addon-script')
</body>

</html>