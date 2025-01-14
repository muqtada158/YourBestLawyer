@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | My Profile')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Super-Admin Portal</h2>
        </div>


        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-superadmin')

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
                                                <p class="fs-4">{{auth()->user()->email}}</p>
                                                <small class="small-text">Email</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-4">{{auth()->user()->user_name}}</p>
                                                <small class="small-text">Username</small>
                                            </div>
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
                                        <p class="fs-4">Admin</p>
                                        <small class="small-text">Account Type</small>
                                    </div>
                                    <div class="row mt-4">
                                        <p class="fs-4">01 June 2024</p>
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
                                            <a href="{{route('admin_profile_edit')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Change Password</a>
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
