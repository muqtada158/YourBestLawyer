@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Login')

@section('content')
<div id="content">
    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Login</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div style="max-width:600px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <!-- <h4 class="text-center">Welcome to lorem</h4> -->
                <p class="text-center font-28">Enter your email and password to login to your account.</p>
                <form action="{{ route('login') }}" class="mt-2" method="POST">@csrf
                    <div>
                        <input required name="email" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="email" placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <input required name="password" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" onclick="showLoader();" class="btn button-accent btn-accent-primary w-100 mt-4">
                        <span>Sign in</span>
                        <span class="btn-arrow">
                            <i class="fa-solid fa-chevron-right text-black"></i>
                        </span>
                    </button>
                    <!--<div class="social-login mt-5">-->
                    <!--    <a href="#" class="btn button-accent btn-accent-secondary w-100 mt-2">-->
                    <!--        <span><img src="{{asset('images/google-logo.png')}}" class="me-2 me-md-4" alt="Google Logo"> <span class="d-none d-md-inline-block">Continue with</span> Google</span>-->
                    <!--        <span class="btn-arrow">-->
                    <!--            <i class="fa-solid fa-chevron-right text-white"></i>-->
                    <!--        </span>-->
                    <!--    </a>-->
                    <!--    <a href="#" class="btn button-accent btn-accent-secondary w-100 mt-2">-->
                    <!--        <span><img src="{{asset('images/apple-logo.png')}}" class="me-2 me-md-4" alt="Google Logo"> <span class="d-none d-md-inline-block">Continue with</span> Apple</span>-->
                    <!--        <span class="btn-arrow">-->
                    <!--            <i class="fa-solid fa-chevron-right text-white"></i>-->
                    <!--        </span>-->
                    <!--    </a>-->
                    <!--</div>-->
                </form>
                <ul class="list-unstyled mt-4">
                    <li><a class="text-primary" href="{{route('reset_view')}}">I forgot my password</a></li>
                    <li class="text-black mt-1">Email not verified yet? <a class="text-primary" href="{{route('verify_now')}}">Verify email now</a></li>
                    <li class="text-black mt-1">Don’t have an account?<a class="text-primary" href="{{route('auth_index')}}"> Sign Up</a></li>
                </ul>
            </div>
        </div>
    </section>

</div>
@endsection
