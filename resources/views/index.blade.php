@extends('layouts.app')

@section('page_title', 'Your Best Lawyer')

@section('content')

    <div id="content">
        <section id="home-banner" style="background-image: url({{ asset('images/hero-banner-home.png') }});"
            class="position-relative bg-cover bg-repeat-none">
            <div
                class="hero-section bg-cover bg-position-center bg-repeat-none bg-overlay-black padding-right padding-left hero-banner-home">
                <div class="container-xxl">
                    <div class="row zindex9">
                        <div class="col-md-7 col-12 d-flex flex-column justify-content-center">
                            <h1 class="text-white font-48 text-break">Welcome To YourBest<span class="text-primary">Lawyer</span><span
                                    class="font-48">.com</span></h1>
                            <p class="font-30 text-white pb-3">Empowering You with legal clarity!</p>
                            <p class="fs-5 text-white">At <span class="text-primary">YourBestLawyer.com</span>, we simplify your legal journey! <br> Dive into our platform and gain the knowledge you need to confidently navigate your legal issues, all with the tap of a finger. <br>Make informed decisions and manage your legal needs effortlessly right from your phone or computer.</p>
                            <form action="" class="mt-0 mt-md-5 pt-0 pt-md-5">
                                <p class="font-20 text-white">Search your legal matters here :</p>
                                <div class="d-flex flex-md-nowrap flex-wrap gap-3">
                                    <input type="text" id="search" name="search"
                                        class="w-100 bg-white border-0 px-4 py-3 dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false" placeholder="Search your legal matters here">
                                    <div class="search-dropdown-index dropdown-menu position-absolute" style="left: 0;">
                                        <div class="row mt-2">
                                            <ul class="list-style-none" id="search-results">
                                                <li class="search-list">
                                                    <a href="javascript:void()">
                                                        <div class="row xy-center">
                                                            <div class="col-md-12">
                                                                <p class="text-black fw-bold mb-0 mt-1"> Enter your search
                                                                    keyword i.e: Slip and fall accidents</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-primary" id="searchB">Search</button> --}}
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="bg-black">
                                <a href="{{ asset('videos/home_page_video.mp4') }}" data-toggle="lightbox">
                                    <div class="hero-video height-full bg-cover bg-position-center d-flex align-items-center justify-content-center font-96"
                                        style="border-radius:10px; background-image: url({{ asset('images/front-thumbnail.png') }});">
                                        <img src="{{ asset('images/Youtube.png') }}"
                                            class="animate__animated animate__shakeX" alt="" srcset="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features-boxes-section" style="background-image: url('{{ asset('images/featured-box-bg.png') }}');">
            <div class="container-xxl padding-section-medium">
                {{-- <div class="features-boxes">
                    <div class="single-box">
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
                    <div class="single-box">
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
                    <div class="single-box">
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
                    <div class="single-box">
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
                    <div class="single-box">
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
                </div> --}}
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

        <section id="overview" class="bg-accent bg-repeat-none bg-position-center bg-cover"
            style="background-image: url('{{ asset('images/bg-design.png') }}');">
            <div class="container-xxl padding-section-medium">
                <div class="row">
                    <h2 class="font-48 text-center pb-4 text-white">How <span class="text-primary">YourBestLawyer.com</span> Works for You</h2>
                    <div class="offset-md-1 col-md-2">
                        <div class="card-ybl text-center">
                            <h3 class="mt-2 mb-4 text-primary fs-4">Discover Your Legal Issue</h3>
                            <p>Easily search any legal problem from “Second Offense DUI” to “Divorce with Children.” Our clear, detailed videos break it all down so you know exactly what’s happening.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-ybl text-center">
                            <h3 class="mt-2 mb-4 text-primary fs-4">Get <br>Empowered</h3>
                            <p>Arm yourself with crucial legal knowledge to ask the right questions and confidently tackle your case. You're in control, and we’ve got your back.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-ybl text-center">
                            <h3 class="mt-2 mb-4 text-primary fs-4">Custom Attorney Match</h3>
                            <p>Ready to hire? Customize your bid based on your budget and choose from top attorneys based on their experience and expertise. Flat fee? Payment plan? You decide.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-ybl text-center">
                            <h3 class="mt-2 mb-4 text-primary fs-4">Instant Connection</h3>
                            <p>Hit “Submit,” and your inquiry goes straight to attorneys who are eager to work with you. Get responses in minutes all within your budget.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-ybl text-center">
                            <h3 class="mt-2 mb-4 text-primary fs-4">Pick Your Attorney</h3>
                            <p>Review your tailored list of attorneys and make your choice with confidence. Handle everything quickly and smoothly from your phone or computer.</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="row mt-4 pt-4">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="counter-box d-flex flex-column align-items-center">
                            <img src="{{ asset('images/Successful Cases.png') }}" class="d-block"
                                alt="Successful Cases">
                            <div class="text-box">
                                <h3 class="text-primary font-48 text-center mt-2 mb-0">2400 +</h3>
                                <p class="text-white font-28 mb-0">Successful Cases</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="counter-box d-flex flex-column align-items-center">
                            <img src="{{ asset('images/Total Attornies.png') }}" class="d-block" alt="Total Attornies">
                            <div class="text-box">
                                <h3 class="text-primary font-48 text-center mt-2 mb-0">30 +</h3>
                                <p class="text-white font-28 mb-0">Total Attornies</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="counter-box d-flex flex-column align-items-center">
                            <img src="{{ asset('images/Firms part of Program.png') }}" class="d-block"
                                alt="Firms part of Program">
                            <div class="text-box">
                                <h3 class="text-primary font-48 text-center mt-2 mb-0">120k +</h3>
                                <p class="text-white font-28 mb-0">Firms part of Program</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="counter-box d-flex flex-column align-items-center">
                            <img src="{{ asset('images/Satisfied Clients.png') }}" class="d-block"
                                alt="Satisfied Clients">
                            <div class="text-box">
                                <h3 class="text-primary font-48 text-center mt-2 mb-0">2400 +</h3>
                                <p class="text-white font-28 mb-0">Successful Cases</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
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

        <section id="cta" class="bg-accent padding-section-medium">
            <div class="container-sm text-center">
                <h2 class="text-white"><span class="text-primary">YourBestLawyer.com</span>  is a game-changer! </h2>
                <p class="text-white fs-5 mt-3 mb-0">It’s not just a platform it’s a whole new way to tackle your legal issues. With in-depth knowledge at your fingertips and the power to choose the perfect attorney within your budget, you call the shots. Say goodbye to endless law firm visits and confusing legal jargon you’re in the driver’s seat now!</p>
                <a onclick="checkUserAndRedirect();" class="btn btn-primary text-white mt-5">Get Started</a>
            </div>
        </section>

        <section id="reviews-section"
            style="background-image: url({{ asset('images/testimonial-bg.png') }}); background-repeat: no-repeat; background-position: center right; background-size: contain;">
            <div class="padding-section-medium">
                <div class="container-sm">
                    <div class="container-xxl position-relative card-us">
                        <div class="">
                            <h2 class="text-primary font-40 text-center">Why Choose Us?</h2>
                            <p class="m-0 fs-5 mt-4 text-center">
                                <strong>Easy-to-Use Platform </strong><br>Navigate your legal concerns with confidence. <br>
                                <strong>Empowering Knowledge </strong><br>Our detailed resources help you understand your legal issue. <br>
                                <strong>Tailored Solutions </strong><br>Choose an attorney based on your needs and budget. <br>
                                <strong>Convenience at Your Fingertips </strong><br>Resolve your legal matters from the comfort of your home or on the go.
                            </p>
                            <p class="text-center mt-4">Thank you for choosing <span class="text-primary">YourBestLawyer.com</span>. We’re here to make your legal journey smoother, faster, and more empowering than ever before!</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="container-lg padding-section-medium text-center">
                <h3 class="text-primary font-28">Testimonials</h3>
                <h2 class="font-48">What Our <span class="text-primary">Clients</span> Say</h2>
                <div class="testimonial-images-swiper swiper mt-5">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-center">
                            <img src="{{ asset('images/testimonials/t1.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center">
                            <img src="{{ asset('images/testimonials/t2.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center">
                            <img src="{{ asset('images/testimonials/t3.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center">
                            <img src="{{ asset('images/testimonials/t4.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center ">
                            <img src="{{ asset('images/testimonials/t5.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center ">
                            <img src="{{ asset('images/testimonials/t6.png') }}" alt="">
                        </div>
                        <div class="swiper-slide text-center ">
                            <img src="{{ asset('images/testimonials/t7.png') }}" alt="">
                        </div>
                    </div>
                    <div class="swiper-button-prev text-black"></div>
                    <div class="swiper-button-next text-black"></div>
                </div>

                @include('testimonials')
            </div> --}}
        </section>

        {{-- <section id="featured-logos-section">
            <div class="container-xxl padding-section-medium">
                <div class="featured-logos">
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo1.png') }}">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo2.png') }}">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo3.png') }}">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo4.png') }}">
                    </div>
                    <div class="featured-logo d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/featured-logo5.png') }}">
                    </div>
                </div>
            </div>
        </section> --}}
    </div>

@endsection
@push('js')
    <script>
        window.addEventListener('load', function () {
            const inputField = document.getElementById('search');
            const dropdown = document.querySelector('.search-dropdown-index');

            // Set the initial width of the dropdown to match the input field
            dropdown.style.width = `${inputField.offsetWidth}px`;

            // Update the width of the dropdown when the window is resized
            window.addEventListener('resize', function () {
                dropdown.style.width = `${inputField.offsetWidth}px`;
            });
        });
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var search = $(this).val();
                if (search.length > 0) {
                    $.ajax({
                        url: "{{ route('homepage_search') }}",
                        type: "POST",
                        data: {
                            search: search,
                            '_token': '{{ csrf_token() }}'
                        },
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
                    // Show the default message when the search is empty
                    $('#search-results').html($('#default-message').prop('outerHTML'));
                    $('.search-dropdown').addClass('show');
                }
            });

            // Close the dropdown when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search').length && !$(event.target).closest(
                        '.search-dropdown').length) {
                    $('.search-dropdown').removeClass('show');
                }
            });
        });
    </script>
@endpush
