@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application Details')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Details</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row mt-3">
                                                <div class="col-md-2 text-start">
                                                    <div class="icon-large">
                                                        <div class="customer-avatar">
                                                            <img class="w-100" src="{{isset($application->getUser->getUserDetails->image) ? asset($application->getUser->getUserDetails->image) : asset('images/user-dummy.jpg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <p class="font-accent">
                                                        <span class="font-20 fw-bold">
                                                            {{ isset($application->getUser->getUserDetails->first_name) ? ucfirst($application->getUser->getUserDetails->first_name) : $application->getUser->user_name }}
                                                            {{ isset($application->getUser->getUserDetails->last_name) ? ucfirst($application->getUser->getUserDetails->last_name) : '' }}
                                                        </span>
                                                        <br>
                                                        <span class="font-14 fw-bold">SR # {{isset($application) ? $application->sr_no : 0}}</span>
                                                        <br>
                                                        <span class="font-14 fw-bold">Case : {{isset($application->getCaseLaw) ? $application->getCaseLaw->title : 0}}</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row text-end">
                                                        <div class="col-md-12">
                                                            <h4 class="fw-bold font-accent"> $ {{$application->getCaseBid->bid}}</h4>
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
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container pt-2 pb-2">
                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Case Details</h2>
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($application->application_status == "Accepted")
                                                        <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> {{$application->application_status}}</label>
                                                    @elseif($application->application_status == "Rejected")
                                                        <label class="btn-danger w-100 d-block text-center radius-10 pt-1 pb-1"> {{$application->application_status}}</label>
                                                    @else
                                                        <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> {{$application->application_status}}</label>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p class="fs-5">
                                                            @if ($application->is_same_person == 0)
                                                                No
                                                            @else
                                                                Yes
                                                            @endif
                                                        </p>
                                                        <small class="small-text">Is the person accused is the same person filling out this form</small>
                                                    </div>
                                                    @if ($application->is_same_person == 0)
                                                        <div class="container">
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$application->convictee_name}}</p>
                                                                <small class="small-text">Client's Name</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$application->convictee_dob}}</p>
                                                                <small class="small-text">Client's DOB</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{$application->convictee_relationship}}</p>
                                                                <small class="small-text">Client's Relation</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (isset($dynamicForms))
                                                        @foreach ($dynamicForms as $key => $dynamic)
                                                            @if ($dynamic !== null)
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$dynamic}}</p>
                                                                    <small class="small-text">{{$key}}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <hr class="mt-4">
                                                <div class="col-md-12">
                                                    <div class="row text-center">
                                                        <p class="fs-5">{{$application->getCaseLaw->title}}</p>
                                                        <small class="small-text">Case</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4">Attached Media</h4>
                                            <div class="row">
                                                @forelse ($application->getCaseMedia as $media)
                                                    @if ($media->type == 'image')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset($media->media) }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'video')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/video-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'document')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/document-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @empty
                                                <p class="mt-4">No Media uploaded...</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-4">
                            @if ($application->application_status == "Rejected")
                                <div class="offset-md-3 col-md-6 text-center">
                                    <h3 class="text-danger font-accent">Application Rejected</h3>
                                </div>
                            @else
                                <div class="offset-md-3 col-md-6">
                                    <a href="{{route('admin_application_reject_customer',[$application->id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Reject Application</a>
                                </div>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
