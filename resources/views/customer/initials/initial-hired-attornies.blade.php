@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Attorney Bids</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">

                                    <div class="card-body">
                                        <div class="container">
                                            @forelse ($interstedAttornies as $attorney)
                                            <div class="row mt-3">
                                                <div class="card card-border-bottom">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row ">
                                                                <div class="col-md-2 text-center">
                                                                    <div class="avatar-preview">
                                                                        <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="{{asset($attorney->getAttornies->getUserDetails->image)}}" alt="User profile picture">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7 border-box-left">
                                                                    <div>
                                                                        <p class="font-accent mb-0">
                                                                            <span class="font-20 fw-bold">{{$attorney->getAttornies->getUserDetails->first_name}} {{$attorney->getAttornies->getUserDetails->last_name}}</span>
                                                                        </p>
                                                                            <div class="rating-box">
                                                                                <div class="rating-container">
                                                                                    <input disabled type="radio" name="rating" value="5" id="star-5" {{ $attorney->average_ratings == 5 ? 'checked' : '' }}>
                                                                                    <label for="star-5">&#9733;</label>

                                                                                    <input disabled type="radio" name="rating" value="4" id="star-4" {{ $attorney->average_ratings == 4 ? 'checked' : '' }}>
                                                                                    <label for="star-4">&#9733;</label>

                                                                                    <input disabled type="radio" name="rating" value="3" id="star-3" {{ $attorney->average_ratings == 3 ? 'checked' : '' }}>
                                                                                    <label for="star-3">&#9733;</label>

                                                                                    <input disabled type="radio" name="rating" value="2" id="star-2" {{ $attorney->average_ratings == 2 ? 'checked' : '' }}>
                                                                                    <label for="star-2">&#9733;</label>

                                                                                    <input disabled type="radio" name="rating" value="1" id="star-1" {{ $attorney->average_ratings == 1 ? 'checked' : '' }}>
                                                                                    <label for="star-1">&#9733;</label>
                                                                                </div>

                                                                            </div>
                                                                        <p class="font-accent">
                                                                            <span class="font-14" >{{truncate_text($attorney->getAttornies->getUserDetails->bio)}}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 text-center">
                                                                    <div class="row xy-center mt-2 mb-2">
                                                                        <div class="col-md-12 d-flex align-items-center justify-content-center text-center">
                                                                            @if ($attorney->getCaseDetails->getCasePackage->sub_cat_id == 18 || $attorney->getCaseDetails->getCasePackage->sub_cat_id == 19 || $attorney->getCaseDetails->getCasePackage->sub_cat_id == 20)
                                                                                <p class="fw-bold font-20">{{$attorney->attorney_bid}}%</p>
                                                                            @else
                                                                                <p class="fw-bold font-20"> $ {{$attorney->attorney_bid}}</p>
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                    <div class="row xy-center">
                                                                        <div class="col-md-12">
                                                                            <a href="{{route('customer_hired_attornies_details',[$attorney->id])}}" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> View</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="row mt-3">
                                                <div class="card card-border-bottom">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row text-center">
                                                                <p>No bids found.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforelse


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
