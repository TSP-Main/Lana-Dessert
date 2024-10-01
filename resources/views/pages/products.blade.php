@extends('layout.app')

{{-- @section('title', ucfirst($category) ) --}}
@section('title', isset($category) ? ucfirst($category) : '')

@section('content')
    @php
        $bannerUrl = $categoryDetail['banner_image'] ? env('SERVER_URL') . 'storage/' . $categoryDetail['banner_image'] : env('SERVER_URL') .'assets/theme/images/banners/default_banner.webp';
    @endphp

    <!-- style="background: url({{ $bannerUrl }} )" -->
    <div class="main-content" data-aos="fade-down" data-aos-duration="1500">
        <div class="title">
            <h2 style="font-weight: bold; font-size: 3rem;">{{ isset($category) ? ucfirst($category) : '' }}</h2>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class=" w-100 modal-content">
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
                <button type="button" class="nav-top-svg" id="addToCartButton" data-product-detail=""  style="border-color: white; color: white; text-decoration: none;">Add to cart</button>
            </div>
        </div>
        </div>
    </div>

    <div class="promo text-center my-5 py-5">
    <!-- <h2 class="special">{{ isset($category) ? ucfirst($category) : '' }}</h2> -->
    <div class="container mt-5 pt-5">
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
            @foreach ($products as $product)
                <!-- Adjusting column classes for different screen sizes and adding margin on mobile -->
                <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                    <div class="card bg-body" style="width: 90%; max-width: 18rem; border-radius: 0 60px 0 0; margin: 0 10px;">
                        @if (isset($product['images'][0]['path']))
                        <a href="{{ route('product.detail', [$product['id']]) }}">
                            <img src="{{ env('SERVER_URL') }}storage/product_images/{{ $product['images'][0]['path'] }}" 
                                class="card-img-top" 
                                alt="{{ $product['title'] }}" 
                                style="border-top-right-radius: 60px;">
                        </a>
                        @else
                        <a href="{{ route('product.detail', [$product['id']]) }}">
                            <img src="{{ env('SERVER_URL') }}assets/theme/images/default_product_image.jpg" 
                                class="card-img-top" 
                                alt="No image available">
                        </a>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <a href="{{ route('product.detail', [$product['id']])}}" style="color: #c36; text-decoration: none;">
                                    {{ $product['title'] }}
                                </a>
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">{{$currencySymbol}}{{$product['price']}}</span>
                                <button type="button" id="openModal" class="nav-top-svg" data-bs-toggle="modal" data-bs-target="#cartModal" data-product-detail="{{ json_encode($product) }}" data-product-title="{{ $product['title'] }}" style="border-color: white; color: white; text-decoration: none;">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach    
        @else
            <div class="mount text-center mb-5">
                <h2 class="text-danger">-----No Data Found-----</h2>
                {{-- <p>Configure API Token</p> --}}
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
                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1050;">' +
                                    'Product added to cart successfully!' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                    '</div>';
                    $('body').append(alertHtml);
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 2000); 
                    $('#cartModal').modal('hide');
                    // Update cart count after adding item
                    updateCartCount();
                },
                // error: function(xhr, status, error) {
                //     console.error(error);
                //     alert('There was an error adding the product to the cart.');
                // }
                error: function(xhr, status, error) {
                    console.error(error);
                    var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1050;">' +
                                    'There was an error adding the product to the cart. Please try again later.' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                    '</div>';

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
        optionsHtml += '<div class="accordion" id="optionsAccordion">';

        productDetail.options.forEach(function(optionGroup, index) {
            optionsHtml += '<div class="accordion-item">';
            optionsHtml += '<h2 class="accordion-header" id="heading' + index + '">';
            optionsHtml += '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + index + '" aria-expanded="true" aria-controls="collapse' + index + '">';
            optionsHtml += optionGroup.option.name;

            if (optionGroup.option.option_type == 1) {
                optionsHtml += ' (Required)';
            } else if (optionGroup.option.option_type == 2) {
                optionsHtml += ' (Optional)';
            }

            optionsHtml += '</button></h2>';
            optionsHtml += '<div id="collapse' + index + '" class="accordion-collapse collapse show" aria-labelledby="heading' + index + '" data-bs-parent="#optionsAccordion">';
            optionsHtml += '<div class="accordion-body">';

            // Add warning message for required options
            if (optionGroup.option.option_type == 1) {
                optionsHtml += '<p class="text-danger d-none required-warning" data-option-id="' + optionGroup.option.id + '">Please select one option.</p>';
            }

            if (optionGroup.option.option_values && optionGroup.option.option_values.length > 0) {
                optionGroup.option.option_values.forEach(function(optionValue) {
                    optionsHtml += '<div class="p-0 form-check d-flex bd-highlight mb-3 align-items-center border border-1">';
                    
                    // Use radio buttons for option type 1
                    if (optionGroup.option.option_type == 1) {
                        optionsHtml += '<input class="ms-2 p-2 bd-highlight" type="radio" name="option_' + optionGroup.option.id + '" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                    } 
                    // Use checkboxes for option type 2
                    else if (optionGroup.option.option_type == 2) {
                        optionsHtml += '<input class="ms-2 p-2 bd-highlight" type="checkbox" name="option_' + optionGroup.option.id + '[]" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                    }

                    optionsHtml += '<label class="ms-2 form-check-label" for="option_' + optionValue.id + '">' + optionValue.name + '</label>';
                    if (optionValue.price) {
                        optionsHtml += '<span class="ms-auto p-2 bd-highlight">' + currencySymbol + optionValue.price + '</span>';
                    }
                    optionsHtml += '</div>';
                });
            }
            optionsHtml += '</div></div></div>';
        });

        optionsHtml += '</div>'; // End of accordion
    } else {
        optionsHtml = '';
    }

    if (productDetail.ask_instruction == 1) {
        instructionHtml = '<hr><textarea name="productInstruction" id="productInstruction" class="form-control" rows="3" placeholder="Enter any special instructions here..."></textarea>';
    } else {
        instructionHtml = '';
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
     
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection
