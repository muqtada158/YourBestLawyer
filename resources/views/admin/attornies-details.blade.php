@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies Details')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Super-Admin Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-superadmin')
                    </div>
                    <div class="customer-portal-content py-3">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Attorney Application Details</h2>
                        <div class="container">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card radius-20 border-0">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row mt-3">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">
                                                                Attorney Details</h3>
                                                            <div class="row ">
                                                                <div class="col-md-2 text-start">
                                                                    <div class="icon-large">
                                                                        <div class="customer-avatar">
                                                                            <img class="w-100"
                                                                                src="{{ isset($application->getUser->getUserDetails->image) ? asset($application->getUser->getUserDetails->image) : asset('images/user-dummy.jpg') }}"
                                                                                alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7 d-flex align-items-center">
                                                                    <div class="pt-2">
                                                                        <p class="font-accent">
                                                                            <span class="font-20 fw-bold">
                                                                                {{ isset($application->getUser->getUserDetails->first_name) ? ucfirst($application->getUser->getUserDetails->first_name) : $application->getUser->user_name }}
                                                                                {{ isset($application->getUser->getUserDetails->last_name) ? ucfirst($application->getUser->getUserDetails->last_name) : '' }}
                                                                            </span>
                                                                            {{-- <br>
                                                                        <small class="accent-color-3">Accident Case</small>
                                                                        <br>
                                                                        <span class="font-14 fw-bold">On Going Cases : 50</span> --}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <div class="row text-end">
                                                                        <div class="col-md-12">
                                                                            <div class="rating-box">
                                                                                <div class="rating-container">
                                                                                    <input disabled type="radio"
                                                                                        name="rating" value="5"
                                                                                        id="star-05"
                                                                                        {{ attorneyRatings($application->getUser->id) == 5 ? 'checked' : '' }}>
                                                                                    <label for="star-05"
                                                                                        title="Ratings : {{ attorneyRatings($application->getUser->id) }}">&#9733;</label>

                                                                                    <input disabled type="radio"
                                                                                        name="rating" value="4"
                                                                                        id="star-04"
                                                                                        {{ attorneyRatings($application->getUser->id) == 4 ? 'checked' : '' }}>
                                                                                    <label for="star-04"
                                                                                        title="Ratings : {{ attorneyRatings($application->getUser->id) }}">&#9733;</label>

                                                                                    <input disabled type="radio"
                                                                                        name="rating" value="3"
                                                                                        id="star-03"
                                                                                        {{ attorneyRatings($application->getUser->id) == 3 ? 'checked' : '' }}>
                                                                                    <label for="star-03"
                                                                                        title="Ratings : {{ attorneyRatings($application->getUser->id) }}">&#9733;</label>

                                                                                    <input disabled type="radio"
                                                                                        name="rating" value="2"
                                                                                        id="star-02"
                                                                                        {{ attorneyRatings($application->getUser->id) == 2 ? 'checked' : '' }}>
                                                                                    <label for="star-02"
                                                                                        title="Ratings : {{ attorneyRatings($application->getUser->id) }}">&#9733;</label>

                                                                                    <input disabled type="radio"
                                                                                        name="rating" value="1"
                                                                                        id="star-01"
                                                                                        {{ attorneyRatings($application->getUser->id) == 1 ? 'checked' : '' }}>
                                                                                    <label for="star-01"
                                                                                        title="Ratings : {{ attorneyRatings($application->getUser->id) }}">&#9733;</label>
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
                                                                <p class="fs-5">{{ $application->getUser->email }}</p>
                                                                <small class="small-text">Email</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">{{ $application->getUser->user_name }}
                                                                </p>
                                                                <small class="small-text">Username</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">
                                                                    {{ $application->getUser->getUserDetails->phone }}</p>
                                                                <small class="small-text">Phone Number</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">
                                                                    {{ $application->getUser->getUserDetails->address }}
                                                                </p>
                                                                <small class="small-text">Address</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <p class="fs-5">
                                                                    {{ isset($application->getUser->getUserDetails->bio) ? $application->getUser->getUserDetails->bio : 'Bio not found.' }}
                                                                </p>
                                                                <small class="small-text">Bio</small>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <form action="{{ route('admin_update_status') }}"
                                                                    method="POST">@csrf
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $application->getUser->id }}">
                                                                        <select name="status" id="status"
                                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                            <option value="Enabled"
                                                                                {{ $application->getUser->status == 'Enabled' ? 'selected' : '' }}>
                                                                                Enabled</option>
                                                                            <option value="Disabled"
                                                                                {{ $application->getUser->status == 'Disabled' ? 'selected' : '' }}>
                                                                                Disabled</option>
                                                                        </select>
                                                                        @error('status')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                        <small class="small-text">Status</small>
                                                                        <button type="submit"
                                                                            class="mt-4 btn-primary d-block w-50 p-1 mb-2 pt-3 pb-3 radius-10">Update
                                                                            Status</button>
                                                                    </div>
                                                                </form>
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
                                                <div class="row mt-3">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <form action="{{route('admin_attorney_review')}}" method="POST">@csrf
                                                                <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">
                                                                    Attorney Reviews</h3>
                                                                <div class="row mt-4">
                                                                    <h5 class="font-accent mb-2">Google Review</h5>
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" name="attorney_id"
                                                                            value="{{ $application->getUser->id }}">
                                                                        <input type="text" name="google_review"
                                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter review score i.e : 3"
                                                                            min="0" max="5"
                                                                            value="{{ old('google_review', isset($attorneyReviews->google_review) ? $attorneyReviews->google_review : '') }}">
                                                                        <small class="small-text">Google score</small>
                                                                        @error('google_review')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    {{-- <div class="col-md-6">
                                                                        <input type="text" name="google_date" readonly
                                                                            class="form-control-lg date height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter google date"
                                                                            value="{{ old('google_date', isset($attorneyReviews->google_date) ? $attorneyReviews->google_date : '') }}">
                                                                        <small class="small-text">Google Date</small><br>
                                                                        @error('google_date')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div> --}}
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <h5 class="font-accent mb-2">Yelp Review</h5>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="yelp_review"
                                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter review score i.e : 3"
                                                                            min="0" max="5"
                                                                            value="{{ old('yelp_review', isset($attorneyReviews->yelp_review) ? $attorneyReviews->yelp_review : '') }}">
                                                                        <small class="small-text">Yelp score</small><br>
                                                                        @error('yelp_review')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    {{-- <div class="col-md-6">
                                                                        <input type="text" name="yelp_date"
                                                                            id="date" readonly
                                                                            class="form-control-lg date height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter yelp date"
                                                                            value="{{ old('yelp_date', isset($attorneyReviews->yelp_date) ? $attorneyReviews->yelp_date : '') }}">
                                                                        <small class="small-text">Yelp Date</small><br>
                                                                        @error('yelp_date')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div> --}}
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <h5 class="font-accent mb-2">Avvo Review</h5>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="avvo_review"
                                                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter review score i.e : 3"
                                                                            min="0" max="5"
                                                                            value="{{ old('avvo_review', isset($attorneyReviews->avvo_review) ? $attorneyReviews->avvo_review : '') }}">
                                                                        <small class="small-text">Avvo score</small><br>
                                                                        @error('avvo_review')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    {{-- <div class="col-md-6">
                                                                        <input type="text" name="avvo_date"
                                                                            id="date" readonly
                                                                            class="form-control-lg date height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                            placeholder="Enter avvo date"
                                                                            value="{{ old('avvo_date', isset($attorneyReviews->avvo_date) ? $attorneyReviews->avvo_date : '') }}">
                                                                        <small class="small-text">avvo Date</small><br>
                                                                        @error('avvo_date')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div> --}}
                                                                </div>
                                                                <div class="row text-center">
                                                                    <div class="col-md-6">
                                                                        <button type="submit"
                                                                            class="mt-4 btn-primary d-block w-50 p-1 mb-2 pt-3 pb-3 radius-10">Update
                                                                            Reviews</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @if (isset($application->getUser) and $application->getUser->restricted_steps > 11)
                        <div class="card border-0 radius-20 pb-4 mt-4">
                            <div class="card-body p-4">
                                <div class="container p-4">
                                    <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Application Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="fs-5">
                                                    {{ ucfirst($application->name_of_applicant) }}</p>
                                                <small class="small-text">Client Name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->website }}</p>
                                                <small class="small-text">Website</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->email }}</p>
                                                <small class="small-text">Email</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->phone }}</p>
                                                <small class="small-text">Phone</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->languages_spoken }}</p>
                                                <small class="small-text">Languages spoken</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->law_school_name }}</p>
                                                <small class="small-text">Law school name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->year_graduated }}</p>
                                                <small class="small-text">Year Graduated</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->any_special_certification }}
                                                </p>
                                                <small class="small-text">Any special certification</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->name_of_firm_you_work_for }}
                                                </p>
                                                <small class="small-text">Name of firm you work for</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->do_you_own_this_firm }}</p>
                                                <small class="small-text">Do you own this firm</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">
                                                    {{ $application->how_long_have_you_been_in_service_to_the_public }}
                                                </p>
                                                <small class="small-text">How long have you been in service to
                                                    the public</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->admitted_into_law_AZ }}</p>
                                                <small class="small-text">Admitted into law AZ</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->AZ_state_bar_name }}</p>
                                                <small class="small-text">AZ state bar name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->admitted_into_law_AZ }}</p>
                                                <small class="small-text">Admitted into law AZ</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $application->admitted_into_law_AZ }}</p>
                                                <small class="small-text">Admitted into law AZ</small>
                                            </div>
                                        </div>
                                        <hr class="mt-4">
                                        @foreach (json_decode($application->area_of_practice) as $key => $area)
                                            <div class="col-md-6">
                                                @if (isset($area[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">{{ $area }}</p>
                                                        <small class="small-text">Area of practice
                                                            {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                                @if (isset(json_decode($application->year_started_in_this_area)[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ json_decode($application->year_started_in_this_area)[$key] }}
                                                        </p>
                                                        <small class="small-text">Year started in this area
                                                            {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                                @if (isset(json_decode($application->average_cases_handled_per_month)[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ json_decode($application->average_cases_handled_per_month)[$key] }}
                                                        </p>
                                                        <small class="small-text">Average cases handled per
                                                            month {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        <hr class="mt-4">
                                        <div class="row">
                                            <div class="offset-md-3 col-md-6">
                                                <a href="{{ asset($application->signature_image) }}"
                                                    target="__blank">
                                                    <img src="{{ asset($application->signature_image) }}"
                                                        alt=""
                                                        class="w-100 mt-3 form-image">
                                                    <small class="small-text">Application Signature</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 radius-10 p-4">
                                <div class="card-body">
                                    <div class="container">
                                        <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Attached
                                            Media</h2>
                                        <div class="row">
                                            @forelse ($application->getAttorneyApplicationMedia as $media)
                                                @if ($media->type == 'image')
                                                    <div class="col-md-3">
                                                        <a href="{{ asset($media->media) }}"
                                                            target="__blank">
                                                            <img src="{{ asset($media->media) }}"
                                                                alt=""
                                                                class="w-100 mt-3 mb-3 form-image">
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($media->type == 'document')
                                                    <div class="col-md-3">
                                                        <a href="{{ asset($media->media) }}"
                                                            target="__blank">
                                                            <img src="{{ asset('images/document-thumbnail.png') }}"
                                                                alt=""
                                                                class="w-100 mt-3 mb-3 form-image">
                                                        </a>
                                                    </div>
                                                @endif
                                            @empty
                                            <p>
                                                No media uploaded.
                                            </p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-20 pb-4 mt-4">
                            <div class="card-body p-4">
                                <div class="container p-4">
                                    <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Agreement Details</h3>
                                    <div class="row">
                                        <h5 class="fw-bold font-accent">Agreement </h5>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <p class="fs-5">
                                                    {{ ucfirst($agreement->attorney_name_1) }}</p>
                                                <small class="small-text">Attorney name</small>
                                            </div>
                                            <div class="row">
                                                <div class="container">
                                                    <p class="fs-5">
                                                        <ul>
                                                            @foreach ($getLaws as $law)
                                                                <li>
                                                                    {{$law->title}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </p>
                                                    <small class="small-text">Area of law</small>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->malpractice }}</p>
                                                <small class="small-text">Malpractice</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->date }}</p>
                                                <small class="small-text">Agreement Date</small>
                                            </div>
                                        </div>


                                    <hr class="mt-4">
                                    <div class="row">
                                        <div class="offset-md-3 col-md-6">
                                            <a href="{{ asset($agreement->signature) }}"
                                                target="__blank">
                                                <img src="{{ asset($agreement->signature) }}"
                                                    alt=""
                                                    class="w-100 mt-3 form-image">
                                                <small class="small-text">Agreement Signature</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($application->status == 'Accepted')
                            <div class="card border-0 radius-20 pb-4 mt-4">
                                <div class="card-body p-4">
                                        <div class="container p-4">
                                            <div class="row">
                                                <h3 class="fw-bold font-28 mb-0 col-lg-12 font-accent mb-4">Assigned Attorney Type</h3>
                                                <div class="container">
                                                    <div class="row">
                                                        @foreach ($assignedAttornies as $assigned)
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-18 mb-2">{{$assigned->getCaseLaw->title}}</label>
                                                                <input type="text" readonly value="{{$assigned->getCasePackage->title}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @endif

                        @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@push('js')
    <script>
        $(function() {
            var today = new Date();
            $(".date").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                maxDate: today,
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.alert.alert-danger')) {
                document.querySelector('.alert.alert-danger').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
@endpush
