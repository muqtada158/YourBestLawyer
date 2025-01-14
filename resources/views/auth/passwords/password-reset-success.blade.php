@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Password Reset Success')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Password Reset</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div style="max-width:600px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <h2 class="text-center font-accent">Thank You</h2>
                <p class="text-center font-10">Your Password has been resetted successfully. <br> You can now login.</p>

                <ul class="list-unstyled mt-4">
                    <li><a class="text-primary" href="{{route('login_view')}}">Login</a></li>
                    <li class="text-black mt-1">Don’t have an account?<a class="text-primary" href="{{route('register_view')}}"> Sign Up</a></li>
                </ul>
            </div>
        </div>
    </section>

</div>

@endsection
