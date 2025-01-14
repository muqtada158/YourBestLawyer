@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Cases')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Cases</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-6 mt-4">
                                <a href="{{route('attorney_all_cases',['total'])}}">
                                    <div class="card border-0 radius-20 case-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4 text-center">
                                                    <div class="cases-count bg-primary xy-center">
                                                        {{$casesTotal}}
                                                    </div>
                                                </div>
                                                <div class="col-md-8  xy-center text-center">
                                                    <div class="fw-bold font-20 accent-color-3 color-hover">
                                                        All Cases
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 mt-4">
                                <a href="{{route('attorney_all_cases',['pending'])}}">
                                    <div class="card border-0 radius-20 case-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4 text-center">
                                                    <div class="cases-count bg-primary xy-center">
                                                        {{$casesPending}}
                                                    </div>
                                                </div>
                                                <div class="col-md-8  xy-center text-center">
                                                    <div class="fw-bold font-20 accent-color-3 color-hover">
                                                        Pending Cases
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 mt-4">
                                <a href="{{route('attorney_all_cases',['ended'])}}">
                                    <div class="card border-0 radius-20 case-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4 text-center">
                                                    <div class="cases-count bg-primary xy-center">
                                                        {{$casesEnded}}
                                                    </div>
                                                </div>
                                                <div class="col-md-8  xy-center text-center">
                                                    <div class="fw-bold font-20 accent-color-3 color-hover">
                                                        End Cases
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 mt-4">
                                <a href="{{route('attorney_all_cases',['ongoing'])}}">
                                    <div class="card border-0 radius-20 case-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4 text-center">
                                                    <div class="cases-count bg-primary xy-center">
                                                        {{$casesOngoing}}
                                                    </div>
                                                </div>
                                                <div class="col-md-8  xy-center text-center">
                                                    <div class="fw-bold font-20 accent-color-3 color-hover">
                                                        Ongoing Cases
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
