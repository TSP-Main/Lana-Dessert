{{-- <script src="{{ asset('assets/theme/js/main.js') }}"></script>  --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script>
        AOS.init();
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        let endValue = counter.textContent;
                        let startValue = 0;
                        let updating = setInterval(() => {
                            startValue += endValue / 200;
                            counter.textContent = startValue.toFixed(0);
                            if (startValue > endValue) {
                                counter.textContent = endValue;
                                clearInterval(updating);
                                observer.unobserve(counter);
                            }
                        }, 10);
                    }
                });
            },
            { threshold: 1 }
        );
        document
            .querySelectorAll(".counter")
            .forEach((counter) => observer.observe(counter));

        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            const navTop = document.querySelector('.nav-top');
            const navTopHeight = navTop.offsetHeight;

            if (window.scrollY >= navTopHeight) {
                navbar.classList.add('fixed-top-scroll');
            } else {
                navbar.classList.remove('fixed-top-scroll');
            }
        });

        $(document).ready(function(){
            $('#btn_newsletter').on('click', function () {
                var email = $('#email').val();
                $.ajax({
                    url: '{{ route("newsletter.subscribe") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                    },
                    success: function(response) {
                        if(response.status == 'success'){
                            $('.sub-email').val('');
                            $('.subscription_msg').text('Thank You for Subscription!').show();
                            setTimeout(function() {
                                $('.subscription_msg').fadeOut();
                            }, 4000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('.subscription_msg').text(errors.email[0]).show();
                                setTimeout(function() {
                                    $('.subscription_msg').fadeOut();
                                }, 4000);
                            }
                        }
                    }
                });
            });

            $('#search-icon').click(function() {
                $('#search-input').toggle().focus().val('');
                $('#suggestions').hide();
            });

            $('#search-input').on('keyup', function() {
                let query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: '{{ route("search.product") }}',
                        type: 'GET',
                        data: { title: query },
                        success: function(data) {
                            $('#suggestions').empty().show();
                            data.forEach(function(product) {
                                $('#suggestions').append(`
                                    <li class="list-group-item">
                                        <a href="{{ url('/product_detail') }}/${product.id}" style="text-decoration: none; color: inherit;">
                                            ${product.title}
                                        </a>
                                    </li>
                                `);
                            });
                        }
                    });
                } else {
                    $('#suggestions').hide();
                }
            });

            $(document).click(function(event) {
                if (!$(event.target).closest('#search-input, #search-icon, #suggestions').length) {
                    $('#search-input').hide();
                    $('#suggestions').hide();
                }
            });
        });

    </script>
