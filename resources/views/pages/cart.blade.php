@extends('layout.app')
@section('title', 'Cart')

@section('content')
<div class="about-us-main" data-aos="fade-down" data-aos-duration="1500" style="text-align: center; display: flex; justify-content: center; align-items: center;">
    <div class="container" style="text-align: center; display: flex; justify-content: center; align-items: center;">
        <h2 class="about-title" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Cart</h2>
    </div>
</div>

<div class="cart-sec pt-3 pb-5">
    <div class="container">
        @if ($cartItems)
            <div class="row">
                <div class="col-md-8">
                    <div class="product-total">
                        <h5 class="d-flex justify-content-between">
                            Product <span>Total</span>
                        </h5>
                        <hr class="border border-secondary">
                        @foreach ($cartItems as $cartItem)
                            <div class="d-flex flex-column">
                                <!-- Product Title -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">{{ $cartItem['productTitle'] }}</h4>

                                    <!-- Total Price -->
                                    <span class="fw-bold fs-5" id="row-total-{{ $cartItem['rowId'] }}">£ {{ $cartItem['rowTotal']}}</span>
                                </div>

                                <!-- Counter Row -->
                                <div class="d-flex justify-content-center align-items-center my-2">
                                    <button type="button" onclick="updateQuantity({{ $cartItem['rowId'] }}, -1)" class="btn btn-outline-secondary btn-sm btn-counter" style="width: 30px; height: 30px;">-</button>

                                    <input type="number" id="quantity-{{ $cartItem['rowId'] }}" name="quantity" min="1" value="{{ $cartItem['quantity'] }}" readonly class="form-control text-center text-lg" style="width: 50px; height: 30px;">

                                    <button type="button" onclick="updateQuantity({{ $cartItem['rowId'] }}, 1)" class="btn btn-outline-secondary btn-sm btn-counter" style="width: 30px; height: 30px;">+</button>
                                </div>

                                <!-- Delete Button and Product Price Row -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Product Price -->
                                    <p class="mb-0">£ {{ $cartItem['productPrice'] }}</p>

                                    <!-- Delete button -->
                                    <a href="javascript:void(0)" onclick="removeItemCart({{ $cartItem['rowId'] }})" id="remove-{{ $cartItem['rowId'] }}" class="d-flex align-items-center text-danger ms-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                        </svg>
                                    </a>
                                </div>

                                <!-- Options (if any) -->
                                <p class="mb-1 mt-2">{{ $cartItem['optionNames'] ? implode(', ', $cartItem['optionNames']) : '' }}</p>

                                <hr class="border border-secondary">
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-md-4" style="background-color: #f7f9f9;">
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <div class="cart-total">
                            <h5 style="text-align: center;">Order Summary</h5>
                            <hr style="border: 1px solid #ccc;">
                            <p>Sub Total <span id="cart-sub-total">£ {{ $cartSubTotal }}</span></p>
                            <hr style="border: 1px solid #ccc;">
                            <div class="form-group">
                                <label for="order_type" style="display: block; margin-bottom: 5px;">Choose order type:</label>
                                <div>
                                    <label style="display: block; border: 1px solid #bdc1b2; margin-bottom: 16px; padding: 8px; box-sizing: border-box;">
                                        <input type="radio" id="pickup" name="order_type" value="pickup" {{ session('orderType') == 'pickup' ? 'checked' : '' }} style="margin-right: 8px;">
                                        Pickup
                                    </label>
                                    <label style="display: block; border: 1px solid #bdc1b2; padding: 8px; box-sizing: border-box;">
                                        <input type="radio" id="delivery" name="order_type" value="delivery" {{ session('orderType') == 'delivery' ? 'checked' : '' }} style="margin-right: 8px;">
                                        Delivery
                                    </label>
                                    @error('order_type')
                                        <div class="text-danger" style="color: #dc3545; margin-top: 8px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                                                        <hr style="border: 1px solid #ccc;">
                            <h4>Total <span id="total">£ {{ $cartSubTotal }}</span></h4>
                        </div>
                        <hr style="border: 1px solid #ccc;">
                        <button class="nav-top-svg text-white border-white" type="submit" style="width: 90%;">Checkout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="row">
                <h2 class="text-center">Your cart is empty</h2>
            </div>
        @endif
    </div>
 </div>
@endsection

@section('script')
    <script>
        function updateQuantity(rowId, change) {
            const quantityInput = document.getElementById('quantity-' + rowId);
            let quantity = parseInt(quantityInput.value);
            quantity += change;
            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;

            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    row_id: rowId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        $('#row-total-'+rowId).text('£ ' + response.rowTotal.toFixed(2));
                        $('#cart-sub-total').text('£ ' + response.cartSubTotal.toFixed(2));
                        $('#total').text('£ ' + response.cartSubTotal.toFixed(2));
                    }
                }
            });
        }

        function removeItemCart(rowId){
            if (confirm('Are you sure you want to remove this item from the cart?')) {
                $.ajax({
                    url: '{{ route("cart.delete") }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        row_id: rowId,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                        alert('Failed to remove item. Please try again.');
                    }
                });
            }
        }
    </script>
@endsection
