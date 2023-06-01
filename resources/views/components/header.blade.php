<header>
    <nav class="navbar bg-white navbar-expand-lg container p-0" aria-label="Light offcanvas navbar">
        <div class="container navbar-container">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight">
                    <i class="bi bi-list"></i>
                </button>
                <a class="navbar-brand fw-800" href="{{ route('index') }}">
                    #EpicRevenue
                </a>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight"
                     aria-labelledby="offcanvasNavbarLightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">
                            <!--<img src="{{ asset('img/logo.png') }}" width="50" height="50" alt="logo">-->
                            #EpicRevenue
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav">
                            <li class="nav-item menu-area d-none">
                                <a class="nav-link" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" aria-current="page" id="navbarDropdown"
                                   role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false" href="#">Learn</a>
                                <ul class="dropdown-menu half-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('blog') }}">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="dropdown-icon-wrap"><i class="bi bi-book"></i></div>
                                                </div>
                                                <div class="col-auto w-80">
                                                    <div class="mb-2 w-100 fw-800">Blog</div>
                                                    <div class="w-100">Learn product design in just 16 weeks...</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>                                    
                                    <!--
                        <li><a class="dropdown-item" href="{{ route('categoryAll') }}">Categories</a></li>
                        <li><a class="dropdown-item" href="{{ route('tagAll') }}">Tags</a></li>
                        -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>