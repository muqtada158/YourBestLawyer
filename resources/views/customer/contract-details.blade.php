@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Contract Details')

@section('content')

@push('css')
    <style>
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
            border: 0;
            border-radius: .25em;
            background: initial;
            background-color: #b38e6a !important;
            color: #fff;
            font-size: 1em;
        }
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-cancel) {
            border: #b38e6a 1px solid !important;
            border-radius: .25em;
            background: initial;
            background-color: #6e788105 !important;
            color: #b38e6a !important;
            font-size: 1em;
        }
    </style>
@endpush

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-customer')

                </div>
                <div class="customer-portal-content py-3">
                    <form action="{{route('attorney_accept_contract')}}" method="Post" enctype="multipart/form-data">@csrf
                        <div class="row">
                            <h2 class="fw-bold mb-0 col-lg-6 font-accent">Contract Form</h2>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card radius-20 border-0">
                                        <div class="card-body p-4">
                                            <div class="col-12 d-flex flex-column gap-4 ">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h2 class="fw-bold font-28 mb-0 font-accent">Customer's Information</h2>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <h4 class="font-accent">SR # {{$contract->getCaseDetail->sr_no}}</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="font-18 mb-2" for="first_name">First Name</label>
                                                        <input readonly name="first_name" value="{{isset($contract->getCustomer->getUserDetails->first_name) ? $contract->getCustomer->getUserDetails->first_name : ''}}" placeholder="First Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="last_name">Last Name</label>
                                                        <input readonly name="last_name" value="{{isset($contract->getCustomer->getUserDetails->last_name) ? $contract->getCustomer->getUserDetails->last_name : ''}}" placeholder="Last Name" id="last_name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">Date of birth</label>
                                                        <input readonly name="dob" value="{{isset($contract->getCustomer->getUserDetails->dob) ? $contract->getCustomer->getUserDetails->dob : ''}}" placeholder="DOB" id="dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">Email</label>
                                                        <input value="{{isset($contract->getCustomer->email) ? $contract->getCustomer->email : ''}}" readonly name="email" placeholder="Email" id="email" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="email">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">Phone</label>
                                                        <input readonly name="phone" value="{{isset($contract->getCustomer->getUserDetails->phone) ? $contract->getCustomer->getUserDetails->phone : ''}}" placeholder="Phone Number" id="phone" class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">Address</label>
                                                        <input readonly name="address" value="{{isset($contract->getCustomer->getUserDetails->address) ? $contract->getCustomer->getUserDetails->address : ''}}" placeholder="Address" id="address" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
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
                                                @if ($contract->getCaseDetail->is_same_person == 0)
                                                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Client's Information</h2>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="font-18 mb-2" for="Client's Name">Client's Name</label>
                                                            <input readonly name="Client's Name" value="{{isset($contract->getCaseDetail->convictee_name) ? $contract->getCaseDetail->convictee_name : ''}}" placeholder="Client's Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <label class="font-18 mb-2" for="Client's Date of birth">Client's Date of birth</label>
                                                            <input readonly name="Client's Date of birth" value="{{isset($contract->getCaseDetail->convictee_dob) ? $contract->getCaseDetail->convictee_dob : ''}}" placeholder="DOB" id="convictee_dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="font-18 mb-2" for="Client's Relation">Client's Relation</label>
                                                            <input readonly name="Client's Relation" value="{{isset($contract->getCaseDetail->convictee_relationship) ? $contract->getCaseDetail->convictee_relationship : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                <hr>
                                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Scope Of Service</h2>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="font-18 mb-2" for="scope"> Case </label>
                                                            <input readonly name="scope" value="{{isset($contract->getCaseDetail->getCaseLaw) ? $contract->getCaseDetail->getCaseLaw->title : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="font-18 mb-2" for="scope"> Case Sub Category </label>
                                                            <input readonly name="scope" value="{{isset($contract->getCaseDetail->getCaseLawSub) ? $contract->getCaseDetail->getCaseLawSub->title : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                    </div>
                                                <hr>

                                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Payment Plan</h2>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="font-18 mb-2" for="scope">Payment Type</label>
                                                        <input readonly name="scope" value="{{isset($paymentPlan) ? $paymentPlan->installments === "yes" ? 'Partial Payment / Installments' : 'Full Payment'  : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    </div>
                                                </div>
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 p-2">
                                                        <h4 class="font-accent text-center fw-bold">Customer Initial Payment Plan</h4>
                                                        <div class="col-md-12  mt-4">
                                                            <label class="font-18 mb-2" for="scope">Customer's Bid</label>
                                                            @if (isset($contract->getCaseDetail) && $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
                                                            <input readonly name="scope" value="{{isset($contract->getCaseDetail->getCaseBid) ? $contract->getCaseDetail->getCaseBid->bid : ''}}%" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                            @else
                                                            <input readonly name="scope" value="{{isset($contract->getCaseDetail->getCaseBid) ? '$'.$contract->getCaseDetail->getCaseBid->bid : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                            @endif
                                                        </div>
                                                        @if (isset($paymentPlan) AND $paymentPlan->installments === "yes")
                                                        @php
                                                            $installment_amount = round(($contract->getCaseDetail->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
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
                                                    <div class="col-md-6 p-2">
                                                        <h4 class="font-accent text-center fw-bold">Attorney Proposed Payment Plan</h4>
                                                        <div class="col-md-12  mt-4">
                                                            <label class="font-18 mb-2" for="scope">Attorney's Bid</label>
                                                            @if (isset($contract->getCaseDetail) && $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
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
                                                    <p>{{$contract->getContract->description}}</p>
                                                </div> --}}
                                                <div class="agree-div">
                                                    <input type="checkbox" id="terms" value="1" class="square-checkbox" name="agree_terms_and_conditions" checked disabled>
                                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer.com</label>
                                                </div>
                                                <div class="row col-md-6 col-sm-12">
                                                    <a href="{{route('contract_terms_and_conditions',[$contract->getCaseDetail->case_type,$contract->getCaseDetail->lawyer_type])}}" target="__blank" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">View Terms &amp; Conditions</a>
                                                </div>
                                                <div class="row col-md-6 col-sm-12">
                                                    <label class="font-18 mb-2 w-100" for="Date">Date:</label>
                                                    <input type="text" value="{{old('contract_date',$contract->contract_date)}}" name="contract_date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                                </div>
                                                <div class="row col-md-12 col-sm-12">
                                                    <label class="font-18 mb-2 w-100" for="Date">Customer Signature:</label>
                                                    @if (isset($contract->signature_image))
                                                        <div class="col-md-12">
                                                            <a href="{{ asset($contract->signature_image) }}"
                                                                target="__blank">
                                                                <img src="{{ asset($contract->signature_image) }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <hr>
                                                @if ($contract->status == "Accepted")
                                                    <div class="row col-md-12 col-sm-12">
                                                        <label class="font-18 mb-2 w-100" for="Date">Attorney Signature:</label>
                                                        @if (isset($contract->attorney_signature_image))
                                                            <div class="col-md-12">
                                                                <a href="{{ asset($contract->attorney_signature_image) }}"
                                                                    target="__blank">
                                                                    <img src="{{ asset($contract->attorney_signature_image) }}"
                                                                        alt=""
                                                                        class="w-100 mt-3 mb-3 form-image">
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-12 text-center">
                                                            <h2 class="fw-bold font-28 mb-0 font-accent">Accepted Contract</h2>
                                                        </div>
                                                    </div>
                                                @elseif($contract->status == "Rejected")
                                                    <div class="row col-md-12 col-sm-12">
                                                        <div class="col-md-12 text-center">
                                                            <h2 class="fw-bold font-28 mb-0 font-accent">Rejected Contract</h2>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row col-md-12 col-sm-12">
                                                        <div class="col-md-12 text-center">
                                                            <h2 class="fw-bold font-28 mb-0 font-accent">Pending Contract</h2>
                                                        </div>
                                                    </div>
                                                @endif


                                            </div>

                                        </div>

                                    </div>
                                    @if ($contract->status == "Pending")
                                        <div class="row text-center mt-4">
                                            <div class="offset-md-3 col-md-6">
                                                <a href="{{route('customer_cancel_contract',[$contract->id])}}" id="cancel" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Cancel Contract </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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

    <script>
        $(function(){
            $(document).on('click','#cancel',function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Cancel Contract?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, close',
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = link
                    }
                })
            });
        });
    </script>

@endpush
