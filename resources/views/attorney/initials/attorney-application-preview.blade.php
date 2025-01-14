@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney application preview')

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
                        <form action="{{route('attorney_application_preview_store')}}" method="POST" enctype="multipart/form-data"> @csrf
                            <input type="hidden" name="application_id" value="{{$application->id}}">
                            <div class="row" class="step">
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Preview</h2>
                                <div
                                    class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                    <div class="circle-icon circle-icon-small step-check active"><i
                                            class="fa-solid fa-check"></i></div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check active"><i
                                            class="fa-solid fa-check"></i></div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check active"><i
                                            class="fa-solid fa-check"></i></div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check active"><i
                                            class="fa-solid fa-check"></i></div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                    <div class="card border-0 radius-10 pt-4 pb-4">
                                        <div class="card-body">
                                            <div class="container">
                                                <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Profile Details
                                                </h2>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <p class="fs-5">
                                                                {{ ucfirst($profile->getUserDetails->first_name) }}
                                                                {{ ucfirst($profile->getUserDetails->last_name) }}</p>
                                                            <small class="small-text">Name</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $profile->email }}</p>
                                                            <small class="small-text">Email</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $profile->user_name }}</p>
                                                            <small class="small-text">Username</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $profile->getUserDetails->phone }}</p>
                                                            <small class="small-text">Phone Number</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $profile->getUserDetails->address }}</p>
                                                            <small class="small-text">Address</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <div class="avatar-preview">
                                                            <img class="profile-user-img img-responsive img-circle"
                                                                id="imagePreview"
                                                                src="{{ asset($profile->getUserDetails->image) }}"
                                                                alt="User profile picture">
                                                            <h4 class="customer-name font-18 mt-2 fw-bold font-accent">
                                                                {{ ucfirst($profile->getUserDetails->first_name) }}
                                                                {{ ucfirst($profile->getUserDetails->last_name) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0 radius-10 pt-4 pb-4">
                                        <div class="card-body">
                                            <div class="container">
                                                <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Application
                                                    Details</h2>
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
                                                        {{-- <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->admitted_into_law_AZ }}</p>
                                                            <small class="small-text">Admitted into law AZ</small>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <p class="fs-5">{{ $application->admitted_into_law_AZ }}</p>
                                                            <small class="small-text">Admitted into law AZ</small>
                                                        </div> --}}
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
                                        <div class="card border-0 radius-10 pt-4 pb-4">
                                            <div class="card-body">
                                                <div class="container">
                                                    <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Attached
                                                        Media</h2>
                                                    <div class="row">
                                                        @forelse ($medias as $media)
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
                                                            <p>No media uploaded...</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0 radius-20 pb-4 pb-4">
                                        <div class="card-body p-4">
                                            <div class="container p-4">
                                                <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Agreement Details</h3>
                                                <div class="row">
                                                    <h5 class="fw-bold font-accent">Agreement with YourBestLawyer.com</h5>
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
                                                        {{-- <hr class="mt-4"> --}}

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
                                    <div class="card border-0 radius-20 pb-4 pb-4">
                                        <div class="card-body p-4">
                                            <div class="container p-4">
                                                <h3 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Payment Details</h3>
                                                <div class="row">
                                                    <div class="row mt-2">
                                                        <div class="col-md-10">
                                                            <h4 class="font-primary">Card Ending
                                                                in
                                                                <span class="fw-bold">{{ $profile->getUserPaymentDetailsOne->card_last_four }}</span>
                                                            </h4>
                                                            <h5 class="font-primary">Expiry
                                                                <span class="fw-bold">{{ $profile->getUserPaymentDetailsOne->card_expiry_month }}
                                                                /
                                                                {{ $profile->getUserPaymentDetailsOne->card_expiry_year }}</span>
                                                            </h5>
                                                            <h5 class="font-primary">CVC <span class="fw-bold">***</span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="row mt-2">
                                                        <div class="col-md-10">
                                                            <h4 class="font-primary">Connect Account Id :
                                                                <span class="fw-bold">{{ $profile->getUserPaymentDetailsOne->stripe_attorney_connect_id }}</span>
                                                            </h4>
                                                            <h5 class="font-primary">Status :
                                                                <span class="fw-bold">{{ $profile->getUserPaymentDetailsOne->status }}</span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12 text-end">
                                            <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" onclick="showLoader();" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
