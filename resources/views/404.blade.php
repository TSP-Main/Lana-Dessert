@extends('layout.app')
@section('title', 'Page Not Found')


@section('content')
<div class="about-us-main" data-aos="fade-down" data-aos-duration="1500">
    <div class="container text-center d-flex justify-content-center align-items-center">
        <h2 class="about-title gradient-text" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text;  -webkit-text-fill-color: transparent;">Page Not Found</h2>
    </div>
</div>
<div class="beyound py-5" data-aos="fade-down-right" data-aos-duration="1500">
    <div class="container">
        <div class="row single-chef">
            <img src="/assets/theme/images/error-1.png" width="100%" alt="">
        </div>
    </div>
</div>

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

