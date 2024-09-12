@extends('layout.app')
@section('title', 'Menu')

<!-- <style>
    .gradient-text {
        font-size: 3rem;
        /* Adjust the font size as needed */
        font-weight: bold;
        /* Optional: Make the text bold */
        background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        /* Apply grnt to text for non-webkit browsers */
        text-fill-color: transparent;
        /* Ensure compatibility */
    }
</style> -->

@section('content')
    <div class="main-content" data-aos="fade-down" data-aos-duration="1500">
        <div class="title">
            <h2 class="about-title gradient-text" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text;  -webkit-text-fill-color: transparent;">Menu</h2>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="closedModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Restaurant Closed</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p id="schedule-msg">Sorry, we are currently closed or out of operating hours.</p>
              <p id="opening"></p>
              <p id="closing"></p>
            </div>
            <div class="modal-footer">
            <a href="{{ route('dashboad') }}">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </a>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal ENd -->

    <div class="promo text-center my-5 py-5">
    <h5 class="hot">Hot Promo</h5>
    <h2 class="special">Special offer on Sunday</h2>
    @if (! $isClosed)
    <div class="container mt-5 pt-5">

    <!-- Navigation Row with Scroll Arrows -->
    <div class="position-relative">
        <div class="row mb-4">
            <div class="col-12">
                <!-- Navigation Container -->
                <div style="display: flex; justify-content: center; padding-left: 20px; padding-right: 20px;">
                    <div class="scrollable-nav" style="display: flex; overflow: auto; width: 95%; white-space: nowrap; scroll-behavior: smooth;">
                        @foreach ($menus as $menu)
                        <a 
                            class="nav-link mr-3 mr-sm-n3 fw-bold text-dark"
                            href="#{{ $menu['attributes']['slug'] }}"
                            data-scroll-to="{{ $menu['attributes']['slug'] }}" 
                            style="font-size: 20px; text-decoration: none;">
                            {{ $menu['attributes']['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
                
                <button class="position-absolute top-50 start-0 translate-middle-y scroll-btn" id="scroll-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                    </svg>
                </button>
               
                <button class="position-absolute top-50 end-0 translate-middle-y scroll-btn" id="scroll-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    @php
        $chunks = array_chunk($menus, 4);
    @endphp
    @foreach ($chunks as $chunk)
        <div class="row" data-aos="fade-up" data-aos-duration="1500">
            @foreach ($chunk as $menu)
                <div id="{{ $menu['attributes']['slug'] }}" class="col-6 col-sm-6 col-md-3 mb-4 d-flex justify-content-center">
                    <a href="{{ route('menu', ['category' => $menu['attributes']['slug']]) }}" class="text-decoration-none mx-4 mx-sm-0">
                        <img
                            src="{{ env('SERVER_URL') }}storage/{{ $menu['attributes']['background_image'] }}"
                            class="img-fluid" alt="{{ $menu['attributes']['name'] }}">
                        <h2 class="mt-2">{{ $menu['attributes']['name'] }}</h2>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

    @endif
    </div>

    <div class="menu-items my-5 pt-5" data-aos="fade-down-right" data-aos-duration="1500">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="dish-menu">
                        <h2>Lana Meal Deal</h2>
                        <p><strong>Lana Meal Deal <span>................................................</span> £13.99</strong></p>
                        <p class="dim-para">Sed ut perspiciatis unde omnis iste natus ero</p>
                        <p><strong>larg chips <span>........................................................</span> £3.49</strong></p>
                        <p class="dim-para">Served with ketchup and mayo</p>
                        <!-- Add more dish menu items here -->
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="dish-img d-grid">
                        <img src="assets/theme/images/dish-menu1.webp" class="dish-one" width="350px" alt="">
                        <img src="assets/theme/images/dish-menu2.webp" class="mt-4 dish-two" width="350px" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="right-side-dish d-grid">
                        <img src="assets/theme/images/dish-menu3.webp" class="dish-three" width="100%" alt="">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu-more my-5 pt-5" data-aos="fade-up-right" data-aos-duration="1500">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="dish-more-img d-grid">
                    <img src="assets/theme/images/more-dish1.webp" class="dish-one d-none d-md-block" width="350px" alt="">
                    <img src="assets/theme/images/menu-more3.webp" class="mt-2 mb-4 dish-two" width="350px" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="right-more-dish d-grid">
                        <img src="assets/theme/images/menu-more2.webp" class="dish-three d-none d-md-block" width="500px" alt="">

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dish-more">
                        <h2>Chicken</h2>
                        <p><strong>spicy chicken wings(6pc) <span>....................................................</span>
                        £6.49</strong></p>
                        <p class="dim-para">Created in a spicy homestyle served with ketchup & mayo.</p>
                        <p><strong>spicy chicken strips(6pc) <span>....................................................</span>
                        £6.99</strong></p>
                        <p class="dim-para">Created in a spicy homestyle served with ketchup & mayo.</p>

                        <p><strong>large Chips <span>...........................................................................</span>
                        £3.49</strong></p>
                        <p class="dim-para">served with ketchup & mayo.</p>
                        <p><strong>spicy chicken strips(4pc) <span>....................................................</span>
                        £5.99</strong></p>
                        <p class="dim-para">Created  in a spicy homestyle served with ketchup &mayo.</p>
                        <p><strong>spicy chicken wings(4pc) <span>....................................................</span>
                        £5.49</strong></p>
                        <p class="dim-para">Created in a spicy homestyle served with ketchup & mayo.</p>
                        <!-- Add more main course items here -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="menu-items my-5 pt-5" data-aos="fade-down-right" data-aos-duration="1500">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="dish-menu dish-men">
                        <h2>Croffles</h2>
                        <p><strong>croffle The One and only<span>..............................................</span> £8.50</strong></p>
                        <p class="dim-para">kinder chocolate bar,crushed lotus,dairy milk,fresh<br>strawberries and banana served with vanilla ice cream.</p>
                        <p><strong>croffle Tutti Frutti<span>..........................................................</span> £7.49</strong></p>
                        <p class="dim-para">Fresh bananas and strawberries,nutella and white<br>chocolate sauce served with vanilla ice cream.</p>
                        <p><strong>croffle oreo<span>...................................................................</span> £7.49</strong></p>
                        <p class="dim-para">oreo biscuits,nutella white chocolate sauce served<br>with vanilla ice cream.</p>
                        <p><strong>croffle ferrero<span>...............................................................</span> £7.49</strong></p>
                        <p class="dim-para">ferrero rocher,nutella white chocolate sauce served<br>with vanilla ice cream.</p>
                        <!-- Add more dessert items here -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dish-img d-grid">
                        <img src="assets/theme/images/dish-menu1.webp" class="dish-one" width="350px" alt="">
                        <img src="assets/theme/images/dish-menu2.webp" class="mt-4 dish-two" width="350px" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="right-side-dish d-grid">
                        <img src="assets/theme/images/dish-menu3.webp" class="dish-three" width="100%" alt="">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('script')
    <script>
        // Function to update cart count
        function updateCartCount() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    const cartCountElement = document.getElementById('cart-count');
                    if (data.count > 0) {
                        cartCountElement.textContent = data.count;
                        cartCountElement.style.display = 'inline'; // Show badge if count > 0
                    } else {
                        cartCountElement.textContent = ''; // Hide badge if count is 0
                        cartCountElement.style.display = 'none'; // Optionally, you can also hide the badge
                    }
                })
                .catch(error => console.error('Error fetching cart count:', error));
        }

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>

@endsection
<!-- shedule-msg text in json : @json($msg) -->
@section('script')
    <script>
        $(document).ready(function() {
            var isClosed = @json($isClosed);
            if (isClosed) {
                $('#schedule-msg').text('Restaurant Timing is');
                if(@json($code) == '002'){
                    $('#opening').text('Opening: ' + @json($opening));
                    $('#closing').text('Closing: ' + @json($closing));
                }
                $('#closedModal').modal('show');
            }
        });
    </script>


<script>
   document.addEventListener('DOMContentLoaded', function() {
            const scrollableNav = document.querySelector('.scrollable-nav');
            const scrollLeftButton = document.getElementById('scroll-left');
            const scrollRightButton = document.getElementById('scroll-right');

            scrollLeftButton.addEventListener('click', () => {
                scrollableNav.scrollBy({
                    left: -200, // Adjust scroll amount as needed
                    behavior: 'smooth'
                });
            });

            scrollRightButton.addEventListener('click', () => {
                scrollableNav.scrollBy({
                    left: 200, // Adjust scroll amount as needed
                    behavior: 'smooth'
                });
            });
        });
    </script>

@endsection
