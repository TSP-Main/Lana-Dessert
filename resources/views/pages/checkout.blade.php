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
                        <!-- <ol>
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
                        </ol> -->


                          <!-- Checkout -->
        <div class="card shadow-0 border">
          <div class="p-4">
            <h5 class="card-title mb-3">Contact Information</h5>
            <div class="row">
              <div class="col-6 mb-3">
                <p class="mb-0">First name</p>
                <div class="form-outline">
                  <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                </div>
              </div>

              <div class="col-6">
                <p class="mb-0">Last name</p>
                <div class="form-outline">
                  <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                </div>
              </div>

              <div class="col-6 mb-3">
                <p class="mb-0">Phone</p>
                <div class="form-outline">
                  <input type="tel" id="typePhone" value="+48 " class="form-control" />
                </div>
              </div>

              <div class="col-6 mb-3">
                <p class="mb-0">Email</p>
                <div class="form-outline">
                  <input type="email" id="typeEmail" placeholder="example@gmail.com" class="form-control" />
                </div>
              </div>
            </div>

            <hr class="my-4" />

            <h5 class="card-title mb-3">Payment Option</h5>

            <div class="row mb-3">
              <div class="col-lg-4 mb-3">
                <div class="form-check h-100 border rounded-3">
                  <div class="p-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked />
                    <label class="form-check-label" for="flexRadioDefault1">
                      Cash <br />
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 mb-3">
                <div class="form-check h-100 border rounded-3">
                  <div class="p-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" />
                    <label class="form-check-label" for="flexRadioDefault3">
                      Online <br />
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12 mb-3">
                <p class="mb-0">Address</p>
                <div class="form-outline">
                  <input type="text" id="address" name="address" placeholder="Type here" class="form-control" required />
                </div>
              </div>

              <div class="col-sm-12 mb-3">
                <p class="mb-0">Apartment, Suite, etc. (Optional)</p>
                <div class="form-outline">
                  <input type="text" id="apartment" name="apartment" placeholder="Type here" class="form-control" />
                </div>
              </div>

              <div class="col-sm-6 col-6 mb-3">
                <p class="mb-0">City</p>
                <div class="form-outline">
                  <input type="text" id="city" name="city" class="form-control" required />
                </div>
              </div>

              <div class="col-sm-6 col-6 mb-3">
                <p class="mb-0">Postal code</p>
                <div class="form-outline">
                  <input type="text" id="postcode" name="postcode" class="form-control" required/>
                </div>
              </div>

                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <div class="mb-3">
              <p class="mb-0">Message to seller</p>
              <div class="form-outline">
                <textarea class="form-control" id="textAreaExample1" rows="2"></textarea>
              </div>
            </div>

            <div class="float-end">
              <button class="" style="background-color: transparent; padding: 10px 13px; border: 2px solid #e26284; border-radius: 0 20px 0 0; margin: 10px 15px; color: #e26284;">Cancel</button>
              <button id="place-order" class="nav-top-svg text-white shadow-0 border-white">Place Order</button>
            </div>
          </div>
        </div>
        <!-- Checkout -->



                        <!-- Stripe Payment Form -->
                        <!-- <div id="stripe-form" class="container mt-4 d-none">
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
                        </div> -->
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
                            var orderType = @json($orderType);
                            if(orderType === 'pickup'){
                                form.submit();
                            }
                            else{
                                checkCustomerLocation();
                            }
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
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places" async defer></script>
        
        <script>
            let autocomplete;
        
            function initAutocomplete() {
                // Initialize autocomplete
                autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
                autocomplete.setFields(['address_component', 'geometry']);
        
                autocomplete.addListener('place_changed', function() {
                    let place = autocomplete.getPlace();
                    if (!place.geometry) {
                        alert("No details available for the input: '" + place.name + "'");
                        return;
                    }
        
                    // Set latitude and longitude in hidden fields
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
        
                    // Autofill the city, postcode, and apartment
                    fillInAddress(place);
                });
        
                // Handle manual postcode entry
                document.getElementById('postcode').addEventListener('blur', function() {
                    let postcode = this.value;
                    if (postcode) {
                        geocodePostcode(postcode);
                    }
                });
            }
        
            function fillInAddress(place) {
                let addressComponents = place.address_components;
                let city = '';
                let postcode = '';
                let apartment = '';
        
                addressComponents.forEach(component => {
                    let types = component.types;
        
                    if (types.includes('postal_code')) {
                        postcode = component.long_name;
                    }
                });
        
                // Autofill fields
                document.getElementById('postcode').value = postcode;
            }
        
            function geocodePostcode(postcode) {
                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': postcode }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            let location = results[0].geometry.location;
        
                            // Update latitude and longitude
                            document.getElementById('latitude').value = location.lat();
                            document.getElementById('longitude').value = location.lng();
        
                            // Autofill other address fields based on geocoded result
                            fillInAddress(results[0]);
                        }
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
        
            document.addEventListener('DOMContentLoaded', function() {
                initAutocomplete();
            });
        </script>

        <!-- Check Delivery Radius -->
        <script>
            document.getElementById('place-order').addEventListener('click', function(e) {
                e.preventDefault();
                checkCustomerLocation();
            });

            function checkCustomerLocation(){
                var form = document.getElementById('checkout-form');

                // If the form is not valid, display a validation message
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                var customerLat = parseFloat(document.getElementById('latitude').value);
                var customerLng = parseFloat(document.getElementById('longitude').value);
                
                var restaurantLat = {{ $restaurantLat }};
                var restaurantLng = {{ $restaurantLng }};
                var deliveryRadius = {{ $deliveryRadius }};
console.log(customerLat);
console.log(customerLng);
console.log(restaurantLat);
console.log(restaurantLng);
console.log(deliveryRadius);
                // Calculate the distance using the Haversine formula
                var distance = calculateDistance(restaurantLat, restaurantLng, customerLat, customerLng);
                console.log('d ' + distance);
                if (distance <= deliveryRadius * 1000) {
                    // Proceed with the order
                    document.getElementById('checkout-form').submit();
                } else {
                    // Show error message
                    alert('Sorry, you are outside of our delivery radius.');
                }
            }

            function calculateDistance(lat1, lng1, lat2, lng2) {
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
