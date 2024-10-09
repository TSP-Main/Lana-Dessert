@extends('layout.app')
@section('title', 'Contact Us')
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
<div class="contact-main" data-aos="fade-down" data-aos-duration="1500">
    <div class="container text-center d-flex justify-content-center align-items-center">
        <h2 class="about-title gradient-text" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text;  -webkit-text-fill-color: transparent;">Contact us</h2>
    </div>
</div>
<div class="any-time">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="contact-any mt-5">
                    <h2>Contact Us Anytime!</h2>
                    <p style="text-align: justify;">Got a question or craving? Contact us anytime for a friendly chat or to place an order. We’re
                        here to help, so reach out whenever you need!</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                    </svg>
                    <strong style="padding-left: 12px; font-size: 22px;">
                        <a href="tel:+441158550583" style="text-decoration: none; color:black">+44 115 855 0583</a>
                    </strong><br><br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                    </svg>
                    <strong style="padding-left: 12px; font-size: 22px;">
                        <a href="mailto:sales@lanadessert.co.uk" style="text-decoration: none; color:black">sales@lanadessert.co.uk</a>
                    </strong><br>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center single-chef" data-aos="fade-left" data-aos-duration="1500">
                <img src="/assets/theme/images/Shoop.webp" class="img-fluid" alt="Contact Image">
            </div>
        </div>
    </div>
</div>


<div class="menu-items my-5 py-5" data-aos="fade-down-right" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="dish-menu contact-menu">
                    <h2>Opening Hours</h2>
                    <p><strong>Monday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Tuesday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Wednesday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Thusrsday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Friday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Saturday </strong> <span>05:00pm-2.00am</span></p>
                    <p><strong>Sunday </strong> <span>05:00pm-2.00am</span></p>
                     
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

<div class="founder-about cheif-about">
    <div class="container">
        <div class="row">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="cheif-crew mt-4">
                    <h5>Discover</h5>
                    <h2>Our Chef will Make You  <br>Satisfying</h2>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium, totam rem aperiam, eaque ipsa quae ab illo</p>
                        <button onclick="window.location.href='{{ route('menus') }}'" class="btn btn-danger">Order now</button>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
                <div class="founder-img">
                    <img src="assets/theme/images/discover/1.png" class="responsive-img" alt="">
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