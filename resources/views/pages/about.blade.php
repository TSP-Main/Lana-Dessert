@extends('layout.app')
@section('title', 'About')

<!-- <style>
    /* .nav-top-svg{
        display: none;
    } */
    .gradient-text {
    font-size: 3rem; /* Adjust the font size as needed */
    font-weight: bold; /* Optional: Make the text bold */
    background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text; 
    -webkit-text-fill-color: transparent; 
    background-clip: text; /* Apply grnt to text for non-webkit browsers */
    text-fill-color: transparent; /* Ensure compatibility */
}
</style> -->
@section('content')
<div class="about-us-main" data-aos="fade-down" data-aos-duration="1500">
    <div class="container text-center d-flex justify-content-center align-items-center">
        <h2 class="about-title gradient-text" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text;  -webkit-text-fill-color: transparent;">About us</h2>
    </div>
</div>
<div class="beyound py-5" data-aos="fade-down-right" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-6 my-5 py-5">
                <div class="bakery">
                    <h4>About Us</h4>
                    <h2>A Bakery Beyond <br> Expectations</h2>
                </div>
            </div>
            <div class="col-md-6 my-5 py5">
                <p style="text-align: justify;">Lana Dessert – where Nottingham indulges in a symphony of sweet delights. Nestled in the heart of
                    the city, Lana Dessert tempts taste buds with a fusion of creative desserts and fast food, each
                    bite bursting with flavour. Whether you’re craving a midnight treat or a post-dinner dessert,
                    we’re here to satisfy your cravings. Our doors are open from Monday to Sunday, 5 pm to 2 am,
                    inviting you to dine in or grab your favourites for takeaway. Have a special request? We love to
                    cater to your unique tastes—custom orders are always welcomed, reflecting Lana’s commitment to
                    exceeding expectations.</p>
            </div>
        </div>
        <div class="row single-chef">
            <img src="/assets/theme/images/Shoop.webp" width="100%" alt="">
        </div>
    </div>
</div>

<div class="counter-about text-center" data-aos="fade-up" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="counter">12</p>
                <h2>Restaurant</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">8</p>
                <h2>Years Experience</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">50</p>
                <h2>Menu Dishes</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">200</p>
                <h2>Customers</h2>
            </div>
        </div>

    </div>
</div>

<div class="founder-about" data-aos="fade-down-right" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="founder-img">
                    <img src="/assets/theme/images/shop.webp" width="100%" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="founder-msg" data-aos="fade-left" data-aos-duration="1000">
                    <h2>Message from Lana Dessert!</h2>
                    <p style="text-align: justify;">At Lana Dessert, we’re all about sweet satisfaction! Our bakery in Nottingham serves up
                        delicious desserts and fast food with a creative twist. We mix passion with flavour in every
                        bite. I founded this place to blend creativity with tradition. Each treat is made with care
                        and innovation. Come join us on a delicious journey where taste knows no limits. </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="vision" data-aos="zoom-in-up" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <h2 style="text-align: center">Our Vision & Mission</h2>
                <div class="innovate d-flex">
                    <div class="vision-img me-2">
                        <img src="/assets/theme/images/innovate.png" width="50px" alt="">
                    </div>
                    <div class="vision-content">
                        <h2>Innovate</h2>
                        <p>Constantly create new and exciting desserts and fast food options.</p>
                    </div>
                </div>
                <div class="innovate d-flex">
                    <div class="vision-img me-2">
                        <img src="/assets/theme/images/delight.png" width="50px" alt="">
                    </div>
                    <div class="vision-content">
                        <h2>Delight</h2>
                        <p>Ensure every customer leaves with a smile, satisfied by our flavours and service.</p>
                    </div>
                </div>
                <div class="innovate d-flex">
                    <div class="vision-img me-2">
                        <img src="/assets/theme/images/connect.png" width="50px" alt="">
                    </div>
                    <div class="vision-content">
                        <h2>Connect</h2>
                        <p>Build a community around our bakery, fostering relationships and sharing happiness, one
                            bite at a time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="have-look">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-12 mt-5" data-aos="fade-left" data-aos-duration="1500">
                <div class="mount text-center mt-5">
                    <h4>Have a Look!</h4>
                    <h2>Our Mouthwatering <br> Menu</h2>
                    <button onclick="window.location.href='{{ route('menus') }}'" class="btn">Order now</button>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 50px;">
                <div class="row d-flex justify-content-between" data-aos="fade-up" data-aos-duration="1500">
                    <div class="col-md-3">
                        <div class="card">
                            <a href="/menus" class="card-body" style="text-decoration: none;">
                                <img src="/assets/theme/images/waffles-2.png" width="70px" alt="">
                                <h5 class="card-title">Waffles</h5>
                                <p class="card-text">Lana Dessert's waffles are irresistibly delicious, featuring
                                    crispy edges, soft centres, and decadent toppings for a delightful treat
                                    everyone will love.</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="/menus" class="card-body" style="text-decoration: none;">
                                <img src="/assets/theme/images/shakes-1.png" width="70px" alt="">
                                <h5 class="card-title">Shakes</h5>
                                <p class="card-text">Savour our shakes – creamy, rich, and bursting with flavour.
                                    Indulge in classic favourites or explore unique combinations for a refreshing
                                    treat anytime.</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="/menus" class="card-body" style="text-decoration: none;">
                                <img src="/assets/theme/images/croffle-1.png" width="70px" alt="">
                                <h5 class="card-title">Croffles</h5>
                                <p class="card-text">A delicious fusion of croissants and waffles, crispy on the
                                    outside, flaky on the inside, perfect for a delightful breakfast or snack.</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="/menus" class="card-body" style="text-decoration: none;">
                                <img src="/assets/theme/images/mini-doughnut.png" width="70px" alt="">
                                <h5 class="card-title">Mini Doughnuts</h5>
                                <p class="card-text">Bite-sized delights, fried to golden perfection, dusted with
                                    sugar or glazed for sweetness, a delightful treat for any occasion.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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

