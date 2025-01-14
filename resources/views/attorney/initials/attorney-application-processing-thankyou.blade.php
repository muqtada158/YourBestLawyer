@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application processing thank you')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form id="multi-step-form">
                        <div class="row" class="step">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Processing</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
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
                                            <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="{{asset($user->getUserDetails->image)}}" alt="User profile picture">
                                            <h4 class="customer-name font-18 mt-2 fw-bold font-accent">{{ucfirst($user->getUserDetails->first_name)}} {{ucfirst($user->getUserDetails->last_name)}}</h4>
                                        </div>
                                        </div>
                                    </div>

                                    @if ($application->status ==  "Rejected")
                                        <div class="row">
                                            <div class="offset-md-2 col-md-8 text-center">
                                                <h3 class="font-accent lh-base">Application <span class="text-danger">Rejected</span></h3>
                                            </div>
                                            <div class="offset-md-3 col-md-6 text-center">
                                                <p>Unfortunately your application has been rejected by YourBestLawyer.com <br> Kindly submit a new application by clicking this button.</p>
                                                <br>
                                                <a href="{{route('submit_new_application')}}" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10">Submit New Application</a>
                                            </div>
                                        </div>
                                    @else

                                        <div class="row mt-4 pt-4">
                                            <div class="offset-md-2 col-md-8 text-center">
                                                <h3 class="font-accent lh-base">Application In Process.</h3>
                                            </div>
                                            <div class="offset-md-2 col-md-8 text-center mt-4">
                                                <h2 class="font-accent"><strong>Thank you</strong></h2>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- <div class="row mt-4 text-center">
                                        <div class="col-md-12">
                                            <a href="{{route('attorney_application_automate')}}" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" type="submit">To Dashboard</a>
                                        </div>
                                    </div> --}}
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
