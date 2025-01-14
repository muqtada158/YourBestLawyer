@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Verification')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section font-accent">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Verified</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div style="max-width:600px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <!-- <h4 class="text-center">Welcome to lorem</h4> -->
                <div class="container">
                    <div class="row text-center py-4">
                        <div class="col-md-12">
                            <i class="fa-solid fa-circle-check icon-verify" style="color: #b38e61;"></i>
                        </div>
                    </div>
                </div>
                <h5 class="text-center"> <strong>Verified</strong>  </ph5>
                <p class="mt-4 py-3">
                    <p>Enter your email and password to login to your account.</p>
                </p>
                <ul class="list-unstyled mt-4">
                    <li><a href="{{route('login_view')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3">Confirm</a></li>
                </ul>
            </div>
        </div>
    </section>

</div>

@endsection
