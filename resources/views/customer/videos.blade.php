@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Videos')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-customer')
                </div>
                <div class="customer-portal-content py-3">
                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Videos</h2>
                    <div class="container">

                        <div class="row mt-4">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">Personal Injury</h5> </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">Family Law</h5> </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">DUI</h5> </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
                                </a>
                            </div>
                            <div class="col-md-4 position-relative">
                                <a href="{{route('customer_video_details')}}">
                                    <img src="{{asset('images/Rectangle_Video.png')}}" class="video-cover" alt="">
                                    <div class="play-overlay"></div>
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
