@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Leads')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Leads</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="container">
                                    @forelse ($cases as $case)

                                    <div class="row mt-3">
                                        <div class="card card-border-bottom">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row ">
                                                        <div class="col-md-2 text-center">
                                                            <div class="icon-large">
                                                                <div class="customer-avatar text-center">
                                                                    <img class="w-100" src="{{asset($case->getUser->getUserDetails->image)}}" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 border-box-left">
                                                            <div class="pt-2">
                                                                <p class="font-accent">
                                                                    <small class="accent-color-3 fw-bold">SR#{{$case->sr_no}}</small>
                                                                    <br>
                                                                    <span class="font-20 fw-bold">{{ucfirst($case->getUser->getUserDetails->first_name)}} {{$case->getUser->getUserDetails->last_name}}</span>
                                                                    <br>
                                                                    <span class="font-14 accent-color-2 fw-bold" >{{$case->getCaseLaw->title}}</span>
                                                                    <br>
                                                                    <span class="font-14" >{{ \Carbon\Carbon::parse($case->created_at)->diffForHumans() }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="row xy-center mt-2 mb-2">
                                                                <div class="col-md-12 d-flex align-items-center justify-content-center text-center">
                                                                    @if (isset($case) && $case->getCasePackage->sub_cat_id == 18 || $case->getCasePackage->sub_cat_id == 19 || $case->getCasePackage->sub_cat_id == 20)
                                                                        <p class="fw-bold font-20"> {{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}%</p>
                                                                    @else
                                                                        <p class="fw-bold font-20"> ${{isset($case->getCaseBid->bid) ? $case->getCaseBid->bid : ''}}</p>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                            <div class="row xy-center">
                                                                <div class="col-md-12">
                                                                    <a href="{{route('attorney_leads_customer_details',[$case->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="row mt-3">
                                        <div class="card card-border-bottom">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="text-center">
                                                        <p>No leads received yet...</p>
                                                    </div>
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
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
