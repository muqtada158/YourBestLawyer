@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | My Profile Edit')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Edit Profile</h2>
                    </div>
                    <form action="{{route('customer_update_profile_store')}}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="row ">
                        <div class="col-md-3 mt-4">
                            <div class="card border-0 radius-10 pt-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row text-center">
                                        <label for="imageUpload">
                                            <div class="card border-0 text-center">
                                                <div class="imagediv1 profile-camera xy-center">
                                                    @if (isset($userProfile->getUserDetails->image))
                                                        <img class="img-fluid image-preview border-r-profile" width="100%" height="100%" src="{{asset($userProfile->getUserDetails->image)}}">
                                                    @else
                                                        <div class="card-body circle bg-accent-4 xy-center profile-camera">
                                                            <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="row mt-4 text-center">
                                                    <input type='file' onchange="loadFile(this)" data-id="1"  id="imageUpload" accept=".png, .jpg, .jpeg" class="d-none" name="image" />

                                                    <p class="font-accent profile-text-1">Click to upload</p>
                                                    <p class="profile-text-2">PNG or JPG MAX 2MB</p>
                                                </div>
                                            </div>
                                        </label>
                                        </div>

                                    </div>
                                </div>
                                @error('image')
                                    <div class="text-center">
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9 mt-4">
                            <div class="card border-0 radius-10 pt-4 pb-4">
                                <div class="card-body">
                                        <div class="container mb-4">
                                            <h5 class="fw-bold mb-0 col-lg-6 font-accent mb-2">Profile Details</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="font-18 mb-2" for="first_name">First Name</label>
                                                    <input  name="first_name" value="{{old('first_name')}}" placeholder="First Name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @error('first_name')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="last_name">Last Name</label>
                                                    <input  name="last_name" value="{{old('last_name')}}" placeholder="Last Name" id="last_name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @error('last_name')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">Date of birth</label>
                                                    <input  name="dob" value="{{old('dob')}}" placeholder="DOB" id="dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly>
                                                    @error('dob')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">Email</label>
                                                    <input value="{{auth()->user()->email}}" readonly name="email" placeholder="Email" id="email" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="email">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">Address</label>
                                                    <input  name="address" value="{{old('address')}}" placeholder="Address" id="address" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @error('address')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">Phone</label>
                                                    <input  name="phone" value="{{old('phone')}}" placeholder="Phone Number" id="phone" class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                    @error('phone')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="container mt-4">
                                            <h5 class="fw-bold mb-0 col-lg-6 font-accent mb-2">Change Password</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="font-18 mb-2" for="client-name">Current Password</label>
                                                    <input  name="current_password" placeholder="Current Password" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="password">
                                                    @error('current_password')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">New Password</label>
                                                    <input  name="new_password" placeholder="New Password" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="password">
                                                    @error('new_password')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="font-18 mb-2" for="client-name">Confirm Password</label>
                                                    <input  name="password_confirmation" placeholder="Confirm Password" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="password">
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
                                                    <button type="submit" onclick="showLoader();" class="btn-primary d-block text-center w-100 p-1 mb-2 pt-3 pb-3 radius-10"> Update Profile</button>
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
@push('js')
    <script>
        var loadFile = function(aug) {
        let id = aug.dataset.id;
            $(".imagediv"+id).children().remove();
            // console.log(aug.dataset.id);


            for (var i=0; i<aug.files.length; i++)
            {
                var reader = new FileReader();
                reader.onload = function(event)
                {
                    $($.parseHTML('<img class="img-fluid image-preview border-r-profile" width="100%" height="100%">')).attr('src', event.target.result).appendTo('.imagediv'+id);
                }
                reader.readAsDataURL(aug.files[i]);
            }
        };
    </script>
    <script>
        $(function() {
            // Calculate the date 120 years ago from today
            var today = new Date();
            var oneHundredTwentyYearsAgo = new Date(today.getFullYear() - 120, today.getMonth(), today.getDate());

            // Calculate the date 21 years ago from today
            var twentyOneYearsAgo = new Date(today.getFullYear() - 21, today.getMonth(), today.getDate());

            // Initialize the datepicker for Date of Birth
            $("#dob").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: oneHundredTwentyYearsAgo.getFullYear() + ':' + twentyOneYearsAgo.getFullYear(), // Allow selection of dates from 120 years ago up to 21 years ago
                maxDate: twentyOneYearsAgo, // Disable all future dates beyond 21 years ago
                minDate: oneHundredTwentyYearsAgo // Disable all dates after 120 years ago
            });
        });

    </script>
@endpush
