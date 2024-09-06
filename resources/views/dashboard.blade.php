@extends('layout.app')
@section('title', 'Lana Desert')

@section('content')
<div class="home-main">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6 col-12 text-center text-md-start">
                <div class="welcome my-5" data-aos="fade-right">
                    <h4>Welcome To Lana Dessert</h4>
                    <h2>
                        Bite into Blissful Moments <br>Where Flavor Knows No Limits
                    </h2>
                    <p style="text-align: justify;">We are a bakery that creatively combines desserts and fast food, emphasizing unique flavors
                        and inventive culinary presentations for enjoyment.</p>
                    <button onclick="window.location.href='{{ route('menus') }}'" class="btn px-5 py-3">Online Order</button>
                </div>
            </div>
            <div class="col-md-6 col-12 text-center text-md-end">
                <div class="double-side my-4" data-aos="fade-down-left" data-aos-duration="1500">
                    <img src="{{ asset('assets/theme/images/home-lana.webp')}}" class="img-fluid left-small" alt="Dessert Image">
                    <img src="{{ asset('assets/theme/images/home-lana-left.webp')}}" class="img-fluid right-straw" alt="Dessert Image">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="have-look my-5 pt-5" data-aos="fade-down" data-aos-duration="1500">
    <div class="container">
        {{-- <div class="mount text-center mb-5">
            <h4>Have a Look!</h4>
            <h2>Our Mouthwatering Menu</h2>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="row" data-aos="fade-down" data-aos-duration="1500">
                    @if ($response)
                           @foreach ($categories->take(4) as $category)
                           <div class="col-12 col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <a href="{{ route('menu', ['category' => $category['slug']]) }}">
                                    </a>
                                    <h5 class="card-title">{{ $category['name'] }}</h5>
                                    <p> {{ $category['desc']}}</p>
                                </div>
                            </div> 
                            @endforeach
                        @if (count($categories) > 0)
                            <div class="mount text-center mb-5"> <a href="{{ route('menus') }}" class="btn btn-outline-danger px-3 py-3 mt-3">View All</a> </div>
                        @endif
                    @else
                        <div class="mount text-center mb-5">
                            <h2 class="text-danger">-----Api Error-----</h2>
                            <p>Configure APi Token</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="founder-about" data-aos="fade-right" data-aos-duration="1000">
    <div class="container">
        <div class="row">
            <div class="col-md-3 colmd3">
                <div class="founder-img">
                    <img src="assets/theme/images/home-lana-left.webp" class="custom-margin-img" width="100%" alt="">
                </div>
            </div>
            <div class="col-md-4 colmd4">
                <div class="founder-img">
                    <img src="assets/theme/images/home-lana-msg.webp" width="100%" alt="">
                </div>
            </div>
            <div class="col-md-5 colmd5">
                <div class="founder-msg home-msg">
                    <h2>About Us</h2>
                    <h4>Our Story!</h4>
                    <p style="text-align: justify;">Welcome to Lana Dessert in Nottingham! We make delicious desserts and fast food with a twist.
                        Whether you want to eat in or take out, we’re open every day from 5 PM to 2 AM. You can even
                        customise your order to suit your taste because we love making things just how you like
                        them. So, come on over and enjoy our yummy treats with a side of fun! </p>
                    <a href="/about">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="counter-about" data-aos="fade-down" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="counter">2</p>
                <h2>Restaurant</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">5</p>
                <h2>Years Experience</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">50</p>
                <h2>Menu Items</h2>
            </div>
            <div class="col-md-3">
                <p class="counter">1000</p>
                <h2>Customers</h2>
            </div>
        </div>
    </div>
</div>

<div class="menu-items my-5 pt-5 bg-none" data-aos="fade-down" data-aos-duration="1500">
    <div class="container" style= "height: 38rem">
        <div class="row">
            <div class="col-md-4">
                <div class="dish-menu shadow" style="line-height: 1.3;">
                    <h2 >Burgers</h2>
                    <p><strong>Cheese Burger <span>....................................................</span> £9.99</strong>
                    </p>
                    <p class="dim-para">A good old classic beef slice cheez caramelised onion <br> Tomato french lettuce pickle service with fries</p>
                    <p><strong>Double Cheese Burger <span>.....................................</span> £10.99</strong>
                    </p>
                    <p class="dim-para">Tomato, caramelized onion, lettuce, pickle served with <br> burger sauce and fries</p>
                    <p><strong>Halloumi Cheese Burger  <span>....................................</span>  £8.49</strong>
                    </p>
                    <p class="dim-para">Olive, tomato, lettuce & cucumber without sauce served <br> with fries</p>
                    <p><strong>BBQ Burger  <span>.......................................................</span> £10.49</strong>
                    </p>
                    <p class="dim-para">Samoky BBQ flavour topped with BBQ mayo and Tamato, <br> French lettuce, caramelized onion, BBQ sauce served </p>
                    <p><strong>Spicy F16 Chicken Burger<span>...................................</span> £9.99</strong>
                    </p>
                    <p class="dim-para">Fried chicken breast, Hot home style coating to give an <br> special kick, cheese slice, caramelized onion hot sauce</p>
                    <p><strong>Taka Tuka Chicken Burger<span>..................................</span> £9.99</strong>
                    </p>
                    <p class="dim-para">Delicious peri peri marinated grilled chicken, cheese slice, <br> lettuce, tomato, pickle, perfect stacked onion</p>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-left" data-aos-duration="1500">
                <div class=" d-grid">
                    <img src="/assets/theme/images/home-burger.webp" class="dish-one" width="100%" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="any-time my-5 py-5 reserv">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row justify-content-center text-center">
            <div class="col-md-6 mb-5 mt-0" data-aos="fade-left" data-aos-duration="1500">
                <div class="contact-any mt-5">
                    <h2 class="display-4">Online Order</h2>
                    <h4 class="display-6">Placed your online order</h4>
                </div>
                <p class="lead" style="color: aliceblue; text-align: justify;">Treat yourself to our delicious selection of desserts without leaving your home! Simply choose your favourites, place your order, and let our delivery system take care of the rest.
                    !</p>
                <button onclick="window.location.href='{{ route('categories.all') }}'" class="btn btn-outline-danger px-5 py-3">Order Online</button>
            </div>
            <!-- Uncomment and use this section if needed -->
            <!-- <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="contact-form">
                    <h2 class="display-4">Book Table</h2>
                    <form class="mt-5">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Name" id="exampleInputName" aria-describedby="nameHelp">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Phone" id="exampleInputPhone">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subject" id="exampleInputSubject1">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subject" id="exampleInputSubject2">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div> -->
        </div>
    </div>
</div>


<!-- testimonial  -->
<div class="testimonial py-5" data-aos="fade-down" data-aos-duration="1500">
    <div class="container text-center py-5">
        <h2 class="client-test">Testimonials</h2>
        <h2 class="customer">What Our Customers Say!</h2>

        <div id="carouselExampleIndicators" class="carousel slide mt-5 py-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                    class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active text-center">
                    <p>Fantastic milkshakes in satisfying portions. Very friendly staff. Haven’t been disappointed.</p>
                    <h2>Mehmet Ali Karademir</h2>
                </div>
                <div class="carousel-item text-center">
                    <p>Highly Recommend!!
                    I ordered the strawberries and chocolate and I will definitely be back in the future.
                    The strawberries were so fresh and tasty and topped with the milk and white chocolate… AMAZING !!!</p>
                    <h2>Eley Thomas</h2>
                </div>
                <div class="carousel-item text-center">
                    <p>Had the freddo ice cream it was so good absolutely loved it definitely getting it again and I'm definitely trying the other desserts they have
                    Edit: I have tried the oreo ice cream it is also delicious next time I'm definitely trying the cheese cakes they have or something else they have there :)</p>
                    <h2>Loafiethe Bread</h2>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<div class="news-letter py-5" data-aos="fade-up" data-aos-duration="1500">
    <div class="container">
        <div class="row mt-5 py-5">
            <div class="col-md-4">
                <div class="news-title">
                    <h5>Newsletter</h5>
                    <h2>Subscribe Now !</h2>
                </div>
            </div>
            <div class="col-md-5">
                <input type="text" placeholder="Your Email" class="form-control">
            </div>
            <div class="col-md-3">
                <button class="btn px-5 py-2 text-center mt-2">Subscribe</button>
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