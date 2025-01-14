{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

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
                <p class="text-center font-28">Enter your new password</p>
                <form method="POST" action="{{ route('password.update') }}" class="mt-2">@csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mt-2">
                        <input required name="email" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="email" placeholder="Email Address" value="{{ $email ?? old('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <input required name="password" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <input required name="password_confirmation" class="form-control-lg height-60 w-100 radius-20 border-0 form-input form-input-medium" type="password" placeholder="Confirm Password">
                        @error('password_confirmation')
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
