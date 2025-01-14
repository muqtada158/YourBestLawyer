@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Universal Client-Attorney Agreements')

@section('content')

<div id="content">

    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <h1 class="text-center font-accent mb-4">Universal Client-Attorney Agreements</h1>
                    <hr>
                    @foreach ($case_contracts as $contract)
                        <div class="row mt-2">
                            <div class="col-md-12 customer-portal-content-terms-and-condition">
                                <h2 class="font-accent text-center">{{$contract->getCaseLaw->title}}</h3>
                                <h4 class="font-accent text-center">({{$contract->type}})</h4>
                                {!! $contract->header !!}
                                {!! $contract->contract !!}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
