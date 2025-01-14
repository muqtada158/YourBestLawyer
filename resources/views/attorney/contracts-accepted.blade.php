@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Accepted Contracts')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Accepted Contracts</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="offset-md-3 col-md-3">
                                <a href="{{route('attorney_contract_accepted')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accepted</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{route('attorney_contract_new')}}" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> New</a>
                            </div>
                        </div>
                        @forelse ($contracts as $contract)
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{ isset($contract->getCustomer->getUserDetails->image) ? asset($contract->getCustomer->getUserDetails->image) : asset('images/user-dummy.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-2">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">{{ucfirst($contract->getCustomer->getUserDetails->first_name)}} {{$contract->getCustomer->getUserDetails->last_name}}</span>
                                                    <br>
                                                    <small class="accent-color-4 fw-bold">SR#{{$contract->getCaseDetail->sr_no}}</small>
                                                    <br>
                                                    <span class="font-14" >{{ \Carbon\Carbon::parse($contract->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1"> Accepted</label>
                                                </div>
                                            </div>
                                            <div class="row mt-4 xy-center">
                                                <div class="col-md-12">
                                                    <a href="{{route('attorney_contracts_details',[$contract->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View Details</a>
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
                                        <p>No Contracts Found...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Pagination links -->
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

</div>

@endsection
