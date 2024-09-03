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
                        <h5>Product <span style="float: right;">Total</span></h5>
                        <hr style="border: 1px solid #ccc;">
                        @foreach ($cartItems as $cartItem)                                        
                            <div style="display: flex;">
                                <div class="title-pro ms-3 w-100">
                                    <h4 style="">{{ $cartItem['productTitle'] }} 
                                        <div class="quantity-control input-group" style="margin-top: -20px; margin-bottom: 10px; display: flex; justify-content: flex-end; align-items: center;">
                                            <button type="button" onclick="updateQuantity({{ $cartItem['rowId'] }}, -1)" style="width: 30px; height: 30px; font-size: 18px; border: 1px solid #ccc; background-color: #f0f0f0; cursor: pointer;">-</button>
                                            <input type="number" id="quantity-{{ $cartItem['rowId'] }}" name="quantity" min="1" value="{{ $cartItem['quantity'] }}" readonly style="width: 42px; text-align: center; border: 1px solid #ccc; border-left: 0; border-right: 0; height: 30px;">
                                            <button type="button" onclick="updateQuantity({{ $cartItem['rowId'] }}, 1)" style="width: 30px; height: 30px; font-size: 18px; border: 1px solid #ccc; background-color: #f0f0f0; cursor: pointer;">+</button>
                                        </div>
                                        <span style="float: right;" id="row-total-{{ $cartItem['rowId'] }}">£ {{ $cartItem['rowTotal']}}</span>
                                    </h4>
                                    <p style="margin-top: 0; margin-bottom: 5px;">£ {{ $cartItem['productPrice'] }}</p>
                                    <p style="margin-top: 0; margin-bottom: 5px;">{{ $cartItem['optionNames'] ? implode(', ', $cartItem['optionNames']) : '' }}</p>
                                    <a href="javascript:void(0)" onclick="removeItemCart({{ $cartItem['rowId'] }})" id="remove-{{ $cartItem['rowId'] }}" class="nav-top-svg" style="color: white; text-decoration: none; display: flex; align-items: center; width: 40px; margin: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16" style="text-color: #c36">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                    </a>
                                </div>
                            </div>
                            <hr style="border: 1px solid #ccc;">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4" style="background-color: #f7f9f9;">
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <div class="cart-total">
                            <h5 style="text-align: right;">Cart Totals</h5>
                            <hr style="border: 1px solid #ccc;">
                            <p>Sub Total <span id="cart-sub-total">£ {{ $cartSubTotal }}</span></p>
                            <hr style="border: 1px solid #ccc;">
                            <div class="form-group">
                                <label for="order_type" style="display: block; margin-bottom: 5px;">Choose order type:</label>
                                <div>
                                    <label style="display: block;">
                                        <input type="radio" id="pickup" name="order_type" value="pickup" {{ session('orderType') == 'pickup' ? 'checked' : '' }} style="margin-left: 16px;">
                                        Pickup
                                    </label>
                                    <label class="ms-3" style="display: block;">
                                        <input type="radio" id="delivery" name="order_type" value="delivery" {{ session('orderType') == 'delivery' ? 'checked' : '' }} >
                                        Delivery
                                    </label>
                                    @error('order_type')
                                        <div class="text-danger" style="color: #dc3545;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr style="border: 1px solid #ccc;">
                            <h4>Total <span id="total">£ {{ $cartSubTotal }}</span></h4>
                        </div>
                        <hr style="border: 1px solid #ccc;">
                        <button class="nav-top-svg text-white border-white" type="submit">Checkout</button>
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
