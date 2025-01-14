@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Applications')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Applications</h2>
                    <div class="container mt-4">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{route('admin_application_customers',['All'])}}">
                                    <div class="card radius-20 border-0 app-card">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row mt-4 mb-4 text-center">
                                                    <div class="icon-large">
                                                        <div class="application-card-image text-center">
                                                            <img class="w-100" src="{{asset('images/behind_bars.png')}}" alt="">
                                                        </div>
                                                        <div class="text mt-4">
                                                            <h3 class="fw-bold font-28 font-accent accent-color-3">Customers</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin_application_attornies',['All'])}}">
                                    <div class="card radius-20 border-0 app-card">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row mt-4 mb-4 text-center">
                                                    <div class="icon-large">
                                                        <div class="application-card-image text-center">
                                                            <img class="w-100" src="{{asset('images/interested-attorney.png')}}" alt="">
                                                        </div>
                                                        <div class="text mt-4">
                                                            <h3 class="fw-bold font-28 font-accent accent-color-3">Attornies</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
