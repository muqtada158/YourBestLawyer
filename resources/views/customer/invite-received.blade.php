@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Invite Received')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Received Invites</h2>
                    <div class="container">
                        <div class="row mt-4 mb-4">
                            <div class="col-md-2">
                                <a href="{{route('customer_invite')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Invite</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('customer_invite_received')}}" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Received</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('customer_invite_sent')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Sent</a>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/Experienced Lawyer.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <br>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Bid : <strong>$ 500</strong></small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Case : </small> <small class="accent-color-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center d-flex align-items-center">
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                            &nbsp;
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/Experienced Lawyer.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <br>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Bid : <strong>$ 500</strong></small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Case : </small> <small class="accent-color-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center d-flex align-items-center">
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                            &nbsp;
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/Experienced Lawyer.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <br>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Bid : <strong>$ 500</strong></small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Case : </small> <small class="accent-color-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center d-flex align-items-center">
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                            &nbsp;
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/Experienced Lawyer.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <br>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Bid : <strong>$ 500</strong></small>
                                                    <br>
                                                    <small class="accent-color-3 fw-bold">Case : </small> <small class="accent-color-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center d-flex align-items-center">
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                            &nbsp;
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
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
