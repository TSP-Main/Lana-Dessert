@extends('layout.app')

@section('title', $product['title'])

@section('content')
    <div class="main-content" data-aos="fade-down" data-aos-duration="1500">
        <div class="title">
            <h2>{{ $product['title'] }}</h2>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class=" w-75 modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Product title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="productId" />
                <input type="hidden" id="productDetail" data-product-detail="" />
                <div class="options"></div>
                <div class="instruction"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="addToCartButton" data-product-detail="">Add to cart</button>
            </div>
        </div>
        </div>
    </div>

    <div class="promo text-center my-5 py-5">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-duration="1500">
                @if ($response)
                    <div class="container mt-5">
                        <div class="row">
                            <!-- Product Image -->
                            <div class="col-md-6">
                                <img src="{{ env('SERVER_URL') }}storage/product_images/{{ $product['images'][0]['path'] }}" class="img-fluid" alt="Product Image">
                            </div>
                            
                            <!-- Product Details -->
                            <div class="col-md-6">
                                <h1>{{ $product['title'] }}</h1>
                                <p class="text-muted">{{ $product['category']['name']}}</p>
                                <h4>£{{ $product['price'] }}</h4>
                                <p>{{ $product['description']}}</p>
                    
                                <!-- Add to Cart Section -->
                                <div class="mt-4">
                                    <button type="button" id="openModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cartModal" data-product-detail="{{ json_encode($product) }}" data-product-title="{{ $product['title'] }}">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mount text-center mb-5">
                        <h2 class="text-danger">-----Api Error-----</h2>
                        <p>Configure APi Token</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }

    updateCartCount();

    // Ensure no multiple bindings
    $('#addToCartButton').off('click').on('click', function() {
        var productId = $('#productId').val();
        var productDetail = $('#productDetail').data('product-detail');
        var productInstruction = $('#productInstruction').val() ?? null;
        var selectedOptions = {};
        var selectedOptionNames = [];
        var valid = true;

        $('.option-group').each(function() {
            var optionGroupId = $(this).data('option-id');
            var optionType = $(this).find('h6').text().includes('(Required)') ? 1 : 2;

            var selectedOption = [];
            if (optionType == 1) {
                var checkedRadio = $(this).find('input[type=radio]:checked');
                if (checkedRadio.length === 0) {
                    valid = false;
                    $(this).find('.required-warning').removeClass('d-none');
                } else {
                    $(this).find('.required-warning').addClass('d-none');
                    selectedOption.push(checkedRadio.val());
                    selectedOptionNames.push(checkedRadio.data('option-name'));
                }
            } else {
                $(this).find('input[type=checkbox]:checked').each(function() {
                    selectedOption.push($(this).val());
                    selectedOptionNames.push($(this).data('option-name'));
                });
            }

            if (selectedOption.length > 0) {
                selectedOptions[optionGroupId] = selectedOption;
            }
        });

        if (valid) {
            var cartData = {
                product_id: productId,
                options: selectedOptions,
                optionNames: selectedOptionNames,
                product_detail: productDetail,
                product_instruction: productInstruction
            };

            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": cartData
                },
                success: function(response) {
                    alert('Product added to cart successfully!');
                    $('#cartModal').modal('hide');
                    updateCartCount(); // Update cart count after adding item
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('There was an error adding the product to the cart.');
                }
            });
        }
    });

    $('#cartModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var productTitle = button.data('product-title');
        var productDetail = button.data('product-detail');

        var modal = $(this);
        modal.find('.modal-title').text(productTitle);
        modal.find('#productId').val(productDetail.id);
        modal.find('#productDetail').data('product-detail', productDetail);

        var optionsHtml = '';
        var instructionHtml = '';
        if (productDetail.options && productDetail.options.length > 0) {
            productDetail.options.forEach(function(optionGroup) {
                optionsHtml += '<div class="option-group" data-option-id="' + optionGroup.option.id + '">';
                optionsHtml += '<h6>' + optionGroup.option.name;
                
                // Show required or optional based on option type
                if (optionGroup.option.option_type == 1) {
                    optionsHtml += ' (Required)';
                } else if (optionGroup.option.option_type == 2) {
                    optionsHtml += ' (Optional)';
                }
                optionsHtml += '</h6>';
                
                // Add warning message for required options
                if (optionGroup.option.option_type == 1) {
                    optionsHtml += '<p class="text-danger d-none required-warning" data-option-id="' + optionGroup.option.id + '">Please select one option.</p>';
                }

                if (optionGroup.option.option_values && optionGroup.option.option_values.length > 0) {
                    optionGroup.option.option_values.forEach(function(optionValue) {
                        optionsHtml += '<div class=" p-0 form-check d-flex bd-highlight mb-3  align-items-center">';
                        
                        // Use radio buttons for option type 1
                        if (optionGroup.option.option_type == 1) {
                            optionsHtml += '<input class=" ms-2 p-2 bd-highlight" type="radio" name="option_' + optionGroup.option.id + '" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                        } 
                        // Use checkboxes for option type 2
                        else if (optionGroup.option.option_type == 2) {
                            optionsHtml += '<input class=" ms-2 p-2 bd-highlight" type="checkbox" name="option_' + optionGroup.option.id + '[]" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                        }

                        optionsHtml += '<label class=" ms-2 form-check-label" for="option_' + optionValue.id + '">' + optionValue.name + '</label>';
                        if (optionValue.price) {
                            optionsHtml += '<span class="ms-auto p-2 bd-highlight" >$' + optionValue.price + '</span>';
                        }
                        optionsHtml += '</div>';
                    });
                }
                optionsHtml += '</div>';
            });
        } else {
            optionsHtml = '<p>No options available for this product.</p>';
        }

        if(productDetail.ask_instruction == 1){
            instructionHtml = '<hr><textarea name="productInstruction" id="productInstruction" class="form-control" rows="3" placeholder="Enter any special instructions here..."></textarea>';
        } else {
            
        }
        modal.find('.options').html(optionsHtml);
        modal.find('.instruction').html(instructionHtml);
    });
});

</script>
@endsection
