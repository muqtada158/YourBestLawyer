@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Current Potential Cases')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Ongoing Cases</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="offset-md-2 col-md-2">
                                <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accept</a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Reject</a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> pending</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large ">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <span class="btn-primary d-block text-center width-100px radius-10"> $ 250</span>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="row text-end mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <p class="accent-color-3 fw-bold">SR#42515</p>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-2">
                                                            <a href="{{route('admin_case_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <img class="case-user" src="{{asset('images/interested-attorney.png')}}" alt=""><br>
                                                            <span class="fw-bold case-user-font">$400</span>
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
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large ">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <span class="btn-primary d-block text-center width-100px radius-10"> $ 250</span>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="row text-end mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <p class="accent-color-3 fw-bold">SR#42515</p>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-2">
                                                            <a href="{{route('admin_case_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <img class="case-user" src="{{asset('images/interested-attorney.png')}}" alt=""><br>
                                                            <span class="fw-bold case-user-font">$400</span>
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
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large ">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <span class="btn-primary d-block text-center width-100px radius-10"> $ 250</span>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="row text-end mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <p class="accent-color-3 fw-bold">SR#42515</p>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-2">
                                                            <a href="{{route('admin_case_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <img class="case-user" src="{{asset('images/interested-attorney.png')}}" alt=""><br>
                                                            <span class="fw-bold case-user-font">$400</span>
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
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large ">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <span class="btn-primary d-block text-center width-100px radius-10"> $ 250</span>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="row text-end mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <p class="accent-color-3 fw-bold">SR#42515</p>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-2">
                                                            <a href="{{route('admin_case_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <img class="case-user" src="{{asset('images/interested-attorney.png')}}" alt=""><br>
                                                            <span class="fw-bold case-user-font">$400</span>
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
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large ">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">Robin Hood</span>
                                                    <span class="btn-primary d-block text-center width-100px radius-10"> $ 250</span>
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="row text-end mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <p class="accent-color-3 fw-bold">SR#42515</p>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-9 mt-2">
                                                            <a href="{{route('admin_case_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <img class="case-user" src="{{asset('images/interested-attorney.png')}}" alt=""><br>
                                                            <span class="fw-bold case-user-font">$400</span>
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
            </div>
        </div>
    </section>

</div>

@endsection
