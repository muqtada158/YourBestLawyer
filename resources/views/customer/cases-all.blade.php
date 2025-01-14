@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | All Cases')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-customer')

                    </div>
                    <div class="customer-portal-content py-3">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Cases</h2>
                            <div class="row mt-4">
                                <div class="offset-md-2 col-md-2 mb-2">
                                    <a href="{{ route('customer_cases', ['All']) }}"
                                       class="{{ request()->segment(3) === 'All' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">All</a>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <a href="{{ route('customer_cases', ['Accepted']) }}"
                                       class="{{ request()->segment(3) === 'Accepted' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Accepted</a>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <a href="{{ route('customer_cases', ['Pending']) }}"
                                       class="{{ request()->segment(3) === 'Pending' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Pending</a>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <a href="{{ route('customer_cases', ['Ended']) }}"
                                       class="{{ request()->segment(3) === 'Ended' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Ended</a>
                                </div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                @forelse ($cases as $case)
                                    <div class="card radius-10 border-0">
                                        <div class="card-body">
                                            <div class="container font-accent">
                                                <div class="row pt-2">
                                                    <div class="col-md-6">
                                                        <div class="row mb-3">
                                                            <h5 class="accent-color-3">
                                                                <strong>{{$case->getCaseLaw->title}}</strong>
                                                                <br>
                                                                <small class="text-grey">{{$case->getCaseLawSub->title}}</small>
                                                                <br>
                                                                <small class="text-grey">SR# {{$case->sr_no}}</small>
                                                            </h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 accent-color-3 font-14">
                                                                <span><i class="fa-solid fa-calendar-days"></i> {{\Carbon\Carbon::parse($case->created_at)->format('m-d-Y')}}</span> &nbsp; <span><i class="fa-regular fa-clock"></i> {{\Carbon\Carbon::parse($case->created_at)->format('H:i:s')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="offset-md-8 col-md-4">
                                                                @if ($case->case_status == "Accepted")
                                                                    <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                                @elseif($case->case_status == "Ended")
                                                                    <label class="btn-success w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                                @else
                                                                    <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> {{$case->case_status}}</label>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="offset-md-6 col-md-6">
                                                                <a href="{{route('customer_case_details',[$case->id])}}" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
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

                                {{-- <div class="card radius-10 border-0">
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
                                                            <a href="#" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Delete</a>
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
                                                            <a href="#" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> View</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="#" class="btn-primary secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Delete</a>
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
            </div>
        </section>

    </div>

@endsection
