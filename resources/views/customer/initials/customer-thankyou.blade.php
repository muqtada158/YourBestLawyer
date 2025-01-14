@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Thank you')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form id="multi-step-form">
                        <div class="row">
                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Registration in process</h2>
                            <div class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                        <div class="avatar-preview">
                                            <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="{{$user->getUserDetails->image}}" alt="User profile picture">
                                            <h4 class="customer-name font-18 mt-2 fw-bold font-accent">{{$user->getUserDetails->first_name}} {{$user->getUserDetails->last_name}}</h4>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 pt-4">
                                        <div class="offset-md-2 col-md-8 text-center">
                                            <h3 class="font-accent lh-base">Registration in process</h3>
                                        </div>
                                        @if ($user->restricted_steps == 14)
                                            <div class="offset-md-2 col-md-8 text-center mt-4">
                                                <h5 class="font-accent"><strong>Congratulations your application has been accepted.</strong></h5>
                                            </div>
                                        @else
                                            <div class="offset-md-2 col-md-8 text-center mt-4">
                                                <h5 class="font-accent"><strong>Waiting for attorney to accept your BID. <br><br> Note: If your application is not confirmed within 48 hours, it will be automatically rejected, and you will need to submit a new application.</strong></h5>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-4 pt-4">
                                        <a class="align-self-end btn btn-primary text-white py-2 px-5 font-20 radius-10" onclick="showLoader();" href="{{route('customer_hired_attornies',[$case->id])}}">Go To Attorney Bid list</a>
                                    </div>
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
