@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Customer Contract')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form action="{{route('customer_contracts_store')}}" method="Post" enctype="multipart/form-data">@csrf
                        <div class="row">
                            <h2 class="fw-bold mb-0 col-lg-6 font-accent">Contract Form</h2>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Customer's Information</h2>
                                <div class="row">
                                    <input type="hidden" name="customer_id" value="{{$contract->getCaseDetails->getUser->id}}">
                                    <input type="hidden" name="attorney_id" value="{{$contract->getAttornies->id}}">
                                    <input type="hidden" name="case_id" value="{{$contract->getCaseDetails->id}}">
                                    <input type="hidden" name="contract_id" value="{{$getLawContract->id}}">
                                    <div class="col-md-12">
                                        <label class="font-18 mb-2" for="first_name">First Name</label>
                                        <input readonly name="first_name" value="{{isset($contract->getCaseDetails->getUser->getUserDetails->first_name) ? $contract->getCaseDetails->getUser->getUserDetails->first_name : ''}}" placeholder="First Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="last_name">Last Name</label>
                                        <input readonly name="last_name" value="{{isset($contract->getCaseDetails->getUser->getUserDetails->last_name) ? $contract->getCaseDetails->getUser->getUserDetails->last_name : ''}}" placeholder="Last Name" id="last_name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Date of birth</label>
                                        <input readonly name="dob" value="{{isset($contract->getCaseDetails->getUser->getUserDetails->dob) ? $contract->getCaseDetails->getUser->getUserDetails->dob : ''}}" placeholder="DOB" id="dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Email</label>
                                        <input value="{{isset($contract->getCaseDetails->getUser->email) ? $contract->getCaseDetails->getUser->email : ''}}" readonly name="email" placeholder="Email" id="email" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="email">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Phone</label>
                                        <input readonly name="phone" value="{{isset($contract->getCaseDetails->getUser->getUserDetails->phone) ? $contract->getCaseDetails->getUser->getUserDetails->phone : ''}}" placeholder="Phone Number" id="phone" class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Address</label>
                                        <input readonly name="address" value="{{isset($contract->getCaseDetails->getUser->getUserDetails->address) ? $contract->getCaseDetails->getUser->getUserDetails->address : ''}}" placeholder="Address" id="address" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Attorney's Information</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="font-18 mb-2" for="first_name">First Name</label>
                                        <input readonly name="first_name" value="{{isset($contract->getAttornies->getUserDetails->first_name) ? $contract->getAttornies->getUserDetails->first_name : ''}}" placeholder="First Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="last_name">Last Name</label>
                                        <input readonly name="last_name" value="{{isset($contract->getAttornies->getUserDetails->last_name) ? $contract->getAttornies->getUserDetails->last_name : ''}}" placeholder="Last Name" id="last_name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Date of birth</label>
                                        <input readonly name="dob" value="{{isset($contract->getAttornies->getUserDetails->dob) ? $contract->getAttornies->getUserDetails->dob : ''}}" placeholder="DOB" id="dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Email</label>
                                        <input value="{{isset($contract->getAttornies->email) ? $contract->getAttornies->email : ''}}" readonly name="email" placeholder="Email" id="email" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="email">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Phone</label>
                                        <input readonly name="phone" value="{{isset($contract->getAttornies->getUserDetails->phone) ? $contract->getAttornies->getUserDetails->phone : ''}}" placeholder="Phone Number" id="phone" class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="font-18 mb-2" for="client-name">Address</label>
                                        <input readonly name="address" value="{{isset($contract->getAttornies->getUserDetails->address) ? $contract->getAttornies->getUserDetails->address : ''}}" placeholder="Address" id="address" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                @if ($contract->getCaseDetails->is_same_person == 0)
                                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Client's Information</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="font-18 mb-2" for="Convictee's Name">Convictee's Name</label>
                                            <input readonly name="Convictee's Name" value="{{isset($contract->getCaseDetails->convictee_name) ? $contract->getCaseDetails->convictee_name : ''}}" placeholder="Convictee's Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="Convictee's Date of birth">Convictee's Date of birth</label>
                                            <input readonly name="Convictee's Date of birth" value="{{isset($contract->getCaseDetails->convictee_dob) ? $contract->getCaseDetails->convictee_dob : ''}}" placeholder="DOB" id="convictee_dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="font-18 mb-2" for="Convictee's Relation">Convictee's Relation</label>
                                            <input readonly name="Convictee's Relation" value="{{isset($contract->getCaseDetails->convictee_relationship) ? $contract->getCaseDetails->convictee_relationship : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Scope Of Service</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="font-18 mb-2" for="scope"> Case </label>
                                            <input readonly name="scope" value="{{isset($contract->getCaseDetails->getCaseLaw) ? $contract->getCaseDetails->getCaseLaw->title : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="font-18 mb-2" for="scope"> Case Sub Category </label>
                                            <input readonly name="scope" value="{{isset($contract->getCaseDetails->getCaseLawSub) ? $contract->getCaseDetails->getCaseLawSub->title : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                    </div>
                                <hr>
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Payment Plan</h2>
                                <p class="mt-2 mb-0"><strong>YOURBESTLAWYER.COM FEE :</strong> Attorney has already paid for this portion.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="font-18 mb-2" for="scope">Payment Type</label>
                                            <input readonly name="scope" value="{{isset($paymentPlan) ? $paymentPlan->installments === "yes" ? 'Partial Payment / Installments' : 'Full Payment'  : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                    </div>
                                    <div class="row mt-0 pt-0">
                                        <div class="col-md-6 p-5">
                                            <h4 class="font-accent text-center fw-bold">Customer Payment Plan</h4>
                                            <div class="col-md-12  mt-4">
                                                <label class="font-18 mb-2" for="scope">Customer Bid</label>
                                                @if ($contract->getCaseDetails->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetails->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetails->getCasePackage->sub_cat_id == 20)
                                                <input readonly name="scope" value="{{isset($contract->getCaseDetails->getCaseBid) ? $contract->getCaseDetails->getCaseBid->bid : ''}}%" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                @else
                                                <input readonly name="scope" value="{{isset($contract->getCaseDetails->getCaseBid) ? '$'.$contract->getCaseDetails->getCaseBid->bid : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                @endif
                                            </div>
                                            @if (isset($paymentPlan) AND $paymentPlan->installments === "yes")
                                            @php
                                                $installment_amount = round(($contract->getCaseDetails->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
                                            @endphp
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="scope">Down Payment</label>
                                                        <input readonly name="scope" value="${{$paymentPlan->getTransactionDownpayment->amount}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                </div>
                                                @for ($i = 1; $i <= $paymentPlan->installment_cycle; $i++)
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="scope">{{'Installment # '.$i}}</label>
                                                        <input readonly name="scope" value="${{$installment_amount}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                </div>
                                                @endfor
                                            @endif
                                        </div>
                                        <div class="col-md-6 p-5">
                                            <h4 class="font-accent text-center fw-bold">Attorney Proposed Payment Plan</h4>
                                            <div class="col-md-12  mt-4">
                                                <label class="font-18 mb-2" for="scope">Attorney Bid</label>
                                                @if ($contract->getCaseDetails->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetails->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetails->getCasePackage->sub_cat_id == 20)
                                                <input readonly name="scope" value="{{isset($getAttorneyBid) ? $getAttorneyBid->attorney_bid : ''}}%" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                @else
                                                <input readonly name="scope" value="{{isset($getAttorneyBid) ? '$'.$getAttorneyBid->attorney_bid : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                @endif
                                            </div>
                                            @if (isset($paymentPlan) AND $paymentPlan->installments === "yes")
                                            @php
                                                $installment_amount = round(($getAttorneyBid->attorney_bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
                                            @endphp
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="scope">Down Payment</label>
                                                        <input readonly name="scope" value="${{$paymentPlan->getTransactionDownpayment->amount}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                </div>
                                                @for ($i = 1; $i <= $paymentPlan->installment_cycle; $i++)
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="scope">{{'Installment # '.$i}}</label>
                                                        <input readonly name="scope" value="${{$installment_amount}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                </div>
                                                @endfor
                                            @endif
                                        </div>
                                        @if (isset($paymentPlan) AND $paymentPlan->installments === "yes")
                                        <h5 class="font-accent mt-4">Note : The installments will be charged every 30 days, starting from the date the contract is accepted by attorney.</h5>
                                        @endif

                                    </div>
                                <hr>
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Terms and conditions</h2>
                                {{-- <div>
                                    <p>{{$getLawContract->description}}</p>
                                </div> --}}
                                <div class="agree-div">
                                    <input type="checkbox" id="terms" value="1" class="square-checkbox" name="agree_terms_and_conditions">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer.com</label>
                                </div>
                                <div class="row col-md-6 col-sm-12">
                                    <a href="{{route('contract_terms_and_conditions',[$contract->getCaseDetails->case_type,$contract->getCaseDetails->lawyer_type])}}" target="__blank" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">View Terms &amp; Conditions</a>
                                </div>
                                @error('agree_terms_and_conditions')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                <div class="row col-md-6 col-sm-12">
                                    <label class="font-18 mb-2 w-100" for="Date">Date:</label>
                                    <input type="text" value="{{\Carbon\Carbon::today()->format('m-d-Y')}}" name="contract_date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                    @error('contract_date')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="parent">
                                    <label class="font-18 mb-2 w-100" for="sign">Please sign below: <small>(After sign please click on confirm)</small></label>
                                    <div class="below">
                                        <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                        <input type="hidden" name="customer_signature" id="hidden-signature-data" value="">
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                        @error('customer_signature')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" type="submit" onclick="showLoader();">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>
</div>

@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.querySelector(".sign");
        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        $('#signature-trash').click(function(e) {
            e.preventDefault();
            signaturePad.clear();
            $('#hidden-signature-data').val('');
        });

        $('#confirm-signature').click(function(e) {
            e.preventDefault();
            if ($('#confirm-signature').text() === 'Confirm') {
                // Disable signature area
                signaturePad.off();
                var signatureData = signaturePad.toDataURL();
                $('#hidden-signature-data').val(signatureData);
                $('#confirm-signature').text('Edit').removeClass('bg-primary').addClass('bg-secondary');
            } else {
                // Enable signature area
                signaturePad.on();
                signaturePad.clear();
                $('#hidden-signature-data').val('');
                $('#confirm-signature').text('Edit').removeClass('bg-secondary').addClass('bg-primary');
                $('#confirm-signature').text('Confirm');
            }
        });

        $('#save-signature').click(function() {
            var signatureData = signaturePad.toDataURL();
            $('#hidden-signature-data').val(signatureData);
            $('#signature-form').submit(); // Assuming your form has the ID 'signature-form'
        });
    </script>

@endpush
