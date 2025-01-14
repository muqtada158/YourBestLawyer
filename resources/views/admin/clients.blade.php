@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Leads')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Customers</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="container">
                                    {{-- <div class="row">
                                        <div class="offset-md-2 col-md-2">
                                            <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> All</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Accept</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Reject</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> pending</a>
                                        </div>
                                    </div> --}}
                                    @foreach ($customers as $customer)
                                        <div class="row mt-3">
                                            <div class="card card-border-bottom">
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row ">
                                                            <div class="col-md-2 text-center">
                                                                <div class="icon-large">
                                                                    <div class="customer-avatar text-center">
                                                                        <img class="w-100" src="{{ isset($customer->getUserDetails->image) ? asset($customer->getUserDetails->image) : asset('images/user-dummy.jpg') }}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 border-box-left d-flex align-items-center">
                                                                <div class="pt-2">
                                                                    <p class="font-accent">
                                                                        <span class="font-20 fw-bold">
                                                                            {!! isset($customer->getUserDetails->first_name) ? ucfirst($customer->getUserDetails->first_name) : $customer->user_name.'<small class="accent-color-3">(username)</small>' !!}
                                                                            {{ isset($customer->getUserDetails->last_name) ? ucfirst($customer->getUserDetails->last_name) : '' }}
                                                                        </span>
                                                                        <br>
                                                                        <small class="accent-color-3">{{ isset($customer->email) ? $customer->email : '' }}</small>
                                                                        </p>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 text-center d-flex align-items-center justify-content-center">
                                                                <div class="row">
                                                                    @if ((isset($customer)) AND $customer->restricted_steps > 8)
                                                                        <div class="col-md-12">
                                                                            <a href="{{route('admin_clients_details',[$customer->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> &nbsp; &nbsp; View Details &nbsp; &nbsp;</a>
                                                                        </div>
                                                                    @else
                                                                    <div class="col-md-12">
                                                                        <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                            &nbsp; Profile not updated yet &nbsp;
                                                                        </label>
                                                                    </div>
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
                                                {{ $customers->links() }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row mt-3">
                                        <div class="card card-border-bottom">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row ">
                                                        <div class="col-md-2 text-center">
                                                            <div class="icon-large">
                                                                <div class="customer-avatar text-center">
                                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
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
                                                            <div class="row xy-center mt-2 mb-2">
                                                                <div class="col-md-6">
                                                                    <p class="fw-bold"> $400-$600</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="{{route('admin_attornies_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View</a>
                                                                </div>
                                                            </div>
                                                            <div class="row xy-center">
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="card card-border-bottom">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row ">
                                                        <div class="col-md-2 text-center">
                                                            <div class="icon-large">
                                                                <div class="customer-avatar text-center">
                                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
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
                                                            <div class="row xy-center mt-2 mb-2">
                                                                <div class="col-md-6">
                                                                    <p class="fw-bold"> $400-$600</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="{{route('admin_attornies_details')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View</a>
                                                                </div>
                                                            </div>
                                                            <div class="row xy-center">
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="card card-border-bottom">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row ">
                                                        <div class="col-md-2 text-center">
                                                            <div class="icon-large">
                                                                <div class="customer-avatar text-center">
                                                                    <img class="w-100" src="{{asset('images/julia-grey.png')}}" alt="">
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
                                                            <div class="row xy-center mt-2 mb-2">
                                                                <div class="col-md-6">
                                                                    <p class="fw-bold"> $400-$600</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View</a>
                                                                </div>
                                                            </div>
                                                            <div class="row xy-center">
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-secondary w-100 d-block text-center p-1 mb-2 radius-10"> Reject</a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                                </div>
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
            </div>
        </div>
    </section>

</div>

@endsection
