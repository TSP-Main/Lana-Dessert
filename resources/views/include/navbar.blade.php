<section class="nav-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3 col-6 d-flex align-items-center">
                <div class="lana-logo">
                <a href="{{ route('dashboad') }}">
                        <img src="{{ asset('assets/theme/images/lana-logo.png') }}" class="img-fluid logo-img" alt="Lana Logo">
                    </a>
                </div>
            </div>
            <div class="col-md-6 d-none d-lg-block">
            <nav class="navbar navbar-expand-lg justify-content-center" id="navbar">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/about">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/menus">Online Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/faq">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contact">Contact Us</a>
            </li>
        </ul>
    </div>
</nav>

            </div>
            <div class="col-md-3 col-6 d-flex align-items-center justify-content-end" style="margin-top: -35px;">
            <div class="nav-left-svg nav-top-svg d-none-mobile">
                    <a href="{{ route('cart.view') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                        <span id="cart-count" class="badge bg-primary"></span>
                    </a>
                </div>
                <div class="d-md-none">
                    <button class="btn btn-light" id="navbarToggle">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1A1 1 0 0 1 0 2zm0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1A1 1 0 0 1 0 6zm1 4a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1a1 1 0 0 1-1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="row d-lg-none">
            <div class="col-12">
                <nav class="navbar navbar-expand-md" id="mobileNavbar">
                    <div class="collapse navbar-collapse" id="mobileNavbarContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/about">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/menus">Online Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/faq">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contact">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>


<!-- <script src="path/to/bootstrap.bundle.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('navbarToggle');
            const mobileNavbar = document.getElementById('mobileNavbarContent');
            
            toggleButton.addEventListener('click', function() {
                if (mobileNavbar.classList.contains('show')) {
                    mobileNavbar.classList.remove('show');
                } else {
                    mobileNavbar.classList.add('show');
                }
            });
        });
    </script>

