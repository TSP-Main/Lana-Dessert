@extends('layout.app')
@section('title', 'Checkout')

<style type="text/css">
    #map {
            height: 400px;
            width: 100%;
        }
</style>

@section('content')
<div class="cart-sec pt-3 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="shipping-contact">
                    <input type="hidden" id="stripe_key" value="{{ $stripeKey }}">
                    <form id="checkout-form" action="{{ route('checkout.process') }}" method="post">
                        @csrf
                        <ol>
                            <li>
                                <h4>Contact information</h4>
                                <div class="row">
                                    <div class="col-md-4 p-0">
                                        <input type="text" placeholder="Name" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email" placeholder="Email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                            </li>
                            @if ($orderType == 'delivery')
                                <li>
                                    <h4>Delivery Address</h4>
                                    <p>Enter the address where you want your order delivered.</p>
                                    <div class="row">
                                        <div class="col-md-12 p-0">
                                            <input type="text" placeholder="Address" name="address" class="form-control" required>
                                        </div>
                                    </div>
                                    <h5 class="pt-4">Select your location</h4>
                                    <div class="row">
                                        <input type="hidden" id="coordinates" name="coordinates" value="">
                                        <input type="hidden" id="customer-lat" name="customer_lat">
                                        <input type="hidden" id="customer-lng" name="customer_lng"> 
                                        <div id="map"></div>
                                    </div>
                                </li>
                            @endif
                            <li class="otp">
                                <h4>Payment options</h4>
                                <div class="option-select">
                                    <input type="radio" id="cash" name="payment_option" value="cash" checked required>
                                    <label for="cash"> CASH</label>
                                </div>
                                <div class="option-select">
                                    <input type="radio" id="online" name="payment_option" value="online" required>
                                    <label for="online"> ONLINE </label>
                                </div>
                            </li>
                        </ol>
                        <!-- Stripe Payment Form -->
                        <div id="stripe-form" class="container mt-4 d-none">
                            <h4 class="mb-4">Stripe Payment</h4>
                            <div class="form-group mb-3">
                                <label for="card-element" class="form-label">Credit Card Information</label>
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                            <div class="form-group">
                                <button id="submit-payment" type="button" class="btn w-100" style="color: #C36; border: 1px solid #C36">Confirm the Payment and Place Order</button>
                            </div>
                        </div>
                        <div class="add-note">
                            <label for="note">Add a note to your order</label>
                            <textarea cols="30" rows="3" name="note" class="form-control"></textarea>
                        </div>
                        <hr>
                        <div class="return mt-4">
                            <a href="{{ route('cart.view') }}">Return to cart</a>
                            <button id="place-order" type="submit" class="btn">Place order</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart-total">
                    <div class="accordion mb-4" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Order Summary
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($cartItems as $cartItem)
                                        <div class="d-flex">
                                            <div class="img-sec">
                                                <img src="/images/brownies.jpg" width="40px" alt="">
                                            </div>
                                            <div class="title-pro ms-3 w-100">
                                                <p class="mb-0">
                                                    {{ $cartItem['productTitle'] }}
                                                    <span class="text-end">£ {{ $cartItem['rowTotal'] }}</span>
                                                </p>
                                                <p class="mt-0 mb-0">£ {{ $cartItem['productPrice'] }}</p>
                                                <p class="mt-0">{{ $cartItem['optionNames'] ? implode(', ', $cartItem['optionNames']) : '' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>Total <span> £ {{ $cartSubTotal }}</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Stripe with your public key
            const stripe = Stripe(document.getElementById('stripe_key').value);
            
            const elements = stripe.elements();
            
            // Create an instance of the card Element
            const card = elements.create('card');
            card.mount('#card-element');

            // Function to toggle visibility based on payment option
            function updatePaymentForm() {
                const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;
                const stripeForm = document.getElementById('stripe-form');
                const placeOrderButton = document.getElementById('place-order');

                if (paymentOption === 'online') {
                    stripeForm.classList.remove('d-none');
                    placeOrderButton.classList.add('d-none');
                } else {
                    stripeForm.classList.add('d-none');
                    placeOrderButton.classList.remove('d-none');
                }
            }

            // Run on page load
            updatePaymentForm();

            // Add event listeners to radio buttons to update form visibility
            document.querySelectorAll('input[name="payment_option"]').forEach(function(element) {
                element.addEventListener('change', updatePaymentForm);
            });

            document.getElementById('submit-payment').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;

                if (paymentOption === 'online') {
                    stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                        billing_details: {
                            name: document.querySelector('input[name="name"]').value,
                            email: document.querySelector('input[name="email"]').value,
                            phone: document.querySelector('input[name="phone"]').value
                        }
                    }).then(function(result) {
                        if (result.error) {
                            const displayError = document.getElementById('card-errors');
                            displayError.textContent = result.error.message;
                        } else {
                            const form = document.getElementById('checkout-form');
                            let hiddenTokenInput = form.querySelector('input[name="payment_method_id"]');

                            if (hiddenTokenInput) {
                                hiddenTokenInput.setAttribute('value', result.paymentMethod.id);
                            } else {
                                hiddenTokenInput = document.createElement('input');
                                hiddenTokenInput.setAttribute('type', 'hidden');
                                hiddenTokenInput.setAttribute('name', 'payment_method_id');
                                hiddenTokenInput.setAttribute('value', result.paymentMethod.id);
                                form.appendChild(hiddenTokenInput);
                            }

                            // Submit the form
                            form.submit();
                        }
                    }).catch(function(error) {
                        console.error('Error creating PaymentMethod:', error);
                    });
                } else {
                    // For cash payment or any other type
                    const form = document.getElementById('checkout-form');
                    form.submit(); // Simply submit the form without Stripe handling
                }
            });
        });
    </script>

    @if ($orderType == 'delivery')
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&v=weekly" defer></script>
        <script>
            function initMap() {
                let map, marker;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        map = new google.maps.Map(document.getElementById('map'), {
                            center: pos,
                            zoom: 14
                        });

                        marker = new google.maps.Marker({
                            position: pos,
                            map: map,
                            title: "You are here!",
                            draggable: true
                        });

                        // Update hidden input fields with current position
                        document.getElementById('customer-lat').value = pos.lat;
                        document.getElementById('customer-lng').value = pos.lng;

                        // Listen for drag events on the marker
                        google.maps.event.addListener(marker, 'dragend', function (event) {
                            var lat = event.latLng.lat();
                            var lng = event.latLng.lng();

                            // Update the hidden input fields with new position
                            document.getElementById('customer-lat').value = lat;
                            document.getElementById('customer-lng').value = lng;
                        });

                        // Listen for click events on the map
                        google.maps.event.addListener(map, 'click', function(event) {
                            var lat = event.latLng.lat();
                            var lng = event.latLng.lng();

                            // Move the marker to the clicked location
                            marker.setPosition(event.latLng);

                            // Update the hidden input fields with the clicked position
                            document.getElementById('customer-lat').value = lat;
                            document.getElementById('customer-lng').value = lng;
                        });

                    }, function () {
                        handleLocationError(true, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, map.getCenter());
                }
            }

            function handleLocationError(browserHasGeolocation, pos) {
                alert(browserHasGeolocation ?
                    "Error: The Geolocation service failed." :
                    "Error: Your browser doesn't support geolocation.");
            }
        </script>

        <script>
            document.getElementById('place-order').addEventListener('click', function(e) {
                e.preventDefault();

                var form = document.getElementById('checkout-form');

                // Check if the form is valid
                if (!form.checkValidity()) {
                    // If the form is not valid, display a validation message
                    form.reportValidity();
                    return;
                }

                var customerLat = parseFloat(document.getElementById('customer-lat').value);
                var customerLng = parseFloat(document.getElementById('customer-lng').value);
                
                var restaurantLat = {{ $restaurantLat }};
                var restaurantLng = {{ $restaurantLng }};
                var deliveryRadius = {{ $deliveryRadius }};

                console.log('radius ' + deliveryRadius * 1000);
                console.log('my lat ' + restaurantLat);
                console.log('my lng ' + restaurantLng);
                console.log('c lat ' + customerLat);
                console.log('c lng ' + customerLng);
                // Calculate the distance using the Haversine formula
                var distance = calculateDistance(restaurantLat, restaurantLng, customerLat, customerLng);
                console.log(distance);
                if (distance <= deliveryRadius * 1000) {
                    // Proceed with the order
                    document.getElementById('checkout-form').submit(); // or however your form is being submitted
                } else {
                    // Show error message
                    alert('Sorry, you are outside of our delivery radius.');
                }
            });

            function calculateDistance(lat1, lng1, lat2, lng2) {
                console.log('lat1 ' + lat1);
                console.log('lng1 ' + lng1);
                console.log('lat2 ' + lat2);
                console.log('lng2 ' + lng2);

                const R = 6371000; // Radius of the Earth in meters
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLng = (lng2 - lng1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c; // Distance in meters
            }
        </script>
    @endif
@endsection
