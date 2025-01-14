@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Redirection')

@section('content')
<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <div class="offset-md-2 col-md-8 text-center">
                            <h1 class="font-accent">Stripe Connect Onboarding</h1>
                            <h4 class="font-accent mt-5">Please wait while we validate your onboarding process.</h4>
                            @if ($alert['alert-type'] === "error")
                                <h4 class="font-accent mt-5 text-danger">{{$alert['message']}}</h4>
                            @else
                                <h4 class="font-accent mt-5 text-success">{{$alert['message']}}</h4>
                            @endif
                            <h4 class="font-accent">You will be redirected automatically. <span id="timer">10</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    @endsection
@push('js')
<script>
    let timerElement = document.getElementById('timer');
    let timeLeft = 10;

    let countdown = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            window.location.href = '{{$redirectionRoute}}'; // Replace with your target URL
        }
    }, 1000);
</script>
@endpush
