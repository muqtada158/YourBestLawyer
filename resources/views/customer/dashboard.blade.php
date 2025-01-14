@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Dashboard')

@section('content')

    <div id="content">
        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">

                <div class="p-3 p-md-5 background-attorney">
                    <div class="container">
                        <div class="row avatar-upload">
                            <div class=" customer-avatar-box">
                                <div class="avatar-edit">
                                    {{-- <form action="" method="post" id="form-image">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" disabled/>
                                        <label for="imageUpload"></label>
                                    </form> --}}
                                </div>
                                <div class="avatar-preview">
                                    <img class="profile-user-img img-responsive img-circle" id="imagePreview"
                                        src="{{asset(getUser()->getUserDetails->image)}}"
                                        alt="{{asset(getUser()->getUserDetails->image)}}">
                                    <h4 class="customer-name font-18 mt-2 fw-bold font-accent">{{ucfirst(getUser()->getUserDetails->first_name)}} {{ucfirst(getUser()->getUserDetails->last_name)}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix-top-100 ">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group has-search position-relative">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" id="search"
                                    class="has-search form-control form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    placeholder="Search">
                                    <div class="container search-dropdown dropdown-menu position-absolute w-100" style="left: 0;">
                                        <div class="row mt-2">
                                            <ul class="list-style-none" id="search-results">
                                                <li class="search-list">
                                                    <a href="javascript:void()">
                                                        <div class="row xy-center">
                                                            <div class="col-md-10">
                                                                <p class="text-black fw-bold mb-0 mt-1"> Kindly enter minimum 3 numbers of case SR NO # to search</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="col-md-2 text-center">
                                <div class="demo-preview">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary-2"><i
                                                class="fa-solid fa-sliders"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary-2 dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="flag-icon"></span>
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu notif-dropdown">
                                            <div class="container ">
                                                <div class="row">
                                                    <ul class="list-style-none">
                                                        <li class="lang-list">
                                                            <a href="#">
                                                                <div class="row">
                                                                        <p class="text-black mb-0 mt-1">English</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="lang-list">
                                                            <a href="#">
                                                                <div class="row">
                                                                        <p class="text-black mb-0 mt-1">Deutsch</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="lang-list">
                                                            <a href="#">
                                                                <div class="row">
                                                                        <p class="text-black mb-0 mt-1">Español</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button class="search-button">
                                                <img src="{{ asset('images/Group 6397.png') }}" alt="Button image">
                                            </button>
                                            <button type="button" class="btn btn-secondary-2 "><i class="fa-solid fa-headset" ></i></button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="search-button dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <img src="{{ asset('images/Group 6398.png') }}" alt="Button image">
                                                <span class="notification-badge">4</span>
                                            </button>
                                            <div class="dropdown-menu notif-dropdown">
                                                <div class="container ">
                                                    <div class="row">
                                                        <h4 class="font-accent mt-2">Notifications</h4>
                                                    </div>
                                                    <div class="row">
                                                        <ul class="list-style-none">
                                                            <li class="noti-list">
                                                                <a href="#">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <img class="notification-img-circle"
                                                                                id="imagePreview"
                                                                                src="{{ asset('images/case-detials-iamge.png') }}"
                                                                                alt="notification picture">
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <p class="text-black fw-bold font-12 mb-0 mt-1">
                                                                                Adv. Marcus Stoinis</p>
                                                                            <p class="text-accent-3 font-12 mb-0 mt-1">New
                                                                                Registered Attorney</p>
                                                                        </div>
                                                                        <div class="col-2 text-end">
                                                                            <p class="text-black font-12 mb-0 mt-1">10:24
                                                                            </p>
                                                                            <p class="font-12 mb-0 mt-1 notification-badge">
                                                                                1</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="noti-list">
                                                                <a href="#">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <img class="notification-img-circle"
                                                                                id="imagePreview"
                                                                                src="{{ asset('images/case-detials-iamge.png') }}"
                                                                                alt="notification picture">
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <p
                                                                                class="text-black fw-bold font-12 mb-0 mt-1">
                                                                                Adv. Marcus Stoinis</p>
                                                                            <p class="text-accent-3 font-12 mb-0 mt-1">New
                                                                                Registered Attorney</p>
                                                                        </div>
                                                                        <div class="col-2 text-end">
                                                                            <p class="text-black font-12 mb-0 mt-1">10:24
                                                                            </p>
                                                                            <p
                                                                                class="font-12 mb-0 mt-1 notification-badge">
                                                                                1</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="noti-list">
                                                                <a href="#">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <img class="notification-img-circle"
                                                                                id="imagePreview"
                                                                                src="{{ asset('images/case-detials-iamge.png') }}"
                                                                                alt="notification picture">
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <p
                                                                                class="text-black fw-bold font-12 mb-0 mt-1">
                                                                                Adv. Marcus Stoinis</p>
                                                                            <p class="text-accent-3 font-12 mb-0 mt-1">New
                                                                                Registered Attorney</p>
                                                                        </div>
                                                                        <div class="col-2 text-end">
                                                                            <p class="text-black font-12 mb-0 mt-1">10:24
                                                                            </p>
                                                                            <p
                                                                                class="font-12 mb-0 mt-1 notification-badge">
                                                                                1</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="noti-list">
                                                                <a href="#">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <img class="notification-img-circle"
                                                                                id="imagePreview"
                                                                                src="{{ asset('images/case-detials-iamge.png') }}"
                                                                                alt="notification picture">
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <p
                                                                                class="text-black fw-bold font-12 mb-0 mt-1">
                                                                                Adv. Marcus Stoinis</p>
                                                                            <p class="text-accent-3 font-12 mb-0 mt-1">New
                                                                                Registered Attorney</p>
                                                                        </div>
                                                                        <div class="col-2 text-end">
                                                                            <p class="text-black font-12 mb-0 mt-1">10:24
                                                                            </p>
                                                                            <p
                                                                                class="font-12 mb-0 mt-1 notification-badge">
                                                                                1</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div> --}}
                            <div class="row mt-4 pt-4">
                                <div class="col-md-12">
                                    <div class="ban_img">
                                        <img src="{{ asset('images/customer-banner.jpg') }}" alt="banner" border="0"
                                            class="w-100">
                                        <div class="ban_text">
                                            <h2 class="font-accent">Your Best Lawyer </h2>
                                            <h3 class="font-accent">Customer</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="container-fluid background-grey">
                        <div class="container">
                            <div class="row text-center">
                                <div class="offset-md-4 col-md-2">
                                    <div class="mt-2 mb-2">
                                        <a href="{{ route('customer_schedule') }}" class="btn btn-secondary-3 w-100 icon-btn">
                                            <img src="{{asset('images/svg/calendar.png')}}">
                                            <span class="btn-text-dash">Schedule</span></a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mt-2 mb-2">
                                        <a href="{{ route('customer_contract') }}" class="btn btn-secondary-3 w-100 icon-btn">
                                            <img src="{{asset('images/svg/Contract.svg')}}">
                                            <span class="btn-text-dash">Contracts</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 p-md-5 background-attorney">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_applications') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/application.svg')}}">
                                                </span>
                                                <h3 class=" mt-4 dash-card-text ">Application</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_profile') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/user.svg')}}">
                                                </span>
                                                <h3 class=" mt-4 dash-card-text ">Profile</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_media') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                     <img src="{{asset('images/svg/video.svg')}}">
                                                </span>
                                                <h3 class=" mt-4 dash-card-text ">Media</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_payment_transactions') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/payment.svg')}}">
                                               </span>
                                                <h3 class=" mt-4 dash-card-text ">Payment Transaction</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_attornies') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/Mask group (4).svg')}}">
                                               </span>
                                                <h3 class=" mt-4 dash-card-text ">Attornies</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_cases') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/Mask group (5).svg')}}">
                                               </span>
                                                <h3 class=" mt-4 dash-card-text ">Casses</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card dash-card">
                                        <a href="{{ route('customer_chat_list') }}">
                                            <div class="card-body text-center">
                                                <span class="dash-card-icon">
                                                    <img src="{{asset('images/svg/Messenger.png')}}">
                                                </span>
                                                <h3 class=" mt-4 dash-card-text ">Chat</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

    </div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var search = $(this).val();
            if (search.length > 2) { // Start searching after 3 characters
                $.ajax({
                    url: "{{ route('customer_search') }}",
                    type: "POST",
                    data: {search: search,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        $('#search-results').html(data);

                        // Show the dropdown if there are results
                        if ($('#search-results').children().length > 0) {
                            $('.search-dropdown').addClass('show');
                        } else {
                            $('.search-dropdown').removeClass('show');
                        }
                    },
                    error: function() {
                        console.error("An error occurred while fetching search results.");
                        $('.search-dropdown').removeClass('show');
                    }
                });
            } else {
                $('#search-results').empty();
                $('.search-dropdown').removeClass('show');
            }
        });

        // Close the dropdown when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#search').length && !$(event.target).closest('.search-dropdown').length) {
                $('.search-dropdown').removeClass('show');
            }
        });
    });
</script>
@endpush
