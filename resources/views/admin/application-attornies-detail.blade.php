@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies Details')

@section('content')

@push('css')
    <style>
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
            border: 0;
            border-radius: .25em;
            background: initial;
            background-color: #b38e6a !important;
            color: #fff;
            font-size: 1em;
        }
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-cancel) {
            border: #b38e6a 1px solid !important;
            border-radius: .25em;
            background: initial;
            background-color: #6e788105 !important;
            color: #b38e6a !important;
            font-size: 1em;
        }
    </style>
@endpush

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
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
                                                        <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Attorney Details</h3>
                                                        <div class="row ">
                                                            <div class="col-md-2 text-start">
                                                                <div class="icon-large">
                                                                    <div class="customer-avatar">
                                                                        <img class="w-100" src="{{isset($application->getUser->getUserDetails->image) ? asset($application->getUser->getUserDetails->image) : asset('images/user-dummy.jpg')}}" alt="">
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
                                                            {{-- <div class="col-md-3 d-flex align-items-center">
                                                                <div class="row text-end">
                                                                    <div class="col-md-12">
                                                                        <div class="rating-box">
                                                                            <div class="rating-container">
                                                                                <input disabled type="radio" name="rating" value="5" id="star-5"> <label for="star-5">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="4" id="star-4"> <label for="star-4">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="3" id="star-3"> <label for="star-3">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="2" id="star-2"> <label for="star-2">&#9733;</label>

                                                                                <input disabled type="radio" name="rating" value="1" id="star-1"> <label for="star-1">&#9733;</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->getUser->email }}</p>
                                                            <small class="small-text">Email</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->getUser->user_name }}</p>
                                                            <small class="small-text">Username</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->getUser->getUserDetails->phone }}</p>
                                                            <small class="small-text">Phone Number</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->getUser->getUserDetails->address }}</p>
                                                            <small class="small-text">Address</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            {{-- <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent">Attorney Bio</h4> --}}
                                                            <p class="fs-5">
                                                                {{ isset($application->getUser->getUserDetails->bio) ? $application->getUser->getUserDetails->bio : 'Bio not found.' }}
                                                            </p>
                                                            <small class="small-text">Bio</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ((isset($application->getUser)) AND $application->getUser->restricted_steps > 11)
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
                                            @if (!empty($application->counties_of_preference) && is_array(json_decode($application->counties_of_preference)))
                                                @php $counties = json_decode($application->counties_of_preference);  @endphp

                                                <hr>
                                                @foreach ($counties as $county)
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ $county }}
                                                        </p>
                                                        <small class="small-text">Counties of preference</small>
                                                    </div>
                                                @endforeach
                                            @endif
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
                                                        No media uploaded...
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
                                        <h5 class="fw-bold font-accent">Agreement 1</h5>
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
                                                            @foreach($getLaws as $law)
                                                                <li>
                                                                    {{$law->title}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </p>
                                                    <small class="small-text">Area of law</small>
                                                </div>
                                            </div>
                                            {{-- <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->malpractice }}</p>
                                                <small class="small-text">Malpractice</small>
                                            </div> --}}
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->date }}</p>
                                                <small class="small-text">Agreement Date</small>
                                            </div>
                                            <hr class="mt-4">
                                        </div>

                                        {{-- <h5 class="fw-bold font-accent">Agreement 2</h5>
                                        <div class="col-md-6">
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->attorney_name_2 }}</p>
                                                <small class="small-text">Attorney name</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->name_of_law_firm	 }}</p>
                                                <small class="small-text">Name of law firm</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->in_service_since }}</p>
                                                <small class="small-text">In service since</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->name_of_attorney }}</p>
                                                <small class="small-text">Name of attorney</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->state_bar }}</p>
                                                <small class="small-text">State bar</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->dob }}</p>
                                                <small class="small-text">DOB</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->law_school }}</p>
                                                <small class="small-text">Law school</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->year_graduated }}</p>
                                                <small class="small-text">Year graduated</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->office_address }}</p>
                                                <small class="small-text">Office address</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->website }}</p>
                                                <small class="small-text">Website</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->phone }}</p>
                                                <small class="small-text">Phone</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->spoken_languages }}</p>
                                                <small class="small-text">Spoken Languages</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->admitted_in_arizona }}</p>
                                                <small class="small-text">Admitted in arizona</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->malpractice }}</p>
                                                <small class="small-text">Malpractice</small>
                                            </div>
                                            <div class="row mt-4">
                                                <p class="fs-5">{{ $agreement->date }}</p>
                                                <small class="small-text">Date</small>
                                            </div>
                                        </div>
                                        <hr class="mt-4">
                                        @foreach (json_decode($agreement->area_of_practice) as $key => $area)
                                            <div class="col-md-6">
                                                @if (isset($area[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">{{ $area }}</p>
                                                        <small class="small-text">Area of practice
                                                            {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                                @if (isset(json_decode($agreement->year_started)[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ json_decode($agreement->year_started)[$key] }}
                                                        </p>
                                                        <small class="small-text">Year started
                                                            {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                                @if (isset(json_decode($agreement->cases_handled_per_year)[$key]))
                                                    <div class="row mt-4">
                                                        <p class="fs-5">
                                                            {{ json_decode($agreement->cases_handled_per_year)[$key] }}
                                                        </p>
                                                        <small class="small-text">Average cases handled per
                                                            year {{ $key + 1 }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div> --}}
                                    {{-- <hr class="mt-4"> --}}
                                    <div class="row">
                                        <div class="offset-md-3 col-md-6">
                                            <a href="{{ asset($agreement->signature) }}"
                                                target="__blank">
                                                <img src="{{ asset($agreement->signature) }}"
                                                    alt=""
                                                    class="w-100 mt-3 form-image">
                                                <small class="small-text">Signature</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 radius-20 pb-4 mt-4">
                            <div class="card-body p-4">
                                    <div class="container p-4">
                                        <div class="row">
                                            <h3 class="fw-bold font-28 mb-0 col-lg-12 font-accent mb-4">Attorney Payment Information</h3>
                                            <div class="container">
                                                <div class="row">
                                                    @if ($application->getUser->getUserPaymentDetailsOne)
                                                        <div class="col-md-6 mb-2">
                                                            <label class="font-18 mb-2">Stripe Connect Account Id</label>
                                                            <input type="text" readonly value="{{$application->getUser->getUserPaymentDetailsOne->stripe_attorney_connect_id}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="font-18 mb-2">Status</label>
                                                            <input type="text" readonly value="{{$application->getUser->getUserPaymentDetailsOne->status}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                        </div>
                                                        @if ($application->getUser->getUserPaymentDetailsOne->stripe_customer_id)
                                                            <hr class="mt-4">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-18 mb-2">Stripe Card Last 4</label>
                                                                <input type="text" readonly value="**** **** **** {{$application->getUser->getUserPaymentDetailsOne->card_last_four}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-18 mb-2">Stripe Card Expiry</label>
                                                                <input type="text" readonly value="{{$application->getUser->getUserPaymentDetailsOne->card_expiry_month}} / {{$application->getUser->getUserPaymentDetailsOne->card_expiry_year}}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="col-md-6 mb-2 text-center">
                                                            <p>Payment details not found.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                                        @foreach($assignedAttornies as $assigned)
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
                        @elseif ($application->status == 'Rejected')
                            <div class="card border-0 radius-20 pb-4 mt-4">
                                <div class="card-body p-4">
                                        <div class="container p-4">
                                            <div class="row text-center">
                                                <h3 class="font-accent">Application <span class="text-danger">Rejected</span></h3>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="card border-0 radius-20 pb-4 mt-4">
                                <div class="card-body p-4">
                                    <form action="{{ route('admin_assign_attornies') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger" id="error-messages">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <input type="hidden" name="attorney_id" value="{{ $application->getUser->id }}">
                                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                                        <div class="container p-4">
                                            <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Assign Attorney Type</h3>
                                            <div class="row">
                                                @foreach($getLaws as $index => $law)
                                                    <div class="col-md-6 mb-2">
                                                        <label class="font-18 mb-2" for="package_id_{{ $index }}">{{ $law->title }}</label>
                                                        <input type="hidden" name="law_cat_id[{{ $index }}]" value="{{ $law->id }}">
                                                        <select name="package_id[{{ $index }}]" id="package_id_{{ $index }}" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                            <option selected hidden disabled>Please select experience level</option>
                                                            @foreach ($getPackage as $package)
                                                                <option value="{{ $package->id }}" {{ old('package_id.' . $index) == $package->id ? 'selected' : '' }}>{{ $package->title }}</option>
                                                            @endforeach
                                                            <option value="0" {{ old('package_id.' . $index) == '0' ? 'selected' : '' }}>Reject</option>
                                                        </select>
                                                        @error('package_id.' . $index)
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12 text-center">
                                                    <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" onclick="showLoader();" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="offset-md-4 col-md-4">
                                    <a href="{{route('admin_reject_attorney_application',[$application->id])}}"  id="reject" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button">Reject Application</a>
                                </div>
                            </div>
                        @endif



                        @endif

                        {{-- <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h4 class="fw-bold font-20 mb-0 col-lg-6 font-accent">Additional Information</h4>
                                                            <h5 class="font-accent"> </h5>
                                                            <p class="font-accent">
                                                            <small class="fw-bold">Heading</small>
                                                            <br>
                                                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                                            </p>
                                                            <p class="font-accent">
                                                            <small class="fw-bold">Heading</small>
                                                            <br>
                                                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                                            </p>
                                                            <p class="font-accent">
                                                            <small class="fw-bold">Heading</small>
                                                            <br>
                                                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row mt-4">
                            <div class="col-md-4">
                            <a href="#" class="btn-primary w-100 d-block text-center p-3 mb-2 radius-10"> View Chat</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.alert.alert-danger')) {
            document.querySelector('.alert.alert-danger').scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>
<script>
    $(function(){
        $(document).on('click','#reject',function(e){
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Reject Application?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'No, close',
            }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = link
                }
            })
        });
    });
</script>
@endpush
