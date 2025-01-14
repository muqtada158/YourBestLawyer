@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Customers Applications')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">All Customers Applications</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="offset-md-3 col-md-2">
                                <a href="{{route('admin_application_customers',['All'])}}" class="{{ request()->segment(3) === 'All' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin_application_customers',['Accepted'])}}" class="{{ request()->segment(3) === 'Accepted' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accepted</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin_application_customers',['Rejected'])}}" class="{{ request()->segment(3) === 'Rejected' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Rejected</a>
                            </div>
                        </div>
                        @forelse($applications as $application)
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
                                                        <span class="font-14" >{{ isset($application->created_at) ? \Carbon\Carbon::parse($application->created_at)->diffForHumans() : '' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <div class="row text-end mb-2 mt-2">
                                                    <div class="offset-md-4 col-md-8">
                                                        @if ((isset($application->getUser)) AND $application->getUser->restricted_steps > 11)
                                                            @if($application->application_status == "Accepted")
                                                                <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                    Accepted
                                                                </label>
                                                            @elseif($application->application_status == "Rejected")
                                                                <label class="btn-danger w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                    Rejected
                                                                </label>
                                                            @else
                                                                <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                    Pending
                                                                </label>
                                                            @endif
                                                        @else
                                                            <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                Application not received yet
                                                            </label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mt-4 xy-center">
                                                    <div class="col-md-12">
                                                        @if($application->getUser)
                                                        <a href="{{route('admin_application_details',[$application->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Application</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="row mt-4">
                                <div class="card card-border-bottom radius-20">
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <p>
                                                No applications found...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Pagination links -->
                                <div class="pagination w-100">
                                    {{ $applications->links() }}
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
