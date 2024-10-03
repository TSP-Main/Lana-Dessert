@extends('layout.app')
@section('title', 'Checkout')

<style>
    .input-group {
        display: flex;
    }

    .form-outline {
        flex-grow: 1; /* Allow the input field to take up available space */
    }

    .btn {
        margin-left: 5px; /* Space between input and button */
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
                        <input type="hidden" name="applied_code" id="applied_code" value="0">
                        <div class="card shadow-0 border">
                            <div class="p-4">
                                <!-- Contact Details -->
                                <h5 class="card-title mb-3">Contact Information</h5>
                                <div class="row">
                                    <div class="col-xs-12 mb-3">
                                        <p class="mb-0">Name</p>
                                        <div class="form-outline">
                                            <input type="text" name="name" id="name" placeholder="Type Name" class="form-control" required/>
                                        </div>
                                    </div>
                    
                                    {{-- <div class="col-6">
                                        <p class="mb-0">Last name</p>
                                        <div class="form-outline">
                                            <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                                        </div>
                                    </div> --}}
                    
                                    <div class="col-xs-12 col-sm-6 col-md-6 mb-3">
                                    <p class="mb-0">Phone</p>
                                    <div class="form-outline">
                                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Type Phone Number" maxlength="16" pattern="\d*" title="Please enter a valid phone number with up to 16 digits." required />
                                    </div>
                                    </div>

                    
                                    <div class="col-xs-12 col-sm-6 col-md-6 mb-3">
                                        <p class="mb-0">Email</p>
                                        <div class="form-outline">
                                            <input type="email" name="email" id="email" placeholder="example@gmail.com" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Address Details -->
                                @if ($orderType == 'delivery')
                                    <hr class="my-4" />
                                    <h5 class="card-title mb-3">Address Details</h5>
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
                        
                                        <div class="col-xs-12 col-sm-6 col-md-6 mb-3">
                                            <p class="mb-0">City</p>
                                            <div class="form-outline">
                                                <input type="text" id="city" name="city" class="form-control" required />
                                            </div>
                                        </div>
                        
                                        <div class="col-xs-12 col-sm-6 col-md-6 mb-3">
                                            <p class="mb-0">Postal code</p>
                                            <div class="form-outline">
                                                <input type="text" id="postcode" name="postcode" class="form-control" required/>
                                            </div>
                                        </div>
                        
                                        <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" id="longitude" name="longitude">
                                    </div>
                                @endif

                                <hr class="my-4" />
                                <div class="mb-3">
                                    <p class="mb-0">Add a note to your order (Optional)</p>
                                    <div class="form-outline">
                                        <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                                    </div>
                                </div>

                                <!-- Payment Detail -->
                                <hr class="my-4" />
                                <h5 class="card-title mb-3">Payment Option</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="payment_option" id="cash" value="cash" checked required/>
                                                <label class="form-check-label" for="cash">
                                                    Cash <br />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="payment_option" id="online" value="online" required/>
                                                <label class="form-check-label" for="online">
                                                    Online Payment <br />
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stripe Card Fields -->
                                    {{-- <div id="stripe-form" class="container mt-4 d-none">
                                        <h4 class="mb-4">Online Payment</h4>
                                        <div class="form-group mb-3">
                                            <label for="card-element" class="form-label">Credit Card Information</label>
                                            <div id="card-element" class="form-control"></div>
                                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                        </div>
                                        <div class="form-group">
                                            <button id="submit-payment" type="button" class="btn w-100" style="color: #C36; border: 1px solid #C36">Confirm the Payment and Place Order</button>
                                        </div>
                                    </div> --}}

                                    <div id="stripe-form" class="container mt-4 d-none">
                                        {{-- <h4 class="mb-4">Online Payment</h4> --}}
                                        <div class="form-group mb-3">
                                            <label for="card-number-element" class="form-label">Card Number</label>
                                            <div id="card-number-element" class="form-control"></div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="card-expiry-element" class="form-label">Expiry Date</label>
                                            <div id="card-expiry-element" class="form-control"></div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="card-cvc-element" class="form-label">CVC</label>
                                            <div id="card-cvc-element" class="form-control"></div>
                                        </div>
                                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                        <div class="form-group">
                                            <button id="submit-payment" type="button" class="btn w-100" style="color: #C36; border: 1px solid #C36">Confirm the Payment and Place Order</button>
                                        </div>
                                    </div>
                                </div>
                  
                                <div class="float-end">
                                    <button id="place-order" class="nav-top-svg text-white shadow-0 border-white">Place Order</button>
                                </div>
                            </div>
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
                                            @if (isset($cartItem['productImage'][0]['path']))
                                                <img src="{{ env('SERVER_URL') }}storage/product_images/{{ $cartItem['productImage'][0]['path'] }}" class="card-img-top" alt="No image available" style="width: 40px;">
                                            @else
                                                <img src="{{ env('SERVER_URL') }}assets/theme/images/default_product_image.jpg" class="card-img-top" alt="No image available" style="width: 40px;">
                                            @endif
                                        </div>
                                            <div class="title-pro ms-3 w-100">
                                                <p class="mb-0">
                                                    {{ $cartItem['productTitle'] }}
                                                    <span class="text-end">{{ $currencySymbol . number_format($cartItem['rowTotal'], 2) }}</span>
                                                </p>
                                                <p class="mt-0 mb-0">{{ $currencySymbol . $cartItem['productPrice'] }}</p>
                                                <p class="mt-0">{{ $cartItem['optionNames'] ? implode(', ', $cartItem['optionNames']) : '' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 mb-3">
                        <p class="mb-0">Discount code</p>
                        <div class="input-group"> <!-- Use input-group for Bootstrap styling -->
                            <div class="form-outline">
                                <input type="text" id="discount_code" name="discount_code" class="form-control" style="text-transform: uppercase;" required/>
                            </div>
                            <button type="button" class="btn btn-primary" id="apply_discount">APPLY</button> <!-- Button next to input -->
                        </div>
                        <div id="discount_message" class="mt-2"></div>
                    </div>
                    <!-- temporary delivery charges -->
                    @if ($orderType == 'delivery' && ($cartSubTotal < $freeShippingAmount))
                        <h6>Delivery Charges <span> {{ $currencySymbol }}2.00</span></h6>
                        <p>(free over {{ $currencySymbol . $freeShippingAmount }})</p>
                        <h4>Total <span>{{ $currencySymbol }}<span class="total">{{ number_format($cartSubTotal + 2, 2) }}</span></span></h4>
                    @elseif ($orderType == 'delivery' && ($cartSubTotal > $freeShippingAmount))
                        <h6>Delivery Charges <span><del> {{ $currencySymbol }}2.00 </del></span></h6>
                        <p>(free over {{ $currencySymbol . $freeShippingAmount }})</p>
                        <h4>Total <span>{{ $currencySymbol }}<span class="total">{{ number_format($cartSubTotal, 2) }}</span></span></h4>
                    @else
                        <h4>Total <span>{{ $currencySymbol }}<span class="total">{{ $cartSubTotal }}</span></span></h4>
                    @endif
                    <div class="discount-div"></div>
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
            const stripe = Stripe(document.getElementById('stripe_key').value);
            const elements = stripe.elements();
    
            // Create individual elements for card number, expiry, and CVC
            const cardNumber = elements.create('cardNumber');
            const cardExpiry = elements.create('cardExpiry');
            const cardCvc = elements.create('cardCvc');
    
            // Mount elements to the corresponding divs
            cardNumber.mount('#card-number-element');
            cardExpiry.mount('#card-expiry-element');
            cardCvc.mount('#card-cvc-element');
    
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
    
            updatePaymentForm();
    
            document.querySelectorAll('input[name="payment_option"]').forEach(function(element) {
                element.addEventListener('change', updatePaymentForm);
            });
    
            document.getElementById('submit-payment').addEventListener('click', function(event) {
                event.preventDefault();
    
                const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;
    
                if (paymentOption === 'online') {
                    stripe.createPaymentMethod({
                        type: 'card',
                        card: cardNumber, // Attach the card number element
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
                    const form = document.getElementById('checkout-form');
                    form.submit();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="discount_code"]').on('input', function () {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            });

            $('#apply_discount').on('click', function () {
                const discountCode = $('#discount_code').val();

                if (discountCode) {
                    $.ajax({
                        url: '{{ route("discount.check") }}',
                        method: 'POST',
                        data: {
                            code: discountCode,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status) {
                                var detail = response.discountDetail;
                                var total = parseFloat($('.total').text());

                                if(detail.type == 1){
                                    if(total > detail.minimum_amount){
                                        var total = parseFloat($('.total').text());
                                        var discountRate = parseFloat(detail.rate);

                                        var discountAmount = (total * (discountRate / 100));
                                        
                                        if(total > discountAmount){
                                            var newTotal = total - discountAmount;
                                            $('#applied_code').val(discountCode);
                                            $('.discount-div').html('<h4>After Discount Total <span>'+@json($currencySymbol)+newTotal.toFixed(2)+'</span></h4>')
                                            $('#discount_message').text(`Discount applied: ${detail.rate}%`).removeClass('text-danger').addClass('text-success');
                                        }
                                        else{
                                            $('#applied_code').val('0');
                                            $('#discount_message').text(`Minimum order amount should be: ${detail.minimum_amount}`).removeClass('text-success').addClass('text-danger');
                                            $('.discount-div').empty();
                                        }
                                    }
                                    else{
                                        $('#applied_code').val('0');
                                        $('#discount_message').text(`Minimum order amount should be: ${detail.minimum_amount}`).removeClass('text-success').addClass('text-danger');
                                        $('.discount-div').empty();
                                    }
                                }
                                else if(detail.type == 2){
                                    if(total > detail.minimum_amount && total > detail.rate){
                                        var newTotal = total - detail.rate;
                                        $('#applied_code').val(discountCode);
                                        $('#discount_message').text(`Discount applied: ${detail.rate}`).removeClass('text-danger').addClass('text-success');
                                        $('.discount-div').html('<h4>After Discount Total <span>'+@json($currencySymbol)+newTotal.toFixed(2)+'</span></h4>');
                                    }
                                    else{
                                        $('#applied_code').val('0');
                                        $('#discount_message').text(`Minimum order amount should be: ${detail.minimum_amount}`).removeClass('text-success').addClass('text-danger');
                                        $('.discount-div').empty();
                                    }
                                }
                            } else {
                                $('#applied_code').val('0');
                                $('#discount_message').text(response.message).removeClass('text-success').addClass('text-danger');
                                $('.discount-div').empty();
                            }
                        },
                        error: function (xhr) {
                            $('#applied_code').val('0');
                            $('#discount_message').text('An error occurred. Please try again.').removeClass('text-success').addClass('text-danger');
                        }
                    });
                } else {
                    $('#applied_code').val('0');
                    $('#discount_message').text('Please enter a discount code.').removeClass('text-success').addClass('text-danger');
                    $('.discount-div').empty();
                }
            });
        });
    </script>

    @if ($orderType == 'delivery')
        <!-- Google Map -->
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places" async defer></script> --}}
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>

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
