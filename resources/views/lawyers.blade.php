@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Lawyers')

@section('content')

    @push('css')
        <style>
            .slider-container {
                position: relative;
                margin: 0 auto;
                width: 800px;
                height: 600px;
            }

            .slider-container .bullet-container {
                position: absolute;
                bottom: 10px;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .slider-container .bullet-container .bullet {
                margin-right: 14px;
                height: 15px;
                width: 15px;
                border-radius: 50%;
                background-color: #000;
                opacity: 0.5;
            }

            .slider-container .bullet-container .bullet:last-child {
                margin-right: 0px;
            }

            .slider-container .bullet-container .bullet.active {
                opacity: 1;
            }

            .slider-container .slider-content {
                position: relative;
                left: 50%;
                top: 50%;
                width: 100%;
                height: 70%;
                transform: translate(-50%, -50%);
            }

            .slider-container .slider-content .slider-single {
                position: absolute;
                z-index: 0;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                transition: z-index 0ms 250ms;
            }

            .slider-container .slider-content .slider-single .slider-single-image {
                position: relative;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.2);
                transition: 500ms cubic-bezier(0.17, 0.67, 0.55, 1.43);
                transform: scale(0);
                opacity: 0;
            }

            .slider-container .slider-content .slider-single .slider-single-download {
                position: absolute;
                display: block;
                right: -22px;
                bottom: 12px;
                padding: 15px;
                color: #333333;
                background-color: #fdc84b;
                font-size: 18px;
                font-weight: 600;
                font-family: "karla";
                border-radius: 5px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                transition: 500ms cubic-bezier(0.17, 0.67, 0.55, 1.43);
                opacity: 0;
            }

            .slider-container .slider-content .slider-single .slider-single-download:hover,
            .slider-container .slider-content .slider-single .slider-single-download:focus {
                outline: none;
                text-decoration: none;
            }

            .slider-container .slider-content .slider-single .slider-single-title {
                display: block;
                float: left;
                margin: 16px 0 0 20px;
                font-size: 20px;
                font-family: "karla";
                font-weight: 400;
                color: #ffffff;
                transition: 500ms cubic-bezier(0.17, 0.67, 0.55, 1.43);
                opacity: 0;
            }

            .slider-container .slider-content .slider-single .slider-single-likes {
                display: block;
                float: right;
                margin: 16px 20px 0 0;
                transition: 500ms cubic-bezier(0.17, 0.67, 0.55, 1.43);
                opacity: 0;
            }

            .slider-container .slider-content .slider-single .slider-single-likes i {
                font-size: 20px;
                display: inline-block;
                vertical-align: middle;
                margin-right: 5px;
                color: #ff6060;
                transition: 500ms cubic-bezier(0.17, 0.67, 0.55, 1.43);
                transform: scale(0);
            }

            .slider-container .slider-content .slider-single .slider-single-likes p {
                display: inline-block;
                vertical-align: middle;
                margin: 0;
                color: #ffffff;
            }

            .slider-container .slider-content .slider-single .slider-single-likes:hover,
            .slider-container .slider-content .slider-single .slider-single-likes:focus {
                outline: none;
                text-decoration: none;
            }

            .slider-container .slider-content .slider-single.preactivede .slider-single-image {
                transform: translateX(-50%) scale(0);
            }

            .slider-container .slider-content .slider-single.preactive {
                z-index: 1;
            }

            .slider-container .slider-content .slider-single.preactive .slider-single-image {
                opacity: 0.3;
                transform: translateX(-25%) scale(0.8);
            }

            .slider-container .slider-content .slider-single.preactive .slider-single-download {
                transform: translateX(-150px);
            }

            .slider-container .slider-content .slider-single.preactive .slider-single-title {
                transform: translateX(-150px);
            }

            .slider-container .slider-content .slider-single.preactive .slider-single-likes {
                transform: translateX(-150px);
            }

            .slider-container .slider-content .slider-single.proactive {
                z-index: 1;
            }

            .slider-container .slider-content .slider-single.proactive .slider-single-image {
                opacity: 0.3;
                transform: translateX(25%) scale(0.8);
            }

            .slider-container .slider-content .slider-single.proactive .slider-single-download {
                transform: translateX(150px);
            }

            .slider-container .slider-content .slider-single.proactive .slider-single-title {
                transform: translateX(150px);
            }

            .slider-container .slider-content .slider-single.proactive .slider-single-likes {
                transform: translateX(150px);
            }

            .slider-container .slider-content .slider-single.proactivede .slider-single-image {
                transform: translateX(50%) scale(0);
            }

            .slider-container .slider-content .slider-single.active {
                z-index: 2;
            }

            .slider-container .slider-content .slider-single.active .slider-single-image {
                opacity: 1;
                transform: translateX(0%) scale(1);
            }

            .slider-container .slider-content .slider-single.active .slider-single-download {
                opacity: 1;
                transition-delay: 100ms;
                transform: translateX(0px);
            }

            .slider-container .slider-content .slider-single.active .slider-single-title {
                opacity: 1;
                transition-delay: 200ms;
                transform: translateX(0px);
            }

            .slider-container .slider-content .slider-single.active .slider-single-likes {
                opacity: 1;
                transition-delay: 300ms;
                transform: translateX(0px);
            }

            .slider-container .slider-content .slider-single.active .slider-single-likes i {
                animation-name: heartbeat;
                animation-duration: 500ms;
                animation-delay: 900ms;
                animation-iteration-count: 1;
                animation-fill-mode: forwards;
            }

            .slider-container .slider-left {
                position: absolute;
                z-index: 3;
                display: block;
                font-size: 25px;
                right: 65%;
                top: 97%;
                color: #000;
                transform: translateY(-50%);
                padding: 20px 15px;
            }

            .slider-container .slider-right {
                position: absolute;
                font-size: 25px;
                z-index: 3;
                display: block;
                left: 65%;
                top: 97%;
                color: #000;
                transform: translateY(-50%);
                padding: 20px 15px;
            }

            .slider-container .not-visible {
                display: none !important;
            }
        </style>
    @endpush


    <div id="content">

        <section id="hero-section" class="hero-banner bg-cover bg-repeat-none bg-position-center bg-overlay-black"
            style="background-image:url('{{ asset('images/lawyers-bg.png') }}')">
            <div class="container-xxl padding-section-medium">
                <h1 class="text-center fw-bold text-white">Lawyers</h1>
            </div>
        </section>
        <section id="introduction" class="padding-section-medium">
            <div class="container-xxl text-center">
                <h2 class="text-primary">Revolutionizing How Attorneys Connect with Clients!</h2>
            </div>
        </section>
        <section id="introduction-image-content" class="padding-right">
            <div class="container-xxl">
                <div class="row mt-2">
                    <div style="background-image:url('{{ asset('images/front-thumbnail.png') }}'); min-height: 500px; border-radius: 0px 100px 0px 0px;border: 1px solid black;
    border-bottom: 0px;"
                        class="col-md-5 bg-cover bg-position-center d-flex align-items-center justify-content-center">
                        <a href="https://player.vimeo.com/video/905218885" data-toggle="lightbox"><img
                                src="{{ asset('images/Youtube.png') }}" class="animate__animated animate__shakeX"
                                alt="" srcset=""></a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6 mt-2">
                        <p class="m-0 py-2 font-18">Frustrated with spending money on ads and lead services that don’t
                            deliver results? We’ve got you covered. <strong> YourBestLawyer.com </strong> is changing the
                            game by eliminating upfront costs and streamlining the client intake process. Say goodbye to
                            pay-per-click and time-consuming consultations. Here, clients come to you educated and ready to
                            move forward, saving you time and money.</p>
                        <h3 class="text-primary mt-2">Why YourBestLawyer.com?</h3>
                        <p class="m-0 py-2 font-18">
                            <strong>
                                No Upfront Costs
                            </strong>
                        <p>
                            Unlike traditional ads, you only pay a flat fee when you choose to pursue a lead.
                        </p>
                        <strong>
                            Educated Clients
                        </strong>
                        <p>
                            We educate clients upfront so they’re ready to act—no need for long consultations.
                        </p>
                        <strong>
                            No Marketing Hassles
                        </strong>
                        <p>
                            Say goodbye to SEO, social media, and PPC. You'll have access to a treasure trove of ongoing
                            leads, ready, able, and willing to hire you. All you need to do is choose the clients you want
                            to work with.
                        </p>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover container-xxl registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
            </div>
            <div class="container-xxl padding-section-medium registration-form-section design-section-2">
                <div class="row p-3 p-md-5 background-attorney">
                    <h2 class="text-center">Register Attorney</h2>
                    <form action="{{ route('register_view') }}" method="Get">
                        <input type="hidden" name="type" value="attorney">
                        <div id="steps-checks" class="d-flex justify-content-center align-items-center mb-5 mt-3">
                            <div id="step-1-check" class="circle-icon circle-icon-small step-check active"><i
                                    class="fa-solid fa-check"></i></div>
                            <div class="step-line"></div>
                            <div id="step-2-check" class="circle-icon circle-icon-small step-check"><i
                                    class="fa-solid fa-check"></i></div>
                            <div class="step-line"></div>
                            <div id="step-3-check" class="circle-icon circle-icon-small step-check"><i
                                    class="fa-solid fa-check"></i></div>
                        </div>
                        <div class="step" id="step-1">
                            <h3 class="mb-4">Attorney Information</h3>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input required name="username"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium"
                                        type="text" placeholder="Attorney Name">
                                </div>
                                <div class="col-md-6">
                                    <input required name="solo_practitioner_on_law_firm"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium"
                                        type="text" placeholder="Solo Practitioner on law firm">
                                </div>
                                <div class="col-md-6">
                                    <input required name="name_of_law_firm"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium"
                                        type="text" placeholder="Name of Law Firm">
                                </div>
                                <div class="col-md-6">
                                    <input required name="position"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium"
                                        type="text" placeholder="Position">
                                </div>
                                <div class="col-md-6">
                                    <input required name="email"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium"
                                        type="email" placeholder="Email">
                                </div>
                                <div class="col-md-6">
                                    <input required name="phone"
                                        class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium phone-number"
                                        type="text" placeholder="Phone">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <input class="btn bg-primary text-white py-2 px-5 font-20 radius-10 btn-next"
                                        type="button" value="Next">
                                </div>
                            </div>
                        </div>
                        <div class="step" id="step-2">
                            <div class="swiper slider-videos">
                                <div class="container">
                                    <div class="row">
                                        <div class="offset-md-3 col-md-6">
                                            <div style="background-image:url('{{ asset('images/front-thumbnail.png') }}'); min-height: 500px; border: 1px solid black;
                                        border-bottom: 0px;"
                                                class="col-md-12 bg-cover bg-position-center d-flex align-items-center justify-content-center">
                                                <a href="https://player.vimeo.com/video/905259665"
                                                    data-toggle="lightbox"><img src="{{ asset('images/Youtube.png') }}"
                                                        class="animate__animated animate__shakeX" alt=""
                                                        srcset=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <input class="btn bg-primary text-white py-2 px-5 font-20 radius-10 btn-prev"
                                            type="button" value="Previous">
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <input class="btn bg-primary text-white py-2 px-5 font-20 radius-10 btn-next"
                                            type="button" value="Next">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step" id="step-3">
                            <h3 class="mb-4 text-center">Ready to take the next step?</h3>
                            <p class="font-28 text-center m-0">Now that you've watched the video, it’s time to create your
                                profile and unlock exclusive access to our fee schedule. Dive in and discover how easy it is
                                to connect with clients who are ready to work with you. Your journey toward growing your
                                practice starts here create your profile and start exploring today!</p>
                            <div class="submit-buttons mt-4 d-flex justify-content-center flex-column gap-3 flex-md-row">
                                <div class="col-md-6">
                                    <input class="btn bg-primary text-white py-2 px-5 font-20 radius-10 btn-prev"
                                        type="button" value="Previous">
                                </div>
                                <div class="col-md-6 text-end">
                                    {{-- <a href="{{route('register_view')}}" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">Sign Up</a> --}}
                                    <button type="submit"
                                        class="btn bg-primary text-white py-2 px-5 font-20 radius-10">Next</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>

        <section id="cta" class="">
            <div class="container-sm padding-section-medium pt-0 text-center">
                <h2 class="text-primary font-48">Ready to elevate your <span class="text-dark">legal practice?</span></h2>
                <p class="mt-3 mb-0 fs-5 text-dark">Imagine connecting with clients who are not just interested, but ready
                    to hire you! <br> At <span class="text-primary">YourBestLawyer.com</span>, we’re revolutionizing how
                    attorneys grow their practice—no more chasing leads or wasting money on endless advertising. We bring
                    clients to you, ready for action, so you can focus on doing what you do best: delivering exceptional
                    legal services.</p> <br>
                <p class="mt-1 mb-0 fs-5 text-dark">Take control of your future fill out the form above and start tapping
                    into a treasure trove of clients looking for your expertise. Whether you're a solo attorney or part of a
                    powerhouse firm, this is your chance to grow your business like never before.</p> <br>
                <p class="mt-1 mb-0 fs-5 text-dark">Don’t wait join the legal revolution today and experience the next
                    level of success!</p>
            </div>
        </section>

        {{-- <section id="reviews-section" style="background-image: url({{asset('images/testimonial-bg.png')}}); background-repeat: no-repeat; background-position: center right; background-size: contain;">
        <div class="container-lg padding-section-medium text-center">
            <h3 class="text-primary font-28">Testimonials</h3>
            <h2 class="font-48">What Our <span class="text-primary">Clients</span> Say</h2>
            <div class="testimonial-images-swiper swiper mt-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide text-center">
                        <img src="{{asset("images/testimonials/t1.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center">
                        <img src="{{asset("images/testimonials/t2.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center">
                        <img src="{{asset("images/testimonials/t3.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center">
                        <img src="{{asset("images/testimonials/t4.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center ">
                        <img src="{{asset("images/testimonials/t5.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center ">
                        <img src="{{asset("images/testimonials/t6.png")}}" alt="">
                    </div>
                    <div class="swiper-slide text-center ">
                        <img src="{{asset("images/testimonials/t7.png")}}" alt="">
                    </div>
                </div>
                <div class="swiper-button-prev text-black"></div>
                <div class="swiper-button-next text-black"></div>
            </div>

            @include('testimonials')
        </div>
    </section> --}}

        {{-- <section id="featured-logos-section">
        <div class="container-xxl padding-section-medium">
            <div class="featured-logos">
                <div class="featured-logo d-flex align-items-center justify-content-center">
                    <img src="{{asset('images/featured-logo1.png')}}">
                </div>
                <div class="featured-logo d-flex align-items-center justify-content-center">
                    <img src="{{asset('images/featured-logo2.png')}}">
                </div>
                <div class="featured-logo d-flex align-items-center justify-content-center">
                    <img src="{{asset('images/featured-logo3.png')}}">
                </div>
                <div class="featured-logo d-flex align-items-center justify-content-center">
                    <img src="{{asset('images/featured-logo4.png')}}">
                </div>
                <div class="featured-logo d-flex align-items-center justify-content-center">
                    <img src="{{asset('images/featured-logo5.png')}}">
                </div>
            </div>
        </div>
    </section> --}}
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/lawyers.js') }}"></script>
@endpush
