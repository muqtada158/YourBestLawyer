@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Terms And Conditions')

@section('content')

<div id="content">

    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="py-3 customer-portal-content-terms-and-condition">
                    <h1 class="text-center font-accent">Terms And Conditions</h1>
                    {!! $terms->terms_and_conditions !!}
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
