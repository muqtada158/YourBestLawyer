@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Details')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Attorney Details</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row mt-3">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="row ">
                                                            <div class="col-md-2 text-center">
                                                                <div class="icon-large">
                                                                    <div class="avatar-preview">
                                                                        <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="{{asset($attorney->getUserDetails->image)}}" alt="User profile picture">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 d-flex align-items-center justify-content-left text-center">
                                                                <div class="pt-2">
                                                                    <p class="font-accent">
                                                                        <span class="font-20 fw-bold">{{$attorney->getUserDetails->first_name}} {{$attorney->getUserDetails->last_name}}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="row text-end">
                                                                    <div class="col-md-12">
                                                                        @if ($interstedAttornies->getCaseDetails->getCasePackage->sub_cat_id == 18 || $interstedAttornies->getCaseDetails->getCasePackage->sub_cat_id == 19 || $interstedAttornies->getCaseDetails->getCasePackage->sub_cat_id == 20)
                                                                        <h4 class="fw-bold font-accent">{{$interstedAttornies->attorney_bid}}%</h4>
                                                                        @else
                                                                        <h4 class="fw-bold font-accent"> $ {{$interstedAttornies->attorney_bid}}</h4>
                                                                        @endif
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
                                                                        @if (isset($attorneyReviews->google_review) AND $attorneyReviews->google_review !== null)
                                                                        <div>
                                                                            <span class="font-14 fw-bold">Google :</span>
                                                                            <div class="rating-box-for-other">
                                                                                <div class="rating-container">
                                                                                    <input disabled type="radio" name="grating" value="5" id="gstar-5" {{round($attorneyReviews->google_review) == 5 ? 'checked' : ''}}> <label for="gstar-5">&#9733;</label>

                                                                                    <input disabled type="radio" name="grating" value="4" id="gstar-4" {{round($attorneyReviews->google_review) == 4 ? 'checked' : ''}}> <label for="gstar-4">&#9733;</label>

                                                                                    <input disabled type="radio" name="grating" value="3" id="gstar-3" {{round($attorneyReviews->google_review) == 3 ? 'checked' : ''}}> <label for="gstar-3">&#9733;</label>

                                                                                    <input disabled type="radio" name="grating" value="2" id="gstar-2" {{round($attorneyReviews->google_review) == 2 ? 'checked' : ''}}> <label for="gstar-2">&#9733;</label>

                                                                                    <input disabled type="radio" name="grating" value="1" id="gstar-1" {{round($attorneyReviews->google_review) == 1 ? 'checked' : ''}}> <label for="gstar-1">&#9733;</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if (isset($attorneyReviews->yelp_review) AND $attorneyReviews->yelp_review !== null)
                                                                    <div>
                                                                        <span class="font-14 fw-bold">Yelp :</span>
                                                                        <div class="rating-box-for-other">
                                                                            <div class="rating-container">
                                                                                <input disabled type="radio" name="yrating" value="5" id="ystar-5" {{round($attorneyReviews->yelp_review) == 5 ? 'checked' : ''}}> <label for="ystar-5">&#9733;</label>

                                                                                <input disabled type="radio" name="yrating" value="4" id="ystar-4" {{round($attorneyReviews->yelp_review) == 4 ? 'checked' : ''}}> <label for="ystar-4">&#9733;</label>

                                                                                <input disabled type="radio" name="yrating" value="3" id="ystar-3" {{round($attorneyReviews->yelp_review) == 3 ? 'checked' : ''}}> <label for="ystar-3">&#9733;</label>

                                                                                <input disabled type="radio" name="yrating" value="2" id="ystar-2" {{round($attorneyReviews->yelp_review) == 2 ? 'checked' : ''}}> <label for="ystar-2">&#9733;</label>

                                                                                <input disabled type="radio" name="yrating" value="1" id="ystar-1" {{round($attorneyReviews->yelp_review) == 1 ? 'checked' : ''}}> <label for="ystar-1">&#9733;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if (isset($attorneyReviews->avvo_review) AND $attorneyReviews->avvo_review !== null)
                                                                    <div>
                                                                        <span class="font-14 fw-bold">Avvo :</span>
                                                                        <div class="rating-box-for-other">
                                                                            <div class="rating-container">
                                                                                <input disabled type="radio" name="tprating" value="5" id="tpstar-5" {{round($attorneyReviews->avvo_review) == 5 ? 'checked' : ''}}> <label for="tpstar-5">&#9733;</label>

                                                                                <input disabled type="radio" name="tprating" value="4" id="tpstar-4" {{round($attorneyReviews->avvo_review) == 4 ? 'checked' : ''}}> <label for="tpstar-4">&#9733;</label>

                                                                                <input disabled type="radio" name="tprating" value="3" id="tpstar-3" {{round($attorneyReviews->avvo_review) == 3 ? 'checked' : ''}}> <label for="tpstar-3">&#9733;</label>

                                                                                <input disabled type="radio" name="tprating" value="2" id="tpstar-2" {{round($attorneyReviews->avvo_review) == 2 ? 'checked' : ''}}> <label for="tpstar-2">&#9733;</label>

                                                                                <input disabled type="radio" name="tprating" value="1" id="tpstar-1" {{round($attorneyReviews->avvo_review) == 1 ? 'checked' : ''}}> <label for="tpstar-1">&#9733;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent">Attorney Bio</h4>
                                                            <p class="font-accent mt-3">
                                                                {{$attorney->getUserDetails->bio}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h3 class="fw-bold font-30 mb-0 col-lg-6 font-accent mb-4">Additional Information</h3>
                                                            <br>
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <p class="fs-5">
                                                                        {{ ucfirst($attorney->getUserDetails->first_name) }}
                                                                        {{ ucfirst($attorney->getUserDetails->last_name) }}</p>
                                                                    <small class="small-text">Name</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{ $attorney->email }}</p>
                                                                    <small class="small-text">Email</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{ $attorney->user_name }}</p>
                                                                    <small class="small-text">Username</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{ $attorney->getUserDetails->phone }}</p>
                                                                    <small class="small-text">Phone Number</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{ $attorney->getUserDetails->address }}</p>
                                                                    <small class="small-text">Address</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row mt-4">
                            {{-- <div class="col-md-4">
                                <a href="{{route('customer_messages')}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Reject</a>
                            </div> --}}
                            <div class="offset-md-4 col-md-4">
                                <a href="{{route('customer_contracts',[$interstedAttornies->id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> Approve</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
