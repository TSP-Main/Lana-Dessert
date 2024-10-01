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
                <button type="button" class="nav-top-svg" id="addToCartButton" data-product-detail="" style="border-color: white; color: white; text-decoration: none;">Add to cart</button>
            </div>
        </div>
        </div>
    </div>

    <div class="promo text-center my-5 py-5">
        <div class="container">
            <!-- Navigation Row with Scroll Arrows -->
            <div class="position-relative">
                <div class="row mb-4">
                    <div class="col-12">
                        <!-- Navigation Container -->
                        <div style="display: flex; justify-content: center; padding-left: 20px; padding-right: 20px;">
                            <div class="scrollable-nav" style="display: flex; overflow: auto; width: 95%; white-space: nowrap; scroll-behavior: smooth;">
                                @foreach ($menus as $menu)
                                <a 
                                    class="nav-link mr-3 mr-sm-n3 fw-bold text-dark"
                                    href="{{ route('menu', ['category' => $menu['attributes']['slug']]) }}"
                                    data-scroll-to="{{ $menu['attributes']['slug'] }}" 
                                    style="font-size: 20px; text-decoration: none;">
                                    {{ $menu['attributes']['name'] }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <button class="position-absolute top-50 start-0 translate-middle-y scroll-btn" id="scroll-left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                        </button>
                    
                        <button class="position-absolute top-50 end-0 translate-middle-y scroll-btn" id="scroll-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" data-aos="fade-up" data-aos-duration="1500">
                @if ($response)
                    <div class="container mt-5">
                        <div class="row">
                            <!-- Product Image -->
                            <div class="col-md-6">
                                @if ($product['images'])
                                    <img src="{{ env('SERVER_URL') }}storage/product_images/{{ $product['images'][0]['path'] }}" class="img-fluid" alt="Product Image" style="border-top-right-radius: 80px;">
                                @else
                                    <img src="{{ env('SERVER_URL') }}assets/theme/images/default_product_image.jpg" class="img-fluid" alt="Product Image" style="border-top-right-radius: 0px;">
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="col-md-6">
                                <h1 style="color: #c36;">{{ $product['title'] }}</h1>
                                <p class="text-muted">{{ $product['category']['name']}}</p>
                                <h4 style="color: #c36;">{{ $currencySymbol . $product['price'] }}</h4>
                                <p>{{ $product['description']}}</p>
                    
                                <!-- Add to Cart Section -->
                                <div class="mt-4">
                                <button type="button" id="openModal" class="nav-top-svg text-white border-white" data-bs-toggle="modal" data-bs-target="#cartModal" data-product-detail="{{ json_encode($product) }}" data-product-title="{{ $product['title'] }}">
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
        var currencySymbol = @json($currencySymbol);

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
                            optionsHtml += '<span class="ms-auto p-2 bd-highlight" >' + currencySymbol + optionValue.price + '</span>';
                        }
                        optionsHtml += '</div>';
                    });
                }
                optionsHtml += '</div>';
            });
        } else {
            optionsHtml = '';
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const scrollableNav = document.querySelector('.scrollable-nav');
            const scrollLeftButton = document.getElementById('scroll-left');
            const scrollRightButton = document.getElementById('scroll-right');

            scrollLeftButton.addEventListener('click', () => {
                scrollableNav.scrollBy({
                    left: -200, // Adjust scroll amount as needed
                    behavior: 'smooth'
                });
            });

            scrollRightButton.addEventListener('click', () => {
                scrollableNav.scrollBy({
                    left: 200, // Adjust scroll amount as needed
                    behavior: 'smooth'
                });
            });
        });
</script>
@endsection
