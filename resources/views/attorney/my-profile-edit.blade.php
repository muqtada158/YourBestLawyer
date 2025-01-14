@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | My Profile Edit')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-attorney')

                    </div>
                    <div class="customer-portal-content py-3">
                        <div class="row">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Edit Profile</h2>
                        </div>
                        <form action="{{ route('attorney_profile_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">
                                <div class="col-md-3 mt-4">
                                    <div class="card border-0 radius-10 pt-4">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row text-center">
                                                    <label for="imageUpload">
                                                        <div class="card border-0 text-center">
                                                            <div class="imagediv1 profile-camera xy-center">
                                                                @if (isset($user->getUserDetails->image))
                                                                    <img class="img-fluid image-preview border-r-profile"
                                                                        width="100%" height="100%"
                                                                        src="{{ asset($user->getUserDetails->image) }}">
                                                                @else
                                                                    <div
                                                                        class="card-body circle bg-accent-4 xy-center profile-camera">
                                                                        <i
                                                                            class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            <div class="row mt-4 text-center">
                                                                <input type='file' onchange="loadFile(this)"
                                                                    data-id="1" id="imageUpload"
                                                                    accept=".png, .jpg, .jpeg" class="d-none"
                                                                    name="image" />

                                                                <p class="font-accent profile-text-1">Click to upload</p>
                                                                <p class="profile-text-2">PNG or JPG MAX 5MB</p>
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
                                                    <div class="col-md-12">
                                                        <label class="font-18 mb-2" for="first_name">First name</label>
                                                        <input name="first_name"
                                                            value="{{ $user->getUserDetails->first_name }}"
                                                            placeholder="First name" id="first_name"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                        @error('first_name')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="last_name">Last name</label>
                                                        <input name="last_name"
                                                            value="{{ $user->getUserDetails->last_name }}"
                                                            placeholder="Last name" id="last_name"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                        @error('last_name')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="email">Email</label>
                                                        <input name="email" value="{{ $user->email }}" disabled readonly
                                                            placeholder="Email" id="email"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="email">
                                                        @error('email')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="user_name">Username</label>
                                                        <input name="user_name" value="{{ $user->user_name }}" disabled
                                                            readonly placeholder="Username" id="user_name"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                        @error('user_name')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="phone">Phone Number</label>
                                                        <input name="phone" value="{{ $user->getUserDetails->phone }}"
                                                            placeholder="Phone Number" id="phone"
                                                            class="phone-number form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                        @error('phone')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="address">Address</label>
                                                        <input name="address"
                                                            value="{{ $user->getUserDetails->address }}"
                                                            placeholder="Address" id="address"
                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                            type="text">
                                                        @error('address')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <label class="font-18 mb-2" for="bio">Bio</label>
                                                        <textarea name="bio" placeholder="Bio" id="bio" cols="30" rows="5" style="height: 150px"
                                                            class="form-control-lg w-100 radius-20 input-border form-input form-input-medium">{{ $user->getUserDetails->bio }}</textarea>
                                                        @error('bio')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                            <div class="container mt-4">
                                                <h5 class="fw-bold mb-0 col-lg-12 font-accent mb-2">Change Password</h5>
                                                <small>NOTE : If you dont want to change password leave these fields
                                                    empty.</small>
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
                                                        <button type="submit" onclick="showLoader();"
                                                            class="btn-primary d-block text-center w-100 p-1 mb-2 pt-3 pb-3 radius-10">
                                                            Update Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                        </form>
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
            $(".imagediv" + id).children().remove();
            // console.log(aug.dataset.id);


            for (var i = 0; i < aug.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML(
                            '<img class="img-fluid image-preview border-r-profile" width="100%" height="100%">'
                            )).attr('src', event.target.result).appendTo('.imagediv' + id);
                }
                reader.readAsDataURL(aug.files[i]);
            }
        };
    </script>
@endpush
