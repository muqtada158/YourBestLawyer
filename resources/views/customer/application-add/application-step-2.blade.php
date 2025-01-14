@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application Bid')

@section('content')

    @push('css')
        <style>
            .hidden {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s ease-out;
            }

            .visible {
                max-height: 1000px;
                /* Adjust as necessary to fit the content */
                transition: max-height 0.5s ease-in;
            }
        </style>
    @endpush
    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">

                        @include('layouts.sidebar-customer')

                    </div>
                    <div class="customer-portal-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card radius-20 border-0">
                                        <div class="card-body p-4">
                                            <div class="customer-portal-content p-4">
                                                    <div class="row" class="step">
                                                        <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Payment
                                                            Details</h2>
                                                        <div
                                                            class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                                            <div class="circle-icon circle-icon-small step-check active"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check active"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                        </div>
                                                        <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                                            <div class="container">
                                                                @if ($paymentDetails)
                                                                    <div class="row mt-4">
                                                                        <div class="card border-1 radius-20 mt-4">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <h3 class="font-primary">Note :</h3>
                                                                                        @if ($case->case_type == 3)
                                                                                            <h4 class="font-primary">Your card will not be charged. This is simply to verify that you are a real person, not a computer.</h4>
                                                                                        @else
                                                                                            <h4 class="font-primary">Your card will be charged after you choose an attorney and sign a legal agreement.</h4>
                                                                                        @endif
                                                                                        <h5
                                                                                            class="font-primary text-success">
                                                                                            Your card has been attached
                                                                                            successfully.</h5>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-4">
                                                                        <div class="card border-1 radius-20 mt-4">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <h3 class="font-primary">Card Ending
                                                                                            in
                                                                                            {{ $paymentDetails->card_last_four }}
                                                                                        </h3>
                                                                                        <h5 class="font-primary">Expiry
                                                                                            {{ $paymentDetails->card_expiry_month }}
                                                                                            /
                                                                                            {{ $paymentDetails->card_expiry_year }}
                                                                                        </h5>
                                                                                        <h4 class="font-primary">***</h4>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="row mt-4">
                                                                        <div class="card border-1 radius-20 mt-4">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <h3 class="font-primary">Note :</h3>
                                                                                        @if ($case->case_type == 3)
                                                                                            <h4 class="font-primary">Your card will not be charged. This is simply to verify that you are a real person, not a computer.</h4>
                                                                                        @else
                                                                                            <h4 class="font-primary">Your card will be charged after you choose an attorney and sign a legal agreement.</h4>
                                                                                        @endif
                                                                                        <h5 class="font- text-danger">No
                                                                                            card is associated with your
                                                                                            account. Kindly attach a card to
                                                                                            proceed.</h5>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12">
                                                                        @if (!$paymentDetails)
                                                                            <div class="row mt-2">
                                                                                <div class="col-md-12">
                                                                                    <form id="payment-form"
                                                                                        action="{{ route('customer_card_store') }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">@csrf
                                                                                        <div class="row mt-4">
                                                                                            <div class="col-sm-6">
                                                                                                <label class="font-18 mb-2"
                                                                                                    for="client-name">Card
                                                                                                    Holder Name:</label>
                                                                                                <input name="client_name"
                                                                                                    value="{{ auth()->user()->getUserDetails->first_name }} {{ auth()->user()->getUserDetails->last_name }}"
                                                                                                    placeholder="Card holder name"
                                                                                                    id="client-name"
                                                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                                                    type="text">
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <label class="font-18 mb-2"
                                                                                                    for="client-email">Card
                                                                                                    Holder Email:</label>
                                                                                                <input name="client_email"
                                                                                                    value="{{ auth()->user()->email }}"
                                                                                                    placeholder="Card holder email"
                                                                                                    id="client-email"
                                                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                                                    type="email">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-4">
                                                                                            <div class="col-sm-12">
                                                                                                <label class="font-18 mb-2"
                                                                                                    for="card-number">Card
                                                                                                    Number:</label>
                                                                                                <input name="credit-card"
                                                                                                    placeholder="Card number"
                                                                                                    id="card-number"
                                                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                                                    type="text">
                                                                                                <span id="card-number-error"
                                                                                                    class="text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-4">
                                                                                            <div class="col-sm-6">
                                                                                                <label class="font-18 mb-2"
                                                                                                    for="expiry-date">Expiry:</label>
                                                                                                <input name="expiry-date"
                                                                                                    placeholder="Expiry Date"
                                                                                                    id="expiry-date"
                                                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                                                    type="text">
                                                                                                <span
                                                                                                    id="expiry-date-error"
                                                                                                    class="text-danger"></span>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <label class="font-18 mb-2"
                                                                                                    for="cvc">CVC /
                                                                                                    CVV:</label>
                                                                                                <input name="cvc"
                                                                                                    placeholder="CVC / CVV"
                                                                                                    id="cvc"
                                                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                                                    type="password">
                                                                                                <span id="cvc-error"
                                                                                                    class="text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="text-center mt-3">
                                                                                            <button
                                                                                                class="btn btn-primary text-white py-2 px-5 font-20 radius-10"
                                                                                                type="submit">Attach</button>
                                                                                        </div>
                                                                                    </form>

                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <form
                                                                                action="{{ route('customer_dashboard_payment_bid_store') }}"
                                                                                method="POST"> @csrf
                                                                                <div class="text-end mt-4">
                                                                                    <button
                                                                                        class="align-self-end btn btn-primary text-white py-2 px-5 font-20 radius-10"
                                                                                        type="submit"  onclick="showLoader();">Continue</button>
                                                                                </div>
                                                                            </form>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
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
            // Delete specific cookies
            deleteCookie('cookie_case_id');
            deleteCookie('cookie_case_sub_id');
            deleteCookie('cookie_package_id');
        </script>


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
