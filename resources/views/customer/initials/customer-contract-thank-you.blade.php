@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Contract Thank You')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Contract Process</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                <div class="avatar-preview">
                                                    <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="{{$user->getUserDetails->image}}" alt="User profile picture">
                                                    <h4 class="customer-name font-18 mt-2 fw-bold font-accent">{{$user->getUserDetails->first_name}} {{$user->getUserDetails->last_name}}</h4>
                                                </div>
                                                </div>
                                            </div>
                                            @if ($user->restricted_steps == 18)
                                            <div class="row mt-4 pt-4">
                                                <div class="offset-md-2 col-md-8 text-center">
                                                    <h3 class="font-accent lh-base">Contract Accepted</h3>
                                                </div>
                                                <div class="offset-md-2 col-md-8 text-center mt-4">
                                                    <h5 class="font-accent"><strong>Attorney accepts your contract, You can now schedule the meeting and proceed.
                                                </div>
                                                <div class="offset-md-2 col-md-8 text-center mt-4">
                                                    <h5 class="font-accent"><strong>Thank You</strong></h5>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row mt-4 pt-4">
                                                <div class="offset-md-2 col-md-8 text-center">
                                                    <h3 class="font-accent lh-base">Contract is in process</h3>
                                                </div>
                                                <div class="offset-md-2 col-md-8 text-center mt-4">
                                                    <h5 class="font-accent"><strong>Waiting for attorney to accept your Contract.
                                                        <br> Note: If your contract is not accepted within 48 hours, it will be canceled automatically.</strong></h5>
                                                </div>
                                                <div class="offset-md-2 col-md-8 text-center mt-4">
                                                    <h5 class="font-accent"><strong>Thank You</strong></h5>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($user->restricted_steps == 18)
                            <div class="row mt-4">
                                <div class="offset-md-8 col-md-4 text-end">
                                    <a href="{{route('customer_initial_schedule')}}" class="btn-primary d-block text-center p-3 mb-2 radius-10"> Schedule Appointment</a>
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
