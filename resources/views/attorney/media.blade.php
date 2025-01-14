@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Media')

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
                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Media</h2>
                    <div class="container">

                        <div class="row mt-2">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">Case 1</h5> </div>
                            <div class="col-md-4">
                                <a href="#" target="__blank">
                                    <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                                </a>
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/file.png')}}" class="media-file" alt="">
                            </div>
                        </div>

                        <div class="row mt-2 ">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">Case 2</h5> </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="row mb-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">Case 3</h5> </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('images/her0-banner-video.png')}}" class="media-file" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
