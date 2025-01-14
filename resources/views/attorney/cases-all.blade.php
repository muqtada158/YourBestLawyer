@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | All Cases')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">All Cases</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="offset-md-2 col-md-2">
                                <a href="{{route('attorney_all_cases',['total'])}}" class="{{ request()->segment(3) === 'total' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('attorney_all_cases',['pending'])}}" class="{{ request()->segment(3) === 'pending' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Pending</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('attorney_all_cases',['ended'])}}" class="{{ request()->segment(3) === 'ended' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Ended</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('attorney_all_cases',['ongoing'])}}" class="{{ request()->segment(3) === 'ongoing' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Ongoing</a>
                            </div>
                        </div>
                        @forelse ($cases as $case)
                            <div class="card radius-10 border-0 mt-4">
                                <div class="card-body">
                                    <div class="container font-accent">
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <h5 class="accent-color-3">
                                                        <strong>{{$case->getUser->getUserDetails->first_name}} {{$case->getUser->getUserDetails->last_name}}</strong>
                                                        <br>
                                                        <small class="text-grey" style="margin-top: -10px;">SR# {{$case->sr_no}}</small>
                                                    </h5>
                                                    <small class="text-grey" style="margin-top: -10px;">{{$case->getCaseLaw->title}}</small>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 accent-color-3 font-14">
                                                        <span><i class="fa-solid fa-calendar-days"></i> {{\Carbon\Carbon::parse($case->created_at)->format('d-m-Y')}}</span> &nbsp; <span><i class="fa-regular fa-clock"></i> {{\Carbon\Carbon::parse($case->created_at)->format('H:i:s')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-2">
                                                    <div class="offset-md-8 col-md-4">
                                                        @if ($case->case_status == "Accepted")
                                                            <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> Ongoing</label>
                                                        @elseif($case->case_status == "Pending")
                                                            <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                        @else
                                                            <label class="btn-success w-100 d-block text-center radius-10 pt-1 pb-1"> Ended</label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="offset-md-6 col-md-6">
                                                        <a href="{{route('attorney_case_details',[$case->id])}}" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="card radius-10 border-0">
                            <div class="card-body">
                                <div class="container font-accent">
                                    <div class="row pt-2 text-center">
                                        <p>No cases found...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Pagination links -->
                                <div class="pagination w-100">
                                    {{ $cases->links() }}
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
