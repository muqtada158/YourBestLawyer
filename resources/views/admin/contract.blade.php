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
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Super-Admin Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-superadmin')
                    </div>
                    <div class="customer-portal-content py-3">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Contracts</h2>
                        <div class="row mt-4">
                            <div class="offset-md-3 col-md-2 mb-2">
                                <a href="{{ route('admin_contract', ['Accepted']) }}"
                                   class="{{ request()->segment(3) === 'Accepted' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Accepted</a>
                            </div>
                            <div class="col-md-2 mb-2">
                                <a href="{{ route('admin_contract', ['Pending']) }}"
                                   class="{{ request()->segment(3) === 'Pending' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Pending</a>
                            </div>
                            <div class="col-md-2 mb-2">
                                <a href="{{ route('admin_contract', ['Rejected']) }}"
                                   class="{{ request()->segment(3) === 'Rejected' ? 'btn-primary' : 'btn-secondary secondary' }} w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10">Rejected</a>
                            </div>
                        </div>
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
                                                                    src="{{ asset(isset($contract->getCustomer->getUserDetails->image) ? $contract->getCustomer->getUserDetails->image : 'images/user-dummy.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 border-box-left xy-center" style="justify-content: left">
                                                        <div class="pt-2">
                                                            <p class="font-accent">
                                                                <span
                                                                    class="font-10 fw-bold">{{ isset($contract->getCustomer->getUserDetails->first_name) ? $contract->getCustomer->getUserDetails->first_name : 'Name not available'}}
                                                                    {{ isset($contract->getCustomer->getUserDetails->last_name) ? $contract->getCustomer->getUserDetails->last_name : '' }}</span>
                                                                <br>
                                                                <small class="accent-color-3 fw-bold">
                                                                    Customer
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <div class="icon-large">
                                                            <div class="customer-avatar text-center">
                                                                <img class="w-100"
                                                                    src="{{ asset(isset($contract->getAttornies->getUserDetails->image) ? $contract->getAttornies->getUserDetails->image : 'images/user-dummy.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 border-box-left xy-center" style="justify-content: left">
                                                        <div class="pt-2">
                                                            <p class="font-accent">
                                                                <span
                                                                    class="font-10 fw-bold">{{ isset($contract->getAttornies->getUserDetails->first_name) ? $contract->getAttornies->getUserDetails->first_name : 'Name not available'}}
                                                                    {{ isset($contract->getAttornies->getUserDetails->last_name) ? $contract->getAttornies->getUserDetails->last_name : '' }}</span>
                                                                <br>
                                                                <small class="accent-color-3 fw-bold">
                                                                    Attorney
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="offset-md-1 col-md-3 text-center xy-center">
                                                        <div class="row xy-center">
                                                            <div class="col-md-6">
                                                                <p>
                                                                    @if (isset($contract->status))
                                                                        @if ($contract->status == "Accepted")
                                                                            <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> {{$contract->status}}</label>
                                                                        @elseif($contract->status == "Pending")
                                                                            <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> {{$contract->status}}</label>
                                                                        @else
                                                                            <label class="btn-danger w-100 d-block text-center radius-10 pt-1 pb-1"> {{$contract->status}}</label>
                                                                        @endif
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                @if (isset($contract->getCaseDetail) && $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
                                                                <p class="fw-bold">
                                                                    {{ isset( $contract->caseAttorneyBid->attorney_bid ) ? $contract->caseAttorneyBid->attorney_bid : '' }}%
                                                                </p>
                                                                @else
                                                                <p class="fw-bold">$
                                                                    {{ isset( $contract->caseAttorneyBid->attorney_bid ) ? $contract->caseAttorneyBid->attorney_bid : '' }}
                                                                </p>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-12">
                                                                <a href="{{ route('admin_contracts_details', [$contract->id]) }}"
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
