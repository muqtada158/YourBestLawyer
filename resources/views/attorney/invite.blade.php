@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Invite')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Invites</h2>
                    <div class="container">
                        <div class="row mt-4 mb-4">
                            <div class="col-md-2">
                                <a href="{{route('attorney_invite')}}" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Invite</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('attorney_invite_received')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Received</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('attorney_invite_sent')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Sent</a>
                            </div>
                        </div>

                        <form action="#">
                            <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="has-search form-control form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" placeholder="Search By Name and Category">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Search</button>
                                    </div>
                            </div>
                        </form>
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
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center xy-center">
                                            <a href="{{route('attorney_invite_send')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Invite</a>
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
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center xy-center">
                                            <a href="{{route('attorney_invite_send')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Invite</a>
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
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center xy-center">
                                            <a href="{{route('attorney_invite_send')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Invite</a>
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
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center xy-center">
                                            <a href="{{route('attorney_invite_send')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Invite</a>
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
