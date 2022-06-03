<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/announcements">Announcements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shop">Wakepark inventory shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reservations.index')}}">Wakeboarding reservations</a>
                </li>
                @can('is-admin')
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">Users list</a>
                    </li>
                @endcan
                @can('parkStaff')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reservations.list')}}">Reservations list</a>
                </li>
                @endcan
                @can('is-owner')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('shop.getOrdersList')}}">Ordered items</a>
                </li>
                @endcan
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->

        <!-- Right elements -->
        <div class="d-flex align-items-center">
            <a href="{{route('shoppingCart')}}" class="text-reset me-3 nav-link">
                <i class="fa fa-shopping-cart"></i> Shoping cart
                <span class="badge alert-warning">{{Session::has('cart') ? Session::get('cart')->totalItems : ''}}</span>
            </a>
            @guest
                @if (Route::has('login'))

                    <a class="nav-link text-reset" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif

                @if (Route::has('register'))

                    <a class="nav-link text-reset" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                <div class="dropdown">
                    <a
                        class="dropdown-toggle d-flex align-items-center text-reset nav-link"
                        href="#"
                        data-bs-toggle="dropdown"
                        role="button"
                        data-mdb-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="fa fa-user"></i>&nbsp; {{Auth::user()->username }}
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end"
                    >
                        <li>
                            <a class="dropdown-item" href="/profile/{{Auth::id()}}">My profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
