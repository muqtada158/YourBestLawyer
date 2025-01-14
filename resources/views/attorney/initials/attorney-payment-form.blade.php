@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Payment Form')

@section('content')
    @push('css')
        <style>
            img.w-100 {
                border-radius: 50px;
                border: 1px #b38e6a solid;
            }
        </style>
    @endpush
    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                    <div class="customer-portal-content py-3">

                        <div class="row" class="step">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Onboard with stripe</h2>
                            <div
                                class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i
                                        class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i
                                        class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i
                                        class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check "><i class="fa-solid fa-check"></i>
                                </div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check "><i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="container">
                                    @if (isset($paymentDetails) and $paymentDetails->stripe_customer_id !== null)
                                        <div class="row">
                                            <div class="offset-md-12">
                                                <div class="card border-1 radius-20 mt-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h3 class="font-primary">Note :</h3>
                                                                <h5 class="font-primary">Your card has been securely stored and charged only for payments on accepted leads with signed fee agreements.</h5>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-2">
                                                            <div class="col-md-10">
                                                                <h4 class="font-primary">Card Ending
                                                                    in
                                                                    <span class="fw-bold">{{ $paymentDetails->card_last_four }}</span>
                                                                </h4>
                                                                <h5 class="font-primary">Expiry
                                                                    <span class="fw-bold">{{ $paymentDetails->card_expiry_month }}
                                                                    /
                                                                    {{ $paymentDetails->card_expiry_year }}</span>
                                                                </h5>
                                                                <h5 class="font-primary">CVC <span class="fw-bold">***</span></h5>
                                                                <h5 class="font-primary text-success">
                                                                    Your card has been attached
                                                                    successfully.</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('attorney_payment_form_store') }}" method="POST"
                                            enctype="multipart/form-data" class="mt-4">@csrf
                                            <div class="row mt-4 text-center">
                                                <h4 class="font-primary">Now it's time to set up your Stripe account to receive payments directly from clients.</h4>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="offset-md-2 col-md-8">
                                                    <img src="{{ asset('images/Stripe-Onboarding.jpg') }}" class="w-100"
                                                        alt="">
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="offset-md-3 col-md-6">
                                                    <div class="social-login mt-4">
                                                        <a href="{{ $url }}" onclick="showLoader();"
                                                            class="btn button-accent btn-accent-secondary w-100 mt-2">
                                                            <span><img src="{{ asset('images/svg/stripe.svg') }}"
                                                                    class="me-2 me-md-4" alt="Stripe"> <span
                                                                    class="d-none d-md-inline-block">Onboard with</span>
                                                                Stripe</span>
                                                            <span class="btn-arrow">
                                                                <i class="fa-solid fa-chevron-right text-white"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="font-primary">Note :</h3>
                                            <h5 class="font-primary">Your card will be securely stored and charged only for payments on accepted leads with signed fee agreements.
                                            </br>
                                            Kindly attach your card to YourBestLawyer.com account.
                                            </h5>

                                        </div>
                                    </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <form id="payment-form" action="{{ route('attorney_card_store') }}"
                                                    method="POST" enctype="multipart/form-data">@csrf
                                                    <div class="row mt-4">
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="client-name">Card
                                                                Holder Name:</label>
                                                            <input name="client_name"
                                                                value="{{ auth()->user()->getUserDetails->first_name }} {{ auth()->user()->getUserDetails->last_name }}"
                                                                placeholder="Card holder name" id="client-name"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="text">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="client-email">Card
                                                                Holder Email:</label>
                                                            <input name="client_email" value="{{ auth()->user()->email }}"
                                                                placeholder="Card holder email" id="client-email"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="email">
                                                        </div>
                                                    </div>
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
                                                            type="submit"  onclick="showLoader();" >Attach</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    @endif





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

            if(errors == true)
            {
                hideLoader();
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
