@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | '.$cases->title)

@section('content')

    <div id="content">

        <section id="hero-section" class="hero-banner bg-cover bg-repeat-none bg-position-center bg-overlay-black"
            style="background-image:url('{{ asset('images/dui-information-bg.png') }}')">
            <div class="container-xxl padding-section-medium">
                <h1 class="text-center fw-bold text-white">{{$cases->title}}</h1>
                <div class="text-center text-white fs-5">
                    {!! $cases->description !!}
                </div>
            </div>
        </section>

        <section id="videos" class="padding-section-medium pt-5">
            <div class="container-xxl">
                <div class="row">
                    <h2 class="text-primary text-center mb-5 fw-bold">{{$cases->title}}</h2>
                    @foreach ($cases->subCategories as $subCat)
                        <div class="col-md-4  mt-2 mb-2 ">

                                <div class="card radius-20" style="border: 0px;background-color: #201c194d;">

                                    <div class="card-body text-center">
                                        <a href="{{route('marketing_child_cases',[$subCat->id])}}">
                                        {{-- <a href="{{asset($subCat->video_link)}}" title="Play Video" data-toggle="lightbox" class="single-video-item"> --}}
                                            <div class="hero-video height-300 bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20"
                                                style="background-image: url({{ asset('images/front-thumbnail.png') }});">
                                                    {{-- <img src="{{ asset('images/Youtube.png') }}" width="60"> --}}
                                            </div>
                                        {{-- </a> --}}

                                            <p class="text-center font-accent font-20 text-black mt-3">{{$subCat->title}}</p>
                                            <span class="btn-sm btn-primary">
                                            Read More >
                                            </span>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-5 pt-5">
                    <h2 class="text-primary text-center mb-5 fw-bold">Other Law Categories </h2>
                    @foreach ($cases_all as $case)

                    <div class="col-md-4  mt-2 mb-2 ">
                        <div class="card radius-20" style="border: 0px;background-color: #201c194d;">
                            <a href="{{route('marketing_main_cases',[$case->id])}}" >
                                <div class="card-body text-center">
                                    <div class="hero-video height-300 bg-cover bg-position-center d-flex align-items-center justify-content-center radius-20"
                                        style="background-image: url({{ asset('images/front-thumbnail.png') }});">

                                    </div>
                                    <p class="text-center font-accent font-20 text-black mt-2">{{$case->title}}</p>
                                    <span class="btn-sm btn-primary">
                                    Read More >
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
