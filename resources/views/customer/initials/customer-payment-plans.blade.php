@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Payment Plans')

@section('content')
    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
            style="background-image: url('{{ asset('images/bg-design.png') }}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <div class="row" class="step">
                        <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Payment Plans</h2>
                        <div class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                            <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                            <div class="step-line step-line-small"></div>
                            <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                            <div class="step-line step-line-small"></div>
                            <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                            <div class="step-line step-line-small"></div>
                            <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            <div class="step-line step-line-small"></div>
                            <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                        </div>
                        <div class="col-12 d-flex flex-column gap-4 ">
                            <div class="row mt-4">
                                <div class="card border-0 radius-20 mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <h4 class="font-primary">Select your payment plan to proceed further.</h4>
                                            <label class="font-18 mb-2 fw-bold mt-2">Case Category:</label>
                                            <label class="font-18 mb-2">{{$case->getCaseLaw->title}}</label>
                                            <label class="font-18 mb-2 fw-bold mt-2">Case Sub Category:</label>
                                            <label class="font-18 mb-2">{{$case->getCaseLawSub->title}}</label>
                                            <label class="font-18 mb-2 fw-bold mt-2">Package:</label>
                                            @if ($case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                <label class="font-18 mb-2">{{$case->getCasePackage->title}} ({{$case->getCasePackage->min_amount}}% - {{$case->getCasePackage->max_amount}}%)</label>
                                                <label class="font-18 mb-2 fw-bold mt-2">Your Bid:</label>
                                                <label class="font-18 mb-2">{{$case->getCasebid->bid}}%</label>
                                            @else
                                                <label class="font-18 mb-2">{{$case->getCasePackage->title}} (${{$case->getCasePackage->min_amount}} - ${{$case->getCasePackage->max_amount}})</label>
                                                <label class="font-18 mb-2 fw-bold mt-2">Your Bid:</label>
                                                <label class="font-18 mb-2">${{$case->getCasebid->bid}}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-column gap-4 ">
                                <form action="{{ route('customer_payment_plans_store') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label class="font-18 mb-2" for="payment_plan">Payment Plan:</label>
                                        <select name="payment_plan" id="payment-plan" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                            <option selected hidden disabled>Please select payment plan</option>
                                            <option value="no" {{ old('payment_plan') == 'no' ? 'selected' : '' }}>Full Payment</option>
                                            <option value="yes" {{ old('payment_plan') == 'yes' ? 'selected' : '' }}>Partial Payments</option>
                                        </select>
                                        @error('payment_plan')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-2" id="payment-cycle-container" style="display: none;">
                                        @if ($installments)
                                            <label class="font-18 mb-2" for="downpayment">Down Payment:</label>
                                            <input type="number" value="{{ round($case->getCasePackage->min_amount / 2) }}" name="downpayment" placeholder="Enter your down payment" id="downpayment" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                            <span id="downpayment-message" class="text-danger"></span> <br>

                                            <label class="font-18 mb-2" for="payment_cycle">Payment Cycle:</label>
                                            <select name="payment_cycle" id="payment_cycle" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                <option selected hidden disabled>Please select payment cycle</option>
                                                @for ($i = 2; $i <= $installments; $i++)
                                                    <option value="{{ $i }}" {{ old('payment_cycle') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('payment_cycle')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mt-4" id="installments_container"></div>
                                                </div>
                                            </div>
                                            <h5 class="font-accent mt-4">Note : The installments will be charged every 30 days, starting from the date the contract is accepted.</h5>
                                        @else
                                            <label class="font-18 mb-2" for="">This Package has no partial payments available. Kindly select Full payment and submit.</label>
                                        @endif
                                    </div>
                                    <div class="text-end mt-4">
                                        <button class="btn btn-primary text-white py-2 px-5 font-20 radius-10" type="submit" onclick="showLoader();">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Show payment cycle container if 'Partial Payments' was previously selected
    var oldPaymentPlan = '{{ old('payment_plan') }}';
    if (oldPaymentPlan === 'yes') {
        $('#payment-cycle-container').show();
    }

    // Handle payment plan selection change
    $('#payment-plan').on('change', function() {
        var plan = $(this).val();
        if (plan === 'yes') {
            $('#payment-cycle-container').slideDown();
        } else {
            $('#payment-cycle-container').slideUp();
        }
    });

    // Handle down payment and payment cycle changes
    function validateDownPayment() {
        var package_min_amount = {{ $case->getCasePackage->min_amount }};
        var downPayment = parseFloat($('#downpayment').val());
        var minDownPayment = Math.round(package_min_amount * 0.50);
        var maxDownPayment = Math.round(package_min_amount * 0.90);
        var message = $('#downpayment-message');

        // Round the downPayment value for comparison and display
        var roundedDownPayment = Math.round(downPayment);

        if (isNaN(downPayment) || roundedDownPayment < minDownPayment) {
            message.text(`Kindly enter a minimum of ${minDownPayment} as down payment.`);
        } else if (roundedDownPayment > maxDownPayment) {
            message.text(`Kindly enter a maximum of ${maxDownPayment} as down payment.`);
        } else {
            message.text('');
        }

        updateInstallments();
    }

    function updateInstallments() {
        var bid = {{ $case->getCasebid->bid }};
        var package_min_amount = {{ $case->getCasePackage->min_amount }};
        var downPayment = parseFloat($('#downpayment').val());
        var paymentCycle = parseInt($('#payment_cycle').val());
        var remainingAmount = bid - downPayment;
        var installmentsContainer = $('#installments_container');

        // Validate down payment and update installments
        if (downPayment >= package_min_amount * 0.50 && downPayment <= package_min_amount * 0.90 && paymentCycle && !isNaN(downPayment) && !isNaN(paymentCycle)) {
            // Clear previous installment inputs with fadeOut animation
            installmentsContainer.children().fadeOut(function() {
                $(this).remove();
            });

            // Generate new installment inputs with fadeIn animation
            var installmentAmount = Math.round(remainingAmount / paymentCycle);
            for (var i = 1; i <= paymentCycle; i++) {
                var installmentHtml = `
                    <label class="font-18 mb-2" for="installment_${i}">Installment ${i}</label>
                    <input type="number" name="installment_${i}" id="installment_${i}" value="${installmentAmount}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                `;
                var newInstallment = $(installmentHtml).hide();
                installmentsContainer.append(newInstallment);
                newInstallment.fadeIn();
            }
        } else {
            installmentsContainer.empty();
        }
    }

    // Initial validation on page load
    validateDownPayment();

    // Validate down payment on input change
    $('#downpayment').on('input', function() {
        validateDownPayment();
    });

    // Update installments when payment cycle changes
    $('#payment_cycle').on('change', function() {
        updateInstallments();
    });

});
</script>
@endpush
