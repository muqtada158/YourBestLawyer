@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Onboarding Success')
@push('css')
    <style>
        header {
            display: none;
        }
        footer {
            display: none;
        }
    </style>
@endpush
@section('content')
    <div id="content">
        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                    <div class="customer-portal-content py-3">
                        <div class="row">
                            <div class="offset-md-2 col-md-8 text-center">
                                <h1 class="font-accent">Stripe Connect Onboarding</h1>
                                <h4 class="font-accent mt-5">Stripe onboarding <span class="text-success">successfull</span>, Please close the screen or press back button...</h4>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
