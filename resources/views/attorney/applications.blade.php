@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application')

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
                    <form id="multi-step-form">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Applications</h2>
                            <div class="row mt-4">
                                <div class="col-md-2 mb-2">
                                <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                                </div>
                                <div class="col-md-2 mb-2">
                                <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accepted</a>
                                </div>
                                <div class="col-md-2 mb-2">
                                <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Rejected</a>
                                </div>
                                <div class="offset-md-3 col-md-3">
                                <a href="{{route('attorney_add_application')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Add New Application</a>
                                </div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div class="card radius-10 border-0">
                                    <div class="card-body">
                                        <div class="container font-accent">
                                            <div class="row pt-2">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <h5 class="accent-color-3"><strong>Application 1</strong></h5>
                                                        <small class="text-grey" style="margin-top: -10px;">Application Case</small>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 accent-color-3 font-14">
                                                            <span><i class="fa-solid fa-calendar-days"></i> 12/12/2024</span> &nbsp; <span><i class="fa-regular fa-clock"></i> 12:00PM</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-2">
                                                        <div class="offset-md-8 col-md-4">
                                                            <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> Accepted</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card radius-10 border-0">
                                    <div class="card-body">
                                        <div class="container font-accent">
                                            <div class="row pt-2">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <h5 class="accent-color-3"><strong>Application 2</strong></h5>
                                                        <small class="text-grey" style="margin-top: -10px;">Application Case</small>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 accent-color-3 font-14">
                                                            <span><i class="fa-solid fa-calendar-days"></i> 12/12/2024</span> &nbsp; <span><i class="fa-regular fa-clock"></i> 12:00PM</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-2">
                                                        <div class="offset-md-8 col-md-4">
                                                            <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card radius-10 border-0">
                                    <div class="card-body">
                                        <div class="container font-accent">
                                            <div class="row pt-2">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <h5 class="accent-color-3"><strong>Application 3</strong></h5>
                                                        <small class="text-grey" style="margin-top: -10px;">Application Case</small>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 accent-color-3 font-14">
                                                            <span><i class="fa-solid fa-calendar-days"></i> 12/12/2024</span> &nbsp; <span><i class="fa-regular fa-clock"></i> 12:00PM</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-2">
                                                        <div class="offset-md-8 col-md-4">
                                                            <label class="btn-rejected w-100 d-block text-center radius-10 pt-1 pb-1"> Rejected</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Delete</a>
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
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
