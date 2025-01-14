@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | FAQs')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-attorney')
                </div>
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">FAQ's</h2>
                        <div class="mt-3 col-12 d-flex flex-column gap-4 ">
                            <div class="accordion" id="accordionExample">
                                @foreach ($faqs as $key => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{$key}}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="{{$key == 0 ? 'true' : 'false'}}" aria-controls="collapse{{$key}}">
                                                {{$faq->faq_title}}
                                            </button>
                                        </h2>
                                        <div id="collapse{{$key}}" class="accordion-collapse collapse  {{$key == 0 ? 'show' : ''}}" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{$faq->faq_content}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
