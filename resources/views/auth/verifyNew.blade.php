@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Verify')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Verify Your Email</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div style="max-width:600px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <div class="row">
                    <div class="offset-md-9 col-md-3 col-sm-4">
                        <img src="{{asset('images/Email.png')}}" class="w-100" alt="">
                    </div>
                </div>
                <p class="text-center">We have sent OTP to <strong>{{request('email')}}</strong> please type code in here.</p>
                <form action="{{route('verifyEmail')}}" class="mt-1" method="post">@csrf
                    <input type="hidden" name="email" value="{{ request('email') }}">
                    <div class="d-flex mb-3 gap-3">
                        <input type="tel" maxlength="1" pattern="[0-9]" class="form-control py-3 text-center" name="verification_code[]">
                        <input type="tel" maxlength="1" pattern="[0-9]" class="form-control py-3 text-center" name="verification_code[]">
                        <input type="tel" maxlength="1" pattern="[0-9]" class="form-control py-3 text-center" name="verification_code[]">
                        <input type="tel" maxlength="1" pattern="[0-9]" class="form-control py-3 text-center" name="verification_code[]">
                    </div>
                    @error('verification_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                <ul class="list-unstyled mt-4">
                    <li>
                        <button type="button"  onclick="showLoader();"  data-email="{{ request('email') }}" class="btn-secondary w-100 d-block text-center p-1 mb-2 pt-3 pb-3" id="resendButton" onclick="resendCode(this)" disabled>
                            Resend Code <span id="timer">(2:00)</span>
                        </button>
                    </li>
                    <li><button  onclick="showLoader();"  class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3" type="submit">Confirm</button></li>
                </ul>

                </form>
            </div>
        </div>
    </section>

</div>

@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                if (this.value.length >= 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
        });
    });
</script>
<script>
    let timeLeft = 120; // 2 minutes in seconds
    let timerInterval;

    function startTimer() {
        timerInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft < 0) {
                clearInterval(timerInterval);
                document.getElementById("resendButton").disabled = false;
                document.getElementById("timer").innerText = "";
            } else {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById("timer").innerText = `(${minutes}:${seconds.toString().padStart(2, "0")})`;
            }
        }, 1000); // Update the timer every second
    }

    function resendCode(button) {
    var email = button.getAttribute("data-email");
    var data = {'email': email, '_token': '{{ csrf_token() }}'};
    var url = '{{ route('resendCode') }}';

    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (res.status == 1) {
                Toast.fire({
                    icon: 'success',
                    title: 'New verification code has been sent.'
                });
                                // Reset the timer
                    clearInterval(timerInterval);
                    timeLeft = 120;
                    document.getElementById("timer").innerText = "(2:00)";
                    document.getElementById("resendButton").disabled = true;
                    startTimer();
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
            Toast.fire({
                    icon: 'error',
                    title: 'An error occurred while resending the verification code.'
                });
        }
    });


}


    // Start the timer when the page loads
    startTimer();
    </script>
@endpush
