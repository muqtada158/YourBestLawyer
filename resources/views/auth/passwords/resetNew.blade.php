@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Password Reset')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Reset Your Password</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div style="max-width:600px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <!-- <h4 class="text-center">Welcome to lorem</h4> -->
                <p class="text-center font-28">Enter your email to recieve password reset link.</p>
                <form action="{{ route('password.email') }}" class="mt-2" method="post">@csrf
                    <div>
                        <input required name="email" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="email" placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn button-accent btn-accent-primary w-100 mt-4">
                        <span>Reset Password</span>
                        <span class="btn-arrow">
                            <i class="fa-solid fa-chevron-right text-black"></i>
                        </span>
                    </button>
                </form>
                <ul class="list-unstyled mt-4">
                    <li><a class="text-primary" href="{{route('login_view')}}">Login</a></li>
                    <li class="text-black mt-1">Don’t have an account?<a class="text-primary" href="{{route('register_view')}}"> Sign Up</a></li>
                </ul>
            </div>
        </div>
    </section>

</div>

@endsection
