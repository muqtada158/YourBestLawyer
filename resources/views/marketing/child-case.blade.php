@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | '.$subCat->title)

@section('content')

    <div id="content">

        <section id="hero-section" class="hero-banner bg-cover bg-repeat-none bg-position-center bg-overlay-black"
            style="background-image:url('{{ asset('images/dui-information-bg.png') }}')">
            <div class="container-xxl padding-section-medium">
                <h1 class="text-center fw-bold text-white">{{$subCat->getCategory->title}}</h1>
            </div>
        </section>

        <section id="videos" class="padding-section-medium">
            <div class="container-xxl">
                <div class="row">
                    <div class="offset-md-3 col-md-9">
                        <h2 class="fw-bold text-primary text-center">{{$subCat->getCategory->title}}</h2>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 order-2 order-md-1 d-flex flex-column" style="max-height: 100%;">
                        <h4 class="fw-bold text-primary text-center animate__animated animate__shakeX mb-4">Other Related {{$subCat->getCategory->title}} Videos</h4>
                        <div class="col-md-12 border-overflow radius-20 p-4">
                            <div class="row ">
                                @if ($subCat->cat_id == 2)
                                    @foreach ($getCourtProcedureVideos as $court)
                                        <div class="col-md-12 mt-2 mb-2 ">
                                            <div class="card radius-20" style="border: 0px;background-color: #201c194d;">
                                                <a href="{{route('marketing_child_cases',[$court->id])}}">
                                                    <div class="card-body text-center">
                                                        <div class="hero-video height-150 bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20"
                                                            style="background-image: url({{ asset('images/front-thumbnail.png') }});">
                                                        </div>
                                                        <p class="text-center font-accent font-10 text-black mt-2">{{$court->title}}</p>
                                                            <span class="btn-sm btn-primary">
                                                            Learn More >
                                                            </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                    @endforeach
                                @endif
                                @foreach ($subCat_all as $sub_case)

                                    <div class="col-md-12 mt-2 mb-2 ">
                                        <div class="card radius-20" style="border: 0px;background-color: #201c194d;">
                                            <a href="{{route('marketing_child_cases',[$sub_case->id])}}">
                                                <div class="card-body text-center">
                                                    <div class="hero-video height-150 bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20"
                                                        style="background-image: url({{ asset('images/front-thumbnail.png') }});">
                                                    </div>
                                                    <p class="text-center font-accent font-10 text-black mt-2">{{$sub_case->title}}</p>
                                                        <span class="btn-sm btn-primary">
                                                        Learn More >
                                                        </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 order-1 order-md-2">
                        <h4 class="fw-bold text-primary text-center animate__animated animate__shakeX mb-4">{{$subCat->title}}</h4>
                        <div class="video-container-16-9 radius-20 overflow-hidden mb-2">
                            <a href="{{$subCat->video_link}}" data-toggle="lightbox" class="single-video-item" title="Play video !">
                                <div class="hero-video image bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20 video-16-9"
                                    style="background-image: url({{ asset('images/front-thumbnail.png') }});border:1px solid black;">
                                    <img src="{{ asset('images/Youtube.png') }}" width="60">
                                </div>
                            </a>
                        </div>
                        <div class="row padding-left padding-right padding-x-m-0">
                        @foreach ($subCat->getLaywers as $lawyer)
                        <div class="col-lg-4">
                            <div class="card packages mb-2 select-package" data_case_id="{{$subCat->getCategory->id}}" data_case_sub_id="{{$subCat->id}}" data_package_id="{{$lawyer->id}}">
                                <div class="card-body">
                                    <div class="row  text-center">
                                        <p class="fw-bold fs-5">{{$lawyer->title}}</p>
                                    </div>
                                    <div class="row text-center">
                                        <small class="mb-0">Range</small>
                                        <svg width="240" height="28" viewBox="0 0 240 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="45.2917" cy="14.1159" r="13.2917" fill="#B38E6A"/>
                                            <circle cx="195.292" cy="14.1159" r="13.2917" fill="#B38E6A"/>
                                            <path d="M189.401 2.57422C135.866 14.3699 106.203 15.0973 54.0364 5.02268L51.5879 23.9108C106.091 13.2442 136.253 13.6627 189.401 23.9108V2.57422Z" fill="#B38E6A"/>
                                            <line x1="42.0938" y1="9.21875" x2="42.0938" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="192.5" y1="9.21875" x2="192.5" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="44.8926" y1="9.21875" x2="44.8926" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="195.299" y1="9.21875" x2="195.299" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="47.6914" y1="9.21875" x2="47.6914" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="198.096" y1="9.21875" x2="198.096" y2="18.313" stroke="white" stroke-width="2"/>
                                            <line x1="32" y1="14.3242" x2="-4.37114e-08" y2="14.3242" stroke="#D8D8D8"/>
                                            <line x1="240" y1="13.3242" x2="208" y2="13.3242" stroke="#D8D8D8"/>
                                            </svg>

                                    </div>
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <small class="fw-bold mb-0">
                                                {{$subCat->getCategory->count_as == '$' ? '$' : ''}}{{ number_format($lawyer->min_amount, 2) }}{{$subCat->getCategory->count_as === '%' ? '%' : ''}}
                                            </small>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="fw-bold mb-0">
                                                {{$subCat->getCategory->count_as == '$' ? '$' : ''}}{{ number_format($lawyer->max_amount, 2) }}{{$subCat->getCategory->count_as === '%' ? '%' : ''}}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="container">
                                            <ul class="list-unstyled text-center">
                                                {!! $lawyer->description !!}
                                            </ul>
                                        </div>
                                    </div>
                                    @if ($subCat->getCategory->id !== 1 AND $subCat->getCategory->id !== 6)
                                        <div class="row mt-2 mb-0">
                                            <div class="offset-md-2 col-md-8 text-center">
                                                <span class="btn-sm btn-primary w-100">
                                                    Bid Now >
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach


                        </div>

                        <div class="description mt-4 p-4">
                            {!!$subCat->description!!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="bg-accent padding-section-medium">
            <div class="container-xxl text-center">
                <h2 class="text-white">Solve Your <span class="text-primary">Legal Matters </span> With Us !</h2>
                <p class="text-white mt-3 mb-0">You can access a range of resources designed to guide you through the legal process, from understanding civil lawsuits to exploring cost-effective legal solutions.</p>
                <a onclick="checkUserAndRedirect()" class="btn btn-primary text-white mt-5">Get Started</a>
            </div>
        </section>



        <section id="videos2" class="padding-section-medium">
            <div class="container-xxl">
                <div class="row">
                    <h2 class="text-primary text-center mb-5 fw-bold">Other Law Categories </h2>
                    @foreach ($cases_all as $case)

                    <div class="col-md-4  mt-2 mb-2 ">
                        <div class="card radius-20" style="border: 0px;background-color: #201c194d;">
                            <a href="{{route('marketing_main_cases',[$case->id])}}">
                                <div class="card-body text-center">
                                    <div class="hero-video height-300 bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20"
                                        style="background-image: url({{ asset('images/front-thumbnail.png') }});">

                                    </div>
                                    <p class="text-center font-accent font-20 text-black mt-2">{{$case->title}}</p>
                                    <span class="btn-sm btn-primary">
                                    Learn More >
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </section>

    </div>

@endsection
@push('js')

<script>
    $(document).ready(function() {
        @if ($subCat->getCategory->id !== 1 AND $subCat->getCategory->id !== 6)
        $('.select-package').click(function() {

            Swal.fire("We're excited to have you here! Our platform is currently in the process of signing up top attorneys to serve your needs. Get ready to place your bids starting December 1st!");

            // $('.select-package').removeClass('set-card-active');
            // // Get the data attributes
            // var caseId = $(this).attr('data_case_id');
            // var caseSubId = $(this).attr('data_case_sub_id');
            // var packageId = $(this).attr('data_package_id');

            // // Store them in cookies
            // Cookies.set('cookie_case_id', caseId, { expires: 1 }); // Expires in 1 days
            // Cookies.set('cookie_case_sub_id', caseSubId, { expires: 1 });
            // Cookies.set('cookie_package_id', packageId, { expires: 1 });

            // $(this).addClass('set-card-active');

            // // Confirmation message (optional)
            // console.log('Data stored in cookies: case_id=' + caseId + ', case_sub_id=' + caseSubId + ', package_id=' + packageId);

            // setTimeout(function() {
            //     checkUserAndRedirect();
            // }, 1000);
        });
        @endif
    });
</script>

@endpush
