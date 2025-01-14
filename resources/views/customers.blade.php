@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Case Types')

@section('content')

    <div id="content">

        <section id="hero-section" class="hero-banner bg-cover bg-repeat-none bg-position-center bg-overlay-black"
            style="background-image:url('{{ asset('images/dui-information-bg.png') }}')">
            <div class="container-xxl padding-section-medium">
                <h1 class="text-center fw-bold text-white">Case Types</h1>
            </div>
        </section>

        <section id="features-boxes-section" style="background-image: url('{{ asset('images/featured-box-bg.png') }}');">
            <div class="container-xxl padding-section-medium">
                <div class="row mt-2 mb-2">
                    <h2 class="text-center fw-bold">Ready To View Details And Start Bidding</h2>
                    <div class="col-md-4 mt-4">
                        <a class="text-white" href="{{route('marketing_main_cases',[2])}}">
                            <img class="stamp" src="{{ asset('images/stamp.png') }}" alt="Stamp">
                            <div style="background-image: url('{{ asset('images/Group 150.png') }}');"
                                class="featured-box ">
                                <div class="feature-box-type-1">
                                    <div class="icon-heading d-flex align-items-center">
                                        <img width="65px" src="{{ asset('images/hammer.png') }}" alt="">
                                        <h2 class="font-28 text-white my-0 ms-3">DUI</h2>
                                    </div>
                                    <hr class="text-white border-1 border border-white opacity-1 mb-0 mt-2">
                                    <ul class="text-white my-2 font-20 myoverflow">
                                        <li>
                                            First Offense DUI within 7 years
                                        </li>
                                        <li>
                                            First Offense Extreme DUI within 7 years
                                        </li>
                                        <li>
                                            First Offense Super Extreme DUI within 7 years
                                        </li>
                                        <li>
                                            First Offense DUI Drugs within 7 years
                                        </li>
                                        <li>
                                            Second offense DUI within 7 years
                                        </li>
                                        <li>
                                            Second Offense Extreme DUI within 7 years(.15%)
                                        </li>
                                        <li>
                                            Second Offense Super Extreme DUI within 7 years (OVER .20%)
                                        </li>
                                        <li>
                                            Second Offense DUI Drugs within 7 Years
                                        </li>
                                        <li>
                                            Aggravated DUI Felony 6 (DUI With Children in vehicle 15 years or below)
                                        </li>
                                        <li>
                                            Aggravated DUI Felony 4 (Wrong Way Driving)
                                        </li>
                                        <li>
                                            Aggravated DUI Felony 4 (Third offense within 7 years)
                                        </li>
                                        <li>
                                            Aggravated DUI Felony 4 (DUI with Suspended License)
                                        </li>
                                    </ul>
                                    <div class="get-started text-white">Learn More<i
                                            class="ms-3 fa-solid fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-4">
                        <a class="text-white" href="{{route('marketing_main_cases',[5])}}">
                        <div style="background-image: url('{{ asset('images/Rectangle 61.png') }}');"
                            class="featured-box ">
                            <div class="feature-box-type-2">
                                <div class="icon-heading d-flex align-items-center">
                                    <img width="65px" src="{{ asset('images/Family Law.png') }}" alt="">
                                    <h2 class="font-28 text-white my-0 ms-3">Bankruptcy Law</h2>
                                </div>
                                <hr class="text-white border-1 border border-white opacity-1 mb-0 mt-2">
                                <ul class="text-white my-2 font-20 myoverflow">
                                    <li>
                                        Bankruptcy Chapter 11
                                    </li>
                                    <li>
                                        Bankruptcy Chapter 13
                                    </li>
                                    <li>
                                        Bankruptcy Chapter 7
                                    </li>
                                </ul>
                                <div class="get-started text-white">Learn More<i class="ms-3 fa-solid fa-arrow-right"></i></div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-4">
                        <a class="text-white" href="{{route('marketing_main_cases',[3])}}">
                        <img class="stamp" src="{{ asset('images/stamp.png') }}" alt="Stamp">
                        <div style="background-image: url('{{ asset('images/Group 150.png') }}');" class="featured-box ">
                            <div class="feature-box-type-1">
                                <div class="icon-heading d-flex align-items-center">
                                    <img width="65px" src="{{ asset('images/shield.png') }}" alt="">
                                    <h2 class="font-28 text-white my-0 ms-3">Personal Injury</h2>
                                </div>
                                <hr class="text-white border-1 border border-white opacity-1 mb-0 mt-2">
                                <ul class="text-white my-2 font-20 myoverflow">
                                    <li>
                                        Motorized Vehicle Accident
                                    </li>
                                    <li>
                                        Slip and Fall Accidents
                                    </li>
                                    <li>
                                        Workers Compensation (Coming Soon)
                                    </li>
                                </ul>
                                <div class=" get-started text-white">Learn More<i
                                        class="ms-3 fa-solid fa-arrow-right"></i></div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="row mt-4">
                    <h2 class="text-center fw-bold mt-4">Ready To View Details But Not Available To Start Bidding</h2>
                    <div class="offset-md-2 col-md-4 mt-4">
                        <a class="text-white" href="{{route('marketing_main_cases',[1])}}">
                            <div style="background-image: url('{{ asset('images/Rectangle 61.png') }}');"
                                class="featured-box ">
                                <div class="feature-box-type-2">
                                    <div class="icon-heading d-flex align-items-center">
                                        <img width="65px" src="{{ asset('images/Family Law.png') }}" alt="">
                                        <h2 class="font-28 text-white my-0 ms-3">Family Law</h2>
                                    </div>
                                    <hr class="text-white border-1 border border-white opacity-1 mb-0 mt-2">
                                    <ul class="text-white my-2 font-20 myoverflow">
                                        <li>
                                            Legal Separation without children
                                        </li>
                                        <li>
                                            Legal Separation with Children
                                        </li>
                                        <li>
                                            Non-Married Couples: Establish Paternity / Child Custody / Child Support
                                        </li>
                                    </ul>
                                    <div class="get-started text-white">Learn More<i
                                            class="ms-3 fa-solid fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-4">
                        <a class="text-white" href="{{route('marketing_main_cases',[6])}}">
                        <div style="background-image: url('{{ asset('images/Group 152.png') }}');" class="featured-box ">
                            <div class="feature-box-type-1">
                                <div class="icon-heading d-flex align-items-center">
                                    <img width="65px" src="{{ asset('images/shield.png') }}" alt="">
                                    <h2 class="font-28 text-white my-0 ms-3">Civil Law</h2>
                                </div>
                                <hr class="text-white border-1 border border-white opacity-1 mb-0 mt-2">
                                <ul class="text-white my-2 font-20 myoverflow mb-2">
                                    <li>
                                        Civil Lawsuits over $3,500.00 / Civil Lawsuits
                                    </li>
                                    <li>
                                        Small Claims Suits / Lawsuits Below $3,500.00
                                    </li>
                                </ul>
                                <div class="get-started text-white">Learn More<i class="ms-3 fa-solid fa-arrow-right"></i></div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="cta" class="bg-accent padding-section-medium">
            <div class="container-sm text-center">
                <h2 class="text-white">Solve Your <span class="text-primary">Legal Matters </span> With Us !</h2>
                <p class="text-white mt-3 mb-0">You can access a range of resources designed to guide you through the legal process, from understanding civil lawsuits to exploring cost-effective legal solutions.</p>
                <a onclick="checkUserAndRedirect();" class="btn btn-primary text-white mt-5">Get Started</a>
            </div>
        </section>
        <section id="services-section" class="padding-section-medium bg-repeat-none bg-cover bg-position-center"
            style="background-image: url('{{ asset('images/services-bg.png') }}');">
            <div class="container-xxl position-relative">
                <div class="padding-right padding-left padding-x-m-0">
                    <h2 class="text-primary font-40 text-center">Practice Areas (Coming Soon)</h2>
                    <p class="m-0 font-28 text-center">Explore Our Practice Areas, Protect Your Rights, and Achieve Justice With Us!
                    </p>
                </div>
                <img src="{{ asset('images/stapmer.png') }}" class="pracetice-area-stamp" alt="">
                <div class="services">
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Administration Law.png') }}" alt="Administration Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Administration Law</h3>
                        {{-- <p>We will ensure that you get fair treatment from government agencies and regulatory bodies. We
                            will protect your rights and advocate for just outcomes.</p> --}}
                        <a href="#" class="text-primary">Coming Soon
                            {{-- <img class="mt-2" src="{{ asset('images/arrow-right.png') }}"  alt="Arrow Right"> --}}
                        </a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Administration Law.png') }}" alt="Bankruptcy Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Bankruptcy Law</h3>
                        {{-- <p>Our attorneys guide clients through bankruptcy proceedings, offering solutions for debt relief
                            and a fresh start.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Civil Law.png') }}" alt="Civil Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Civil Law</h3>
                        {{-- <p>From personal injury claims to contract disputes, we provide skilled representation to achieve
                            favorable resolutions.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Civil Law.png') }}" alt="Contract Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Contract Law</h3>
                        {{-- <p>Whether you're entering into agreements or need contract enforcement, we ensure clarity and
                            enforceability.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Criminal Law.png') }}" alt="Criminal Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Criminal Law</h3>
                        {{-- <p>Our criminal defense team provides aggressive representation in all phases of the legal process.
                        </p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Employement Law.png') }}" alt="Employment Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Employment Law</h3>
                        {{-- <p>We handle issues such as discrimination, wrongful termination, wage disputes, and compliance with
                            labor laws to ensure fair treatment.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Environmental Law.png') }}" alt="Environmental Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Environmental Law</h3>
                        {{-- <p>LaunchWe assist clients with regulatory issues, pollution control, land use planning, and
                            sustainable business practices.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Environmental Law.png') }}" alt="Immigration Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Immigration Law</h3>
                        {{-- <p>Our services include visa applications, citizenship issues, deportation defense, and compliance
                            with immigration laws.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Indian Law.png') }}" alt="Indian Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Indian Law</h3>
                        {{-- <p>We support tribal sovereignty, land rights, economic development, and cultural preservation
                            within the framework of federal and tribal laws.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Intellectual Property Law.png') }}"
                            alt="Intellectual Property Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Intellectual Property Law</h3>
                        {{-- <p>We handle patents, trademarks, copyrights, and trade secrets to safeguard your intellectual
                            property rights and prevent infringement.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/International Law.png') }}" alt="Internatinal Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">International Law</h3>
                        {{-- <p>Our international law expertise includes treaties, trade agreements, diplomatic negotiations, and
                            dispute resolution.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/International Law.png') }}" alt="Real Estate Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Real Estate Law</h3>
                        {{-- <p>From residential closings to commercial leases and zoning issues, we provide comprehensive legal
                            services to protect your real estate interests.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="empty"></div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/Intellectual Property Law.png') }}"
                            alt="Securities Regulations Laws">
                        <h3 class="mt-4 mb-4 text-primary font-28">Securities Regulations Laws</h3>
                        {{-- <p>We advise on securities offerings, mergers and acquisitions, regulatory filings, and corporate
                            governance to promote transparency and accountability.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                    <div class="service text-center">
                        <img src="{{ asset('images/laws/International Law.png') }}" alt="Will, Trust and Estate Law">
                        <h3 class="mt-4 mb-4 text-primary font-28">Will, Trust and Estate Law</h3>
                        {{-- <p>Our attorneys assist with wills, trusts, probate administration, and estate planning strategies
                            to ensure your wishes are carried out and your loved ones are protected.</p> --}}
                        <a href="#" class="text-primary">Coming Soon</a>
                    </div>
                </div>
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
                        <img src="{{ asset('images/featured-logo1') }}.png">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo2') }}.png">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo3') }}.png">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo4') }}.png">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo5') }}.png">
                    </div>
                </div>
            </div>
        </section> --}}
    </div>

@endsection
@push('js')
    <script>
        jQuery(document).ready(function($) {
            var playlistSlider = $('.playlist.slider');
            playlistSlider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                vertical: true,
                verticalSwiping: true,
                autoplay: false,
            });
            $('.playlist.slider + .navigation-arrows .previous-slide').on('click', function() {
                playlistSlider.slick('slickPrev');
            });
            $('.playlist.slider + .navigation-arrows .next-slide').on('click', function() {
                playlistSlider.slick('slickNext');
            });
        });
    </script>
@endpush
