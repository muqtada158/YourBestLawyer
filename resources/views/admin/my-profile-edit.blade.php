@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | My Profile Edit')

@section('content')

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
                        <div class="row">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Edit Profile</h2>
                        </div>
                        <form action="{{route('admin_profile_update')}}" method="POST" enctype="multipart/form-data"> @csrf
                            <div class="row ">
                                <div class="col-md-3 mt-4">
                                    <div class="card border-0 radius-10 pt-4">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row text-center">
                                                    <label for="imageUpload">
                                                        <div class="card border-0 text-center">
                                                            <div class="imagediv1 profile-camera xy-center">
                                                            <img class="img-fluid image-preview border-r-profile" width="100%" height="100%" src="{{asset('images/super-admin.png')}}">
                                                            </div>
                                                            {{-- <div  class="card-body circle bg-accent-4 xy-center profile-camera">
                                                                <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                                <input type='file' id="imageUpload"
                                                                    accept=".png, .jpg, .jpeg" class="d-none" />
                                                            </div> --}}
                                                            <div class="row mt-4 text-center">
                                                                {{-- <p class="font-accent profile-text-1">Click to upload</p>
                                                                <p class="profile-text-2">PNG or JPG MAX 2MB</p> --}}
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 mt-4">
                                    <div class="card border-0 radius-10 pt-4 pb-4">
                                        <div class="card-body">
                                            <div class="container mb-4">
                                                <h5 class="fw-bold mb-0 col-lg-6 font-accent mb-2">Profile Details</h5>
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="email">Email</label>
                                                        <input readonly disabled value="{{ auth()->user()->email }}"
                                                            placeholder="Email" id="name"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="email">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="user_name">Username</label>
                                                        <input readonly disabled value="{{ auth()->user()->user_name }}"
                                                            placeholder="Username" id="name"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="container mt-4">
                                                <h5 class="fw-bold mb-0 col-lg-6 font-accent mb-2">Change Password</h5>
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <label class="font-18 mb-2" for="client-name">Current
                                                            Password</label>
                                                        <input name="current_password" placeholder="Current Password"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="password">
                                                        @error('current_password')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">New Password</label>
                                                        <input name="new_password" placeholder="New Password"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="password">
                                                        @error('new_password')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="client-name">Confirm
                                                            Password</label>
                                                        <input name="password_confirmation" placeholder="Confirm Password"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="password">
                                                        @error('password_confirmation')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="offset-md-8 col-md-4 mt-2">
                                                        <button type="submit"  onclick="showLoader();"
                                                            class="btn-primary d-block text-center w-100 p-1 mb-2 pt-3 pb-3 radius-10">
                                                            Update Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
