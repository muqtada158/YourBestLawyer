@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Contract')

@section('content')

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css">
    @endpush

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
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Contracts</h2>
                        <div class="container">

                            @forelse ($contracts as $contract)
                                <div class="row mt-3">
                                    <div class="card card-border-bottom">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md-2 text-center">
                                                        <div class="icon-large">
                                                            <div class="customer-avatar text-center">
                                                                <img class="w-100"
                                                                    src="{{ asset($contract->getAttornies->getUserDetails->image) }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 border-box-left">
                                                        <div class="pt-2">
                                                            <p class="font-accent">
                                                                <span
                                                                    class="font-20 fw-bold">{{ $contract->getAttornies->getUserDetails->first_name }}
                                                                    {{ $contract->getAttornies->getUserDetails->last_name }}</span>
                                                                <br>
                                                                <small class="accent-color-3">SR #
                                                                    {{ $contract->getCaseDetail->sr_no }}</small>
                                                                <br>
                                                                <span
                                                                    class="font-14">{{ truncate_text($contract->getAttornies->getUserDetails->bio) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center xy-center">
                                                        <div class="row xy-center">
                                                            <div class="col-md-6">
                                                                <p class="">
                                                                    @if (isset($contract->getCaseDetail) && $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
                                                                        <span class="fw-bold">{{ $contract->caseAttorneyBid->attorney_bid }}%</span>
                                                                    @else
                                                                        <span class="fw-bold">${{ $contract->caseAttorneyBid->attorney_bid }}</span>
                                                                    @endif
                                                                    <br>
                                                                    @if ($contract->status == "Accepted")
                                                                        <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> Accepted</label>
                                                                    @elseif ($contract->status == "Pending")
                                                                        <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                                    @elseif ($contract->status == "Ended")
                                                                        <label class="btn-info w-100 d-block text-center radius-10 pt-1 pb-1"> Ended</label>
                                                                    @else
                                                                        <label class="btn-rejected w-100 d-block text-center radius-10 pt-1 pb-1"> Rejected</label>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <a href="{{ route('customer_get_contract_details', [$contract->id]) }}"
                                                                    class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10">
                                                                    View Details</a>
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
                                                <div class="row ">
                                                    <p>No Contracts Found...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pagination w-100">
                                        {{ $contracts->links() }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection
