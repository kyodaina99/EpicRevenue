<header class="navbar navbar-expand-lg py-3 @if(isset($activePage)){{ $activePage }}@endif">
    <nav class="container">
        <a class="navbar-brand fw-700 col-auto" href="{{ url('/') }}">
                <!--
                <img src="{{ asset('img/logo.png') }}" width="50" height="50" alt="logo">
                <img class="logo" src="https://districtgurus.com/public/uploads/all/SC008HOLHmfOeB8E3SxNDONHI7nad1YJcmSl0ds9.png" data-src="https://districtgurus.com/public/uploads/all/SC008HOLHmfOeB8E3SxNDONHI7nad1YJcmSl0ds9.png" alt="District Gurus">-->
                #EPICREVENUE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                @if(auth()->check())
                    <li class="nav-item menu-area {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{url('/dashboard')}}">Dashboard</a>
                    </li>
                    <li class="nav-item menu-area {{ request()->is('blog') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/blog') }}">Blog</a>
                    </li>
                    <li class="nav-item menu-area {{ request()->is('campaigns') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/campaigns') }}">Campaigns</a>
                    </li>
                    <li class="nav-item menu-area {{ request()->is('reports') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/reports') }}">Analytics</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" aria-current="page" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">{{ auth()->user()->firstname }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/settings') }}">Settings</a></li>
                            <li><a class="dropdown-item" href="{{ url('/invite') }}">Invite</a></li>
                            <li><a class="dropdown-item" href="{{ url('/support') }}">Support</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item menu-area">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item menu-area">
                        <a class="nav-link" href="{{ url('/blog') }}">Blog</a>
                    </li>
                    <li class="nav-item menu-area {{ request()->is('earn') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/earn') }}">Earn</a>
                    </li>
                    <li class="nav-item menu-area {{ request()->is('business') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/business') }}">Business Solutions</a>
                    </li>
                    <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>  
                    </li>
                    <li class="nav-item {{ request()->is('account/create') ? 'active' : '' }}">
                        <a class="nav-link btn btn-primary register text-white px-4" href="{{ url('/account/create') }}">Register</a>  
                    </li>

                @endif
            </ul>
        </div>
    </nav>
</header>
