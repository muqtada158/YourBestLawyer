@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Dashboard')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-attorney')
                </div>
                <div class="customer-portal-content py-3">
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Case Details</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row mt-3">
                                                <div class="col-md-2 text-start">
                                                    <div class="icon-large">
                                                        <div class="customer-avatar">
                                                            <img class="w-100" src="{{isset($case->getUser->getUserDetails->image) ? asset($case->getUser->getUserDetails->image) : asset('images/user-dummy.jpg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <p class="font-accent">
                                                        <span class="font-20 fw-bold">
                                                            {{ isset($case->getUser->getUserDetails->first_name) ? ucfirst($case->getUser->getUserDetails->first_name) : $application->getUser->user_name }}
                                                            {{ isset($case->getUser->getUserDetails->last_name) ? ucfirst($case->getUser->getUserDetails->last_name) : '' }}
                                                        </span>
                                                        <br>
                                                        <span class="font-14 fw-bold">SR # {{isset($case) ? $case->sr_no : 0}}</span>
                                                        <br>
                                                        <span class="font-14 fw-bold">Case : {{isset($case->getCaseLaw) ? $case->getCaseLaw->title : 0}}</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row text-end">
                                                        <div class="col-md-12">
                                                            @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                            <h4 class="fw-bold font-accent"> {{$case->getCaseBid->bid}}%</h4>
                                                            @else
                                                            <h4 class="fw-bold font-accent"> $ {{$case->getCaseBid->bid}}</h4>
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
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container pt-2 pb-2">
                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Case Details</h2>
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($case->case_status == "Accepted")
                                                        <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                    @elseif($case->case_status == "Ended")
                                                        <label class="btn-success w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                    @else
                                                        <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <p class="fs-5">
                                                            @if ($case->is_same_person == 0)
                                                                No
                                                            @else
                                                                Yes
                                                            @endif
                                                        </p>
                                                        <small class="small-text">Is the person accused is the same person filling out this form</small>
                                                    </div>
                                                    @if ($case->is_same_person == 0)
                                                        <div class="container">
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$case->convictee_name}}</p>
                                                                <small class="small-text">Client's Name</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$case->convictee_dob}}</p>
                                                                <small class="small-text">Client's DOB</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$case->convictee_relationship}}</p>
                                                                <small class="small-text">Client's Relation</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (isset($dynamicForms))
                                                        @foreach ($dynamicForms as $key => $dynamic)
                                                            @if ($dynamic !== null)
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{ $dynamic }}</p>
                                                                    <small
                                                                        class="small-text">{{ $key }}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </div>

                                                <hr class="mt-4">
                                                <div class="row">
                                                    <div class="col-md-6 mt-4">
                                                        <div class="row">
                                                            <p class="fs-5">{{$case->getCaseLaw->title}}</p>
                                                            <small class="small-text">Case</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-4">
                                                        <div class="row">
                                                            <p class="fs-5">{{$case->getCaseLawSub->title}}</p>
                                                            <small class="small-text">Case Sub Category</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-4">
                                                        <div class="row">
                                                            <p class="fs-5">{{$case->getCasePackage->title}}</p>
                                                            <small class="small-text">Case Package</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4">Attached Media</h4>
                                            <div class="row">
                                                @forelse ($case->getCaseMedia as $media)
                                                    @if ($media->type == 'image')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset($media->media) }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'video')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/video-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'document')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/document-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @empty
                                                <p class="mt-4">No Media uploaded...</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4">Payment Plan</h4>
                                            <div class="row">
                                                <div class="col-md-6 p-2">
                                                    <label class="font-18 mb-2" for="scope">Payment Type</label>
                                                        <input readonly name="scope" value="{{isset($paymentPlan) ?  $paymentPlan->installments === "yes" ? 'Partial Payment' : 'Full Payment' : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                                <div class="col-md-6 p-2">
                                                    <label class="font-18 mb-2" for="scope">Customer's Bid</label>
                                                    @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                    <input readonly name="scope" value="{{isset($case->getCaseBid) ? $case->getCaseBid->bid : ''}}%" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @else
                                                    <input readonly name="scope" value="{{isset($case->getCaseBid) ? '$'.$case->getCaseBid->bid : ''}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 p-2">
                                                    @if (isset($paymentPlan) AND $paymentPlan->installments === "yes")
                                                    @php
                                                        $installment_amount = round(($case->getCaseBid->bid - $paymentPlan->getTransactionDownpayment->amount) / $paymentPlan->installment_cycle);
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($case->case_status == "Accepted")
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card radius-20 border-0">
                                        <div class="card-body">
                                            <div class="container">
                                                <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4 mb-4">Attorney</h4>
                                                    <div class="row mt-4 mb-4 card-border-bottom">
                                                        <div class="col-md-2 text-center">
                                                            <div class="icon-large">
                                                                <div class="cases-count bg-primary xy-center">
                                                                    <img class="case-user-requested" src="{{asset($case->getAcceptedCustomerContracts->getAttornies->getUserDetails->image)}}" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 border-box-left">
                                                            <div class="">
                                                                <p class="font-accent">
                                                                    <span class="font-20 fw-bold">
                                                                        {{$case->getAcceptedCustomerContracts->getAttornies->getUserDetails->first_name}}
                                                                        {{$case->getAcceptedCustomerContracts->getAttornies->getUserDetails->last_name}}
                                                                    </span>
                                                                    <br>
                                                                    <span class="font-14">{{truncate_text($case->getAcceptedCustomerContracts->getAttornies->getUserDetails->bio)}}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="row text-end mt-4">
                                                                <div class="offset-md-4 col-md-8">
                                                                    @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                                    <p class="fw-bold"> {{$case->getAcceptedCustomerContracts->caseAttorneyBid->attorney_bid}}% </p>
                                                                    @else
                                                                    <p class="fw-bold"> $ {{$case->getAcceptedCustomerContracts->caseAttorneyBid->attorney_bid}} </p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row text-end">
                                                                <div class="col-md-12">
                                                                    <a href="{{route('attorney_contracts_details',[$customer_contract->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Go to contract</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4 text-center">
                                    @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                        <a href="{{route('attorney_end_case_by_attorney',[$customer_contract->case_id,$customer_contract->attorney_id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10" onclick="showLoader();"> End Case</a>
                                    @else
                                        @if ($paymentPlan->payment_status == "Paid")
                                            <a href="{{route('attorney_end_case_by_attorney',[$customer_contract->case_id,$customer_contract->attorney_id])}}" onclick="showLoader();" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> End Case</a>
                                        @else
                                            <a href="javascript:void()" class="btn-secondary w-100 d-block text-center p-3 mb-2 radius-10"> End Case</a>
                                            <small>Payments are not paid / clear ! <br> you cannot end the case.</small>
                                        @endif
                                    @endif
                                </div>
                                <div class="offset-md-4 col-md-4">
                                    <a href="{{route('attorney_messages',[$customer_contract->customer_id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Chat</a>
                                </div>
                            </div>
                        @else
                            <div class="row mt-4">
                                <div class="offset-md-8 col-md-4">
                                <a href="{{route('attorney_contracts_details',[$customer_contract->id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> View Contract</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
