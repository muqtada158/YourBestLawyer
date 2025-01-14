@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies Applications')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">All Attornies Applications</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="offset-md-2 col-md-2">
                                <a href="{{route('admin_application_attornies',['All'])}}" class="{{ request()->segment(3) === 'All' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin_application_attornies',['Pending'])}}" class="{{ request()->segment(3) === 'Pending' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Pending</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin_application_attornies',['Accepted'])}}" class="{{ request()->segment(3) === 'Accepted' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accepted</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin_application_attornies',['Rejected'])}}" class="{{ request()->segment(3) === 'Rejected' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Rejected</a>
                            </div>
                        </div>
                        @foreach($applications as $application)
                            <div class="row mt-4">
                                <div class="card card-border-bottom radius-20">
                                    <div class="card-body">
                                        <div class="row ">
                                            <div class="col-md-2 text-center">
                                                <div class="icon-large">
                                                    <div class="customer-avatar text-center">
                                                        <img class="w-100"
                                                            src="{{ isset($application->getUser->getUserDetails->image) ? asset($application->getUser->getUserDetails->image) : asset('images/user-dummy.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 border-box-left">
                                                <div class="pt-2">
                                                    <p class="font-accent">
                                                        <span class="font-20 fw-bold">
                                                            {{ isset($application->getUser->getUserDetails->first_name) ? ucfirst($application->getUser->getUserDetails->first_name) : 'Name not found'}}
                                                            {{ isset($application->getUser->getUserDetails->last_name) ? ucfirst($application->getUser->getUserDetails->last_name) : '' }}
                                                        </span>
                                                        <br>
                                                        <small class="accent-color-3">{{ isset($application->getUser->email) ? ucfirst($application->getUser->email) : '' }}</small>
                                                        <br>
                                                        <span class="font-14" >{{ isset($application->getUser->getUserDetails->bio) ? truncate_text($application->getUser->getUserDetails->bio, 100) : '' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <div class="row text-end mb-2 mt-2">
                                                    <div class="offset-md-4 col-md-8">
                                                        @if ($application->status == 'Accepted')
                                                            <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                Accepted
                                                            </label>
                                                        @elseif($application->status == 'Pending')
                                                            <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                Pending
                                                            </label>
                                                        @elseif($application->status == 'Rejected')
                                                            <label class="btn-danger w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                Rejected
                                                            </label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mt-4 xy-center">
                                                    <div class="col-md-12">
                                                        @if($application->getUser)
                                                        <a href="{{route('admin_application_attorney_details',[$application->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Application</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Pagination links -->
                                <div class="pagination w-100">
                                    {{ $applications->links() }}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                            <div class="cases-count bg-primary xy-center">
                                                    2
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
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_application_attorney_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
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
                                            <div class="icon-large">
                                            <div class="cases-count bg-primary xy-center">
                                                   3
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
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_application_attorney_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
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
                                            <div class="icon-large">
                                            <div class="cases-count bg-primary xy-center">
                                                    4
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
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-rejected w-100 d-block text-center radius-10 pt-1 pb-1"> Rejected</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_application_attorney_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@endsection
