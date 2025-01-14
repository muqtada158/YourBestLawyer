@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Update Card Details')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-attorney')

                    </div>
                    <div class="customer-portal-content py-3">
                        <div class="row">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Update Card Details</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="card border-0 radius-10 pt-4 pb-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <form id="payment-form" action="{{ route('attorney_update_card_details_store') }}"
                                                    method="POST" enctype="multipart/form-data">@csrf
                                                    <div class="row mt-4">
                                                        <div class="col-sm-12">
                                                            <label class="font-18 mb-2" for="card-number">Card
                                                                Number:</label>
                                                            <input name="credit-card" placeholder="Card number"
                                                                id="card-number"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="text">
                                                            <span id="card-number-error" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="expiry-date">Expiry:</label>
                                                            <input name="expiry-date" placeholder="Expiry Date"
                                                                id="expiry-date"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="text">
                                                            <span id="expiry-date-error" class="text-danger"></span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="cvc">CVC /
                                                                CVV:</label>
                                                            <input name="cvc" placeholder="CVC / CVV" id="cvc"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="password">
                                                            <span id="cvc-error" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="btn btn-primary text-white py-2 px-5 font-20 radius-10"
                                                            type="submit">Update Card</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $("#card-number").mask('0000 0000 0000 0000');
        $("#expiry-date").mask('00/00');
        $("#cvc").mask("000")
    </script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        // Stripe publishable key
        var stripePublishableKey = '{{ config('services.stripe.publishable') }}';

        // Initialize Stripe with your publishable key
        Stripe.setPublishableKey(stripePublishableKey);

        // Masking for card details
        $("#card-number").mask('0000 0000 0000 0000');
        $("#expiry-date").mask('00/00');
        $("#cvc").mask("000");

        // Function to handle form submission
        function handleFormSubmission(e) {
            e.preventDefault(); // Prevent default form submission

            // Validate card details
            var cardNumber = $('#card-number').val();
            var cardExpiry = $('#expiry-date').val();
            var cardCvc = $('#cvc').val();
            var errors = false;

            // Perform client-side validation
            if (!Stripe.card.validateCardNumber(cardNumber)) {
                $('#card-number-error').text('Invalid card number');
                errors = true;
            } else {
                $('#card-number-error').text('');
            }

            if (!Stripe.card.validateExpiry(cardExpiry)) {
                $('#expiry-date-error').text('Invalid expiry date');
                errors = true;
            } else {
                $('#expiry-date-error').text('');
            }

            if (!Stripe.card.validateCVC(cardCvc)) {
                $('#cvc-error').text('Invalid CVC');
                errors = true;
            } else {
                $('#cvc-error').text('');
            }

            if (!errors) {
                // If all validations pass, create token
                Stripe.card.createToken({
                    number: cardNumber,
                    cvc: cardCvc,
                    exp: cardExpiry
                }, function(status, response) {
                    if (response.error) {
                        // Error from Stripe
                        // Display error message or take appropriate action
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error.message
                        });
                    } else {
                        // Token successfully created
                        var token = response.id;
                        // Optionally, send token to server or use it as needed
                        console.log('Stripe Token:', token);
                        $('#payment-form').append('<input type="hidden" name="stripeToken" value="' + token + '">');
                        $('#payment-form').off('submit')
                    .submit(); // Unbind the submit event handler and submit the form
                    }
                });
            }
        }

        // Bind form submission to the handler
        $('#payment-form').on('submit', handleFormSubmission);
    </script>
@endpush
