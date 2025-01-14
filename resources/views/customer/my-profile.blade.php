@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | My Profile')

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
                    <div class="row">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">My Profile</h2>
                    </div>
                    <div class="row mt-4">
                        <div class="card border-0 radius-10 pt-4 pb-4">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <p class="fs-4">{{ucfirst($user->getUserDetails->first_name)}}</p>
                                                <small class="small-text">First Name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{ucfirst($user->getUserDetails->last_name)}}</p>
                                                <small class="small-text">Last Name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{$user->email}}</p>
                                                <small class="small-text">Email</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{$user->user_name}}</p>
                                                <small class="small-text">Username</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{$user->getUserDetails->phone}}</p>
                                                <small class="small-text">Phone Number</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{$user->getUserDetails->address}}</p>
                                                <small class="small-text">Address</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{route('customer_profile_edit')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Edit Profile</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="card border-0 radius-10 pt-4 pb-4">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <p class="fs-4">{{ucfirst($user->user_type)}}</p>
                                        <small class="small-text">Account Type</small>
                                    </div>
                                    <div class="row mt-4">
                                        <p class="fs-4">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}</p>
                                        <small class="small-text">Member Since</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="card border-0 radius-10 pt-4 pb-4">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="fs-4">**************</p>
                                            <small class="small-text" style="margin-top: -15px;">Password</small>
                                        </div>
                                        <div class="offset-md-3 col-md-3">
                                            <a href="{{route('customer_profile_edit')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="card border-0 radius-10 pt-4 pb-4">
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Card Details</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="fs-5">**** **** **** {{$user->getUserPaymentDetailsOne->card_last_four}}</p>
                                                <small class="small-text">Card number</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{$user->getUserPaymentDetailsOne->card_expiry_month}} / {{$user->getUserPaymentDetailsOne->card_expiry_year}}</p>
                                                <small class="small-text">Expiry date</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">***</p>
                                                <small class="small-text">CVC / CVV</small>
                                            </div>
                                        </div>
                                        <div class="offset-md-3 col-md-3 text-end">
                                            <a href="{{route('customer_update_card_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Change Card</a>
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
