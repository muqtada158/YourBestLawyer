@extends('layouts.app')

@section('page_title', 'Your Best Lawyer')

@section('content')

<div id="content">
    <section id="home-banner" style="background-image: url({{asset('images/hero-banner-home.png')}});" class="position-relative bg-cover bg-repeat-none">
        <div class="hero-section bg-cover bg-position-center bg-repeat-none bg-overlay-black padding-right padding-left hero-banner-home">
            <div class="container-xxl">
                <div class="row zindex9">
                    <div class="col-md-12 col-12 text-center">
                        <h1 class="text-white font-80 text-break">YourBest<span class="text-primary">Lawyer</span><span class="font-48">.com</span></h1>
                        <p class="font-40 text-white pb-5">Empowering you through legal clarity</p>
                    </div>
                    <div class="col-md-12 text-center pt-4">
                        <h1 class="text-white text-break" style="font-size:115px">Coming Soon...</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection