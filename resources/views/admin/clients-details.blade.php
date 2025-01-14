@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Customer Details')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Customer Details</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row mt-3">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Customer Details</h3>
                                                        <div class="row ">
                                                            <div class="col-md-2 text-start">
                                                                <div class="icon-large">
                                                                    <div class="customer-avatar">
                                                                        <img class="w-100" src="{{isset($customer->getUserDetails->image) ? asset($customer->getUserDetails->image) : asset('images/user-dummy.jpg')}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 d-flex align-items-center">
                                                                <div class="pt-2">
                                                                    <p class="font-accent">
                                                                        <span class="font-20 fw-bold">
                                                                            {{ isset($customer->getUserDetails->first_name) ? ucfirst($customer->getUserDetails->first_name) : $customer->user_name }}
                                                                            {{ isset($customer->getUserDetails->last_name) ? ucfirst($customer->getUserDetails->last_name) : '' }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $customer->email }}</p>
                                                            <small class="small-text">Email</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $customer->user_name }}</p>
                                                            <small class="small-text">Username</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $customer->getUserDetails->phone }}</p>
                                                            <small class="small-text">Phone Number</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $customer->getUserDetails->address }}</p>
                                                            <small class="small-text">Address</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <form action="{{route('admin_update_status')}}" method="POST">@csrf
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="user_id" value="{{$customer->id}}">
                                                                    <select name="status" id="status" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                        <option value="Enabled" {{$customer->status == 'Enabled' ? 'selected' : '' }}>Enabled</option>
                                                                        <option value="Disabled" {{$customer->status == 'Disabled' ? 'selected' : '' }}>Disabled</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <span class="text-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <small class="small-text">Status</small>
                                                                    <button type="submit" class="mt-4 btn-primary d-block w-50 p-1 mb-2 pt-3 pb-3 radius-10">Update</button>
                                                                </div>
                                                            </form>
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
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
