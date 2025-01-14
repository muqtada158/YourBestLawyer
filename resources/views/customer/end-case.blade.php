@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Customer Review End Case')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-customer')

                    </div>
                    <div class="customer-portal-content py-3">
                        <div class="row">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Customer Review</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="card border-0 radius-10 pt-4 pb-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md-2 text-start">
                                                <div class="icon-large">
                                                    <div class="customer-avatar">
                                                        <img class="w-100"
                                                            src="{{ isset($contract->getAttornies->getUserDetails->image) ? asset($contract->getAttornies->getUserDetails->image) : asset('images/user-dummy.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 xy-center justify-content-md-start">
                                                <p class="font-accent">
                                                    <span class="font-20 fw-bold">
                                                        {{ isset($contract->getAttornies->getUserDetails->first_name) ? ucfirst($contract->getAttornies->getUserDetails->first_name) : $contract->getAttornies->user_name }}
                                                        {{ isset($contract->getAttornies->getUserDetails->last_name) ? ucfirst($contract->getAttornies->getUserDetails->last_name) : '' }}
                                                    </span>
                                                    <br>
                                                    <span class="font-14 fw-bold">Bio :
                                                    </span><span>{{ isset($contract->getAttornies) ? $contract->getAttornies->getUserDetails->bio : '' }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <h5 class="fw-bold font-accent">Ratings : {{$averageRating}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row text-end">
                                                    <div class="col-md-12">
                                                        <div class="rating-box">
                                                            <div class="rating-container">
                                                                <input disabled type="radio" name="rating-attorney" value="5"
                                                                    id="1star-5" {{attorneyRatings($contract->getAttornies->id) == 5 ? 'checked' : ''}}> <label for="1star-5" title="Ratings : {{attorneyRatings($contract->getAttornies->id)}}">&#9733;</label>

                                                                <input disabled type="radio" name="rating-attorney" value="4"
                                                                    id="1star-4" {{attorneyRatings($contract->getAttornies->id) == 4 ? 'checked' : ''}}> <label for="1star-4" title="Ratings : {{attorneyRatings($contract->getAttornies->id)}}">&#9733;</label>

                                                                <input disabled type="radio" name="rating-attorney" value="3"
                                                                    id="1star-3" {{attorneyRatings($contract->getAttornies->id) == 3 ? 'checked' : ''}}> <label for="1star-3" title="Ratings : {{attorneyRatings($contract->getAttornies->id)}}">&#9733;</label>

                                                                <input disabled type="radio" name="rating-attorney" value="2"
                                                                    id="1star-2" {{attorneyRatings($contract->getAttornies->id) == 2 ? 'checked' : ''}}> <label for="1star-2" title="Ratings : {{attorneyRatings($contract->getAttornies->id)}}">&#9733;</label>

                                                                <input disabled type="radio" name="rating-attorney" value="1"
                                                                    id="1star-1" {{attorneyRatings($contract->getAttornies->id) == 1 ? 'checked' : ''}}> <label for="1star-1" title="Ratings : {{attorneyRatings($contract->getAttornies->id)}}">&#9733;</label>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card border-0 radius-10 pt-4 pb-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Your Review</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if ($check_review)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="font-18 mt-4" >Ratings :</label><br>
                                                            <div class="rating-box">
                                                                <div class="rating-container">
                                                                    <input type="radio" name="rating_check" value="5"
                                                                        id="2star-5" {{$check_review->rating == 5 ? 'checked' : ''}} > <label for="2star-5">&#9733;</label>

                                                                    <input type="radio" name="rating_check" value="4"
                                                                        id="2star-4" {{$check_review->rating == 4 ? 'checked' : ''}}> <label for="2star-4">&#9733;</label>

                                                                    <input type="radio" name="rating_check" value="3"
                                                                        id="2star-3" {{$check_review->rating == 3 ? 'checked' : ''}}> <label for="2star-3">&#9733;</label>

                                                                    <input type="radio" name="rating_check" value="2"
                                                                        id="2star-2" {{$check_review->rating == 2 ? 'checked' : ''}}> <label for="2star-2">&#9733;</label>

                                                                    <input type="radio" name="rating_check" value="1"
                                                                        id="2star-1" {{$check_review->rating == 1 ? 'checked' : ''}}> <label for="2star-1">&#9733;</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <label class="font-18 mb-2" for="first_name">Review :</label>
                                                            <p>{!! $check_review->review !!}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                <form action="{{route('customer_customerReview')}}" method="POST" enctype="multipart/form-data">@csrf
                                                    <input type="hidden" name="case_id" value="{{$contract->getCaseDetail->id}}">
                                                    <input type="hidden" name="attorney_id" value="{{$contract->getAttornies->id}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="font-18 mt-4" >Select ratings</label><br>
                                                            <div class="rating-box">
                                                                <div class="rating-container">
                                                                    <input type="radio" name="rating" value="5"
                                                                        id="star-5" {{old('rating') == 5 ? 'checked' : ''}} > <label for="star-5">&#9733;</label>

                                                                    <input type="radio" name="rating" value="4"
                                                                        id="star-4" {{old('rating') == 4 ? 'checked' : ''}}> <label for="star-4">&#9733;</label>

                                                                    <input type="radio" name="rating" value="3"
                                                                        id="star-3" {{old('rating') == 3 ? 'checked' : ''}}> <label for="star-3">&#9733;</label>

                                                                    <input type="radio" name="rating" value="2"
                                                                        id="star-2" {{old('rating') == 2 ? 'checked' : ''}}> <label for="star-2">&#9733;</label>

                                                                    <input type="radio" name="rating" value="1"
                                                                        id="star-1" {{old('rating') == 1 ? 'checked' : ''}}> <label for="star-1">&#9733;</label>
                                                                </div>
                                                            </div>

                                                            @error('rating')
                                                            <br>
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <label class="font-18 mb-2" for="first_name">Review</label>
                                                            <textarea name="review" placeholder="Write your review"
                                                                class="form-control-lg w-100 radius-20 input-border form-input form-input-medium"
                                                                type="text" style="height: 150px">{{old('review')}}</textarea>
                                                            @error('review')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="offset-md-4 col-md-4">
                                                                <button type="submit" class="btn-primary w-100 d-block text-center p-1 py-3 mb-2 radius-10" onclick="showLoader();">Submit Review</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                @endif
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
