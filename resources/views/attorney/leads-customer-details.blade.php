@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Leads Customer Details')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Lead Details</h2>
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
                                                            <img class="w-100" src="{{asset($case->getUser->getUserDetails->image)}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="pt-2">
                                                        <p class="font-accent">
                                                            <span class="font-20 fw-bold">{{ucfirst($case->getUser->getUserDetails->first_name)}} {{$case->getUser->getUserDetails->last_name}}</span>
                                                            <br>
                                                            <small class="accent-color-2 fw-bold">{{$case->getCaseLaw->title}}</small>
                                                            <br>
                                                            <small class="accent-color-2 fw-bold">{{$case->getCaseLawSub->title}}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row text-end">
                                                        <div class="col-md-12">
                                                            <div class="rating-box">
                                                                <p class="fw-bold font-20 accent-color-4">SR#{{$case->sr_no}}</p>
                                                            </div>
                                                            @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                                <h4 class="fw-bold font-accent"> {{$case->getCaseBid->bid}}%</h4>
                                                            @else
                                                                <h4 class="fw-bold font-accent"> ${{$case->getCaseBid->bid}}</h4>
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
                                        <div class="container">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Application Details</h2>
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
                                                <p>No media attached...</p>
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
                                                <div class="col-md-6">
                                                    <div class="row mt-4">
                                                        <p class="fs-5">{{$paymentPlan->installments === "no" ? 'Full Payment' : 'Partial Payment'}}</p>
                                                        <small class="small-text">Payment Type</small>
                                                    </div>
                                                    @if ($paymentPlan->installments === "yes" )
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{$paymentPlan->installment_cycle}}</p>
                                                            <small class="small-text">Installment Cycle</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">${{$paymentPlan->getTransactionDownpayment->amount}}</p>
                                                            <small class="small-text">Down Payment</small>
                                                        </div>
                                                        @for ($i = 1; $i <= $paymentPlan->installment_cycle; $i++)
                                                            <div class="row mt-4">
                                                                <p class="fs-5">${{$installment_amount}}</p>
                                                                <small class="small-text">Installment {{$i}}</small>
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

                        @if ($attorney_bid AND $attorney_bid->status == 'Interested')
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-4">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-center">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="small-text mt-0">Customer's Bid</small>
                                                        @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                            <h3 class="font-primary mb-0">{{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}%</p>
                                                        @else
                                                            <h3 class="font-primary mb-0">$ {{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="small-text mt-0">Your Bid</small>
                                                        @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                        <h3 class="font-primary mb-0">{{$attorney_bid->attorney_bid}}%</p>
                                                        @else
                                                        <h3 class="font-primary mb-0">$ {{$attorney_bid->attorney_bid}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @elseif ($attorney_bid AND $attorney_bid->status == 'NotInterested')
                        <div class="card border-0 radius-10 pt-4 pb-4 mt-4">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="text-center">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="small-text mt-0">Customer's Bid</small>
                                                        @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                            <h3 class="font-primary mb-0">{{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}%</p>
                                                        @else
                                                            <h3 class="font-primary mb-0">$ {{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="small-text mt-0">Your Bid</small>
                                                        <h3 class="font-primary mb-0">Not Interested</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @else
                        <form action="{{route('attorney_leads_interested')}}" method="POST">@csrf
                            <input type="hidden" name="case_id" value="{{$case->id}}">
                            <div class="card border-0 radius-10 pt-4 pb-4 mt-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <div class="text-center">
                                                    <div class="row">
                                                        <div class="offset-md-2 col-md-8">
                                                            <small class="small-text mt-0">Bid Range</small>
                                                            @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                                <h5 class="font-primary mb-0">{{isset($case->getCasePackage) ? 'Min bid percentage : '.$case->getCasePackage->min_amount: ''}}%</h5>
                                                                <h5 class="font-primary mb-0">{{isset($case->getCasePackage) ? 'Max bid percentage : '.$case->getCasePackage->max_amount  : ''}}%</h5>
                                                            @else
                                                                <h5 class="font-primary mb-0">{{isset($case->getCasePackage) ? 'Min bid amount : $'.$case->getCasePackage->min_amount: ''}}</h5>
                                                                <h5 class="font-primary mb-0">{{isset($case->getCasePackage) ? 'Max bid amount : $'.$case->getCasePackage->max_amount  : ''}}</h5>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <small class="small-text mt-0">Customer's Bid</small>
                                                            @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                                <h3 class="font-primary mb-0">{{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}%</h3>
                                                            @else
                                                                <h3 class="font-primary mb-0">$ {{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}</h3>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="small-text mt-0">Your Bid</small>
                                                            <input id="bid" name="bid"
                                                            value="{{ old('bid',$case->getCaseBid->bid) }}"
                                                            placeholder="Your Bid"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                            @error('bid')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @error('case_id')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($paymentPlan->installments === "yes" )
                                                                <small>Note: An increase in the bid amount will affect the installment amounts, but it will not change the down payment.</small>
                                                            @endif
                                                            <div class="offset-md-3 col-md-6 mt-4">
                                                                <button class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10" type="submit" onclick="showLoader();"> Interested</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </form>
                        @endif

                        <!-- if accepted chat button will display instead of these buttons -->
                        <!-- <div class="row mt-4">
                            <div class="offset-md-2 col-md-4">
                                <a href="#" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Chat</a>
                            </div>
                        </div> -->
                        @if (!$attorney_bid)
                        <div class="row mt-4">
                            <form action="{{route('attorney_leads_not_interested')}}" method="POST">@csrf
                                <input type="hidden" name="case_id" value="{{$case->id}}">
                            <div class="col-md-3">
                                <button class="btn-primary w-100 d-block p-3 mb-2 radius-10" type="submit" onclick="showLoader();"> Decline / Not Interested</button>
                            </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
