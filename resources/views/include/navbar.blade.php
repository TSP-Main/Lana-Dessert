<section class="nav-top bg-light py-2">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo on the left -->
            <div class="col-lg-3 col-6 d-flex align-items-center">
                <div class="lana-logo text-start">
                    <a href="{{ route('dashboad') }}">
                        <img src="{{ asset('assets/theme/images/lana-logo.png') }}" class="img-fluid logo-img" alt="Lana Logo" style="max-width: 80px;">
                    </a>
                </div>
            </div>
            
         <!-- Nav items centered on large devices, hidden on medium and small devices -->
        <div class="col-lg-6 d-none d-lg-flex justify-content-center">
            <nav class="navbar navbar-expand-lg" id="navbar">
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 d-flex justify-content-center" style="white-space: nowrap; flex-wrap: nowrap;">
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white text-center" aria-current="page" href="/" id="home-link">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white text-center" href="/about" id="about-link">About Us</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white text-center" href="/menus" id="menus-link">Online Order</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white text-center" href="/faq" id="faq-link">FAQ</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white text-center" href="/contact" id="contact-link">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
            
            <!-- Cart icon and toggle button on the right -->
            <div class="col-lg-3 col-6 d-flex align-items-center justify-content-end">
                <!-- Cart icon -->
                <div class="nav-left-svg nav-top-svg text-end me-3">
                    <a href="{{ route('cart.view') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3" style="width: 24px; height: 24px;" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                        <span id="cart-count" class="badge bg-primary ms-1" style="font-size: 0.75rem;"></span>
                    </a>
                </div>

                <!-- Toggle button visible on medium and small devices -->
                <div class="d-lg-none">
                    <button class="btn btn-light order-2 text-danger mt-3" id="navbarToggle" style="background: white;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-list" style="width: 24px; height: 24px;" viewBox="0 0 16 16">
                            <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1A1 1 0 0 1 0 2zm0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1A1 1 0 0 1 0 6zm1 4a1 1 0 0 1 1-1h14a1 1 0 0 1 0 2H1a1 1 0 0 1-1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Navbar for medium and small devices -->
        <div class="row d-lg-none d-block">
            <div class="col-12">
                <nav class="navbar navbar-expand-md ml-sm-100 ml-md-250" id="mobileNavbar">
                    <div class="collapse show" id="mobileNavbarContent">
                        <ul class="navbar-nav d-flex flex-column align-items-center w-100 text-center" style="padding: 10px 0;">
                            <li class="nav-item py-2">
                                <a class="nav-link text-white custom-underline" aria-current="page" href="/" id="home-link" style="text-decoration: none;">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item py-2">
                                <a class="nav-link text-white custom-underline" href="/about" id="about-link" style="text-decoration: none;">
                                    About Us
                                </a>
                            </li>
                            <li class="nav-item py-2">
                                <a class="nav-link text-white custom-underline" href="/menus" id="menus-link" style="text-decoration: none;">
                                    Online Order
                                </a>
                            </li>
                            <li class="nav-item py-2">
                                <a class="nav-link text-white custom-underline" href="/faq" id="faq-link" style="text-decoration: none;">
                                    FAQ
                                </a>
                            </li>
                            <li class="nav-item py-2">
                                <a class="nav-link text-white custom-underline" href="/contact" id="contact-link" style="text-decoration: none;">
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>



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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentPath = window.location.pathname;
        var navLinks = document.querySelectorAll(".navbar-nav .nav-link");

        navLinks.forEach(function(link) {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
            }
        });
    });

    </script>


