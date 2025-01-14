@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application Details')

@section('content')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Details</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row mt-4">
                                                <div class="col-md-2 text-start">
                                                    <div class="icon-large">
                                                        <div class="customer-avatar">
                                                            <img class="w-100" src="{{asset($application->getUser->getUserDetails->image)}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="pt-2">
                                                        <p class="font-accent">
                                                            <span class="font-20 fw-bold">{{$application->getUser->getUserDetails->first_name}} {{$application->getUser->getUserDetails->last_name}}</span>
                                                            <br>
                                                            <small class="accent-color-3">{{$application->getCaseLaw->title}}</small>
                                                            <br>
                                                            <small class="accent-color-3">{{\Carbon\Carbon::parse($application->created_at)->format('d-m-Y')}} <br> {{\Carbon\Carbon::parse($application->created_at)->format('H:i:s')}}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row text-end">
                                                        <div class="col-md-12">
                                                            <div class="rating-box">
                                                                <p class="fw-bold font-20">SR#{{$application->sr_no}}</p>
                                                            </div>
                                                            <h4 class="fw-bold font-accent"> ${{$application->getCaseBid->bid}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row text-center">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-2">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Case
                                        Infomation</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="fs-5">{{ $application->getCaseLaw->title }}</p>
                                                <small class="small-text">Case</small>
                                            </div>
                                            @if ($application->getCaseLawSub)
                                                <div class="row mt-4">
                                                    <p class="fs-5">
                                                        {{ $application->getCaseLawSub->title }}</p>
                                                    <small class="small-text">Case sub category</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="fs-5">{{ $application->getCasePackage->title }}
                                                </p>
                                                <small class="small-text">Package</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-2">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Application
                                        Details</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <p class="fs-5">
                                                    @if ($application->is_same_person == 0)
                                                        No
                                                    @else
                                                        Yes
                                                    @endif
                                                </p>
                                                <small class="small-text">Is the person accused is the same
                                                    person filling out this form</small>
                                            </div>
                                            @if ($application->is_same_person == 0)
                                                <div class="container">
                                                    <div class="row mt-4">
                                                        <p class="fs-5">{{ $application->convictee_name }}
                                                        </p>
                                                        <small class="small-text">Client's Name</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">{{ $application->convictee_dob }}</p>
                                                        <small class="small-text">Client's DOB</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ $application->convictee_relationship }}</p>
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

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-2">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Attached
                                        Media</h2>
                                    <div class="row">
                                        @forelse ($application->getCaseMedia as $media)
                                            @if ($media->type == 'image')
                                                <div class="col-md-3">
                                                    <a href="{{ asset($media->media) }}" target="__blank">
                                                        <img src="{{ asset($media->media) }}" alt=""
                                                            class="w-100 mt-3 mb-3 form-image">
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($media->type == 'video')
                                                <div class="col-md-3">
                                                    <a href="{{ asset($media->media) }}" target="__blank">
                                                        <img src="{{ asset('images/video-thumbnail.png') }}"
                                                            alt="" class="w-100 mt-3 mb-3 form-image">
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($media->type == 'document')
                                                <div class="col-md-3">
                                                    <a href="{{ asset($media->media) }}" target="__blank">
                                                        <img src="{{ asset('images/document-thumbnail.png') }}"
                                                            alt="" class="w-100 mt-3 mb-3 form-image">
                                                    </a>
                                                </div>
                                            @endif
                                        @empty
                                            <p>No media attached...</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-2">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Card Details
                                    </h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="fs-5">**** **** ****
                                                    {{ $application->getUser->getUserPaymentDetailsOne->card_last_four }}
                                                </p>
                                                <small class="small-text">Card number</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">
                                                    {{ $application->getUser->getUserPaymentDetailsOne->card_expiry_month }}
                                                    /
                                                    {{ $application->getUser->getUserPaymentDetailsOne->card_expiry_year }}
                                                </p>
                                                <small class="small-text">Expiry date</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">***</p>
                                                <small class="small-text">CVC / CVV</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-2">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Payment
                                        Plans</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mt-4">
                                                <p class="fs-5">
                                                    {{ $paymentPlan->installments === 'no' ? 'Full Payment' : 'Partial Payment' }}
                                                </p>
                                                <small class="small-text">Payment Type</small>
                                            </div>
                                            @if ($paymentPlan->installments === 'yes')
                                                <div class="row mt-4">
                                                    <p class="fs-5">
                                                        {{ $paymentPlan->installment_cycle }}</p>
                                                    <small class="small-text">Installment Cycle</small>
                                                </div>
                                                <div class="row mt-4">
                                                    <p class="fs-5">
                                                        ${{ $paymentPlan->getTransactionDownpayment->amount }}
                                                    </p>
                                                    <small class="small-text">Down Payment</small>
                                                </div>
                                                @for ($i = 1; $i <= $paymentPlan->installment_cycle; $i++)
                                                    <div class="row mt-4">
                                                        <p class="fs-5">${{ $installment_amount }}</p>
                                                        <small class="small-text">Installment
                                                            {{ $i }}</small>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                        <hr class="mt-4">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-center">
                                                <div class="row">
                                                    <small class="small-text mt-0">Your Bid</small>
                                                    @if (
                                                        $application->getCasePackage->sub_cat_id == 18 ||
                                                            $application->getCasePackage->sub_cat_id == 19 ||
                                                            $application->getCasePackage->sub_cat_id == 20)
                                                        <h3 class="font-primary mb-0">
                                                            {{ $application->getCaseBid->bid }}%</p>
                                                        @else
                                                            <h3 class="font-primary mb-0">$
                                                                {{ $application->getCaseBid->bid }}</p>
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
    </section>

</div>

@endsection
