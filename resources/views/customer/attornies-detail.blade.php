@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Details')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-customer')
                </div>
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
                                                            <div class="col-md-2 text-start">
                                                                <div class="icon-large">
                                                                    <div class="customer-avatar">
                                                                        <img class="w-100" src="{{isset($hiredAttorneyDetails->getAttornies->getUserDetails->image) ? asset($hiredAttorneyDetails->getAttornies->getUserDetails->image) : asset('images/user-dummy.jpg')}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="pt-2">
                                                                    <p class="font-accent">
                                                                        <span class="font-24 fw-bold">
                                                                            {{ isset($hiredAttorneyDetails->getAttornies->getUserDetails->first_name) ? ucfirst($hiredAttorneyDetails->getAttornies->getUserDetails->first_name) : $application->getUser->user_name }}
                                                                            {{ isset($hiredAttorneyDetails->getAttornies->getUserDetails->last_name) ? ucfirst($hiredAttorneyDetails->getAttornies->getUserDetails->last_name) : '' }}
                                                                        </span>
                                                                        <br>
                                                                        <span class="font-14 fw-bold">SR # {{isset($hiredAttorneyDetails->getCaseDetail) ? $hiredAttorneyDetails->getCaseDetail->sr_no : 0}}</span>
                                                                        <br>
                                                                        <span class="font-14 fw-bold">Case : {{isset($hiredAttorneyDetails->getCaseDetail->getCaseLaw) ? $hiredAttorneyDetails->getCaseDetail->getCaseLaw->title : 0}}</span>
                                                                        <br>
                                                                        <span class="font-14 fw-bold">On Going Cases : {{isset($caseCounts['ongoing_cases']) ? $caseCounts['ongoing_cases'] : 0}}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="row text-end">
                                                                    <div class="col-md-12">
                                                                        <h4 class="fw-bold font-accent"> $ {{$hiredAttorneyDetails->caseAttorneyBid->attorney_bid}}</h4>
                                                                        <div class="rating-box">
                                                                            <div class="rating-container">
                                                                                <input disabled type="radio" name="rating" value="5" id="star-5" {{$average_rating == 5 ? 'checked' : ''}}> <label for="star-5">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="4" id="star-4" {{$average_rating == 4 ? 'checked' : ''}}> <label for="star-4">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="3" id="star-3" {{$average_rating == 3 ? 'checked' : ''}}> <label for="star-3">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="2" id="star-2" {{$average_rating == 2 ? 'checked' : ''}}> <label for="star-2">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="1" id="star-1" {{$average_rating == 1 ? 'checked' : ''}}> <label for="star-1">&#9733;</label>
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
                                                                {{ isset($hiredAttorneyDetails->getAttornies->getUserDetails->bio) ? ucfirst($hiredAttorneyDetails->getAttornies->getUserDetails->bio) : '' }}
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
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent">Attorney Information</h4>
                                                            <h5 class="font-accent"> </h5>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $hiredAttorneyDetails->getAttornies->email }}</p>
                                                                <small class="small-text">Email</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $hiredAttorneyDetails->getAttornies->user_name }}</p>
                                                                <small class="small-text">Username</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $hiredAttorneyDetails->getAttornies->getUserDetails->dob }}</p>
                                                                <small class="small-text">DOB</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $hiredAttorneyDetails->getAttornies->getUserDetails->phone }}</p>
                                                                <small class="small-text">Phone Number</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $hiredAttorneyDetails->getAttornies->getUserDetails->address }}</p>
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
                        {{-- <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent">Case Information</h4>
                                                        <div class="row mt-4">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <p class="fs-5">
                                                                        @if ($hiredAttorneyDetails->getCaseDetail->is_same_person == 0)
                                                                            No
                                                                        @else
                                                                            Yes
                                                                        @endif
                                                                    </p>
                                                                    <small class="small-text">Is the person accused is the same person filling out this form</small>
                                                                </div>
                                                                @if ($hiredAttorneyDetails->getCaseDetail->is_same_person == 0)
                                                                    <div class="container">
                                                                        <div class="row mt-4">
                                                                            <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->convictee_name}}</p>
                                                                            <small class="small-text">Convictee Name</small>
                                                                        </div>
                                                                        <div class="row mt-4">
                                                                            <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->convictee_dob}}</p>
                                                                            <small class="small-text">Convictee DOB</small>
                                                                        </div>
                                                                        <div class="row mt-4">
                                                                            <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->convictee_relationship}}</p>
                                                                            <small class="small-text">Convictee Relation</small>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->client_name}}</p>
                                                                    <small class="small-text">Client-Name</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->client_dob}}</p>
                                                                    <small class="small-text">Clients DOB</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->preferred_language}}</p>
                                                                    <small class="small-text">Preferred language</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->court_where_the_case_is_at}}</p>
                                                                    <small class="small-text">Court where the case is at</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->case_or_citation_number}}</p>
                                                                    <small class="small-text">Case or citation number</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->charges}}</p>
                                                                    <small class="small-text">Charges (please name all of them)</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->next_court_date}}</p>
                                                                    <small class="small-text">Next Court date</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->type_of_hearing}}</p>
                                                                    <small class="small-text">Type of hearing</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->how_many_hearing_have_you_had}}</p>
                                                                    <small class="small-text">How many hearings have you had</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->list_all_prior_criminal_convictions}}</p>
                                                                    <small class="small-text">List all prior criminal convictions</small>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <p class="fs-5">{{$hiredAttorneyDetails->getCaseDetail->application}}</p>
                                                                    <small class="small-text">Application</small>
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
                            <div class="col-md-4">
                            <a href="{{route('customer_messages',[$hiredAttorneyDetails->getAttornies->id])}}" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> View Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
