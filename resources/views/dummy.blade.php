<!-- Stripe code for after accept payment -->
{{-- <script>
    document.getElementById('submit-payment').addEventListener('click', function(event) {
        event.preventDefault();

        const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;

        if (paymentOption === 'online') {
            stripe.createPaymentMethod({
                type: 'card',
                card: cardNumber,
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

                    // Submit the form with payment_method_id (no charge yet)
                    form.submit();
                }
            }).catch(function(error) {
                console.error('Error creating PaymentMethod:', error);
            });
        } else {
            const form = document.getElementById('checkout-form');
            form.submit();
        }
    });
</script> --}}