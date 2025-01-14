@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Application Form')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #counties_of_preference{
        height: 60px !important;
        border-radius: 20px !important;
        border: 1px solid #ccc !important;
        padding: 10px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: solid #b38e6a 1px;
        min-height: 50px;
        border-radius: 20px;
        padding: .4rem 0.5rem;
        font-size: 17px;
        width: 100%;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #b38e6a;
        min-height: 50px;
        /* min-height: calc(1.5em +(1rem + 2px)) !important; */
        border-radius: 20px;
        cursor: text;
        position: relative;
        font-size: 17px;
        padding: .4rem 0.5rem;
        width: 100%;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #b38e6a54;
        border: 1px solid #b38e6a;
        border-radius: 4px;
        box-sizing: border-box;
        display: inline-block;
        margin-left: 5px;
        margin-top: 5px;
        padding: 0;
        padding-left: 20px;
        position: relative;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: bottom;
        white-space: nowrap;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #b38e6a; /* Change to your desired color */
        color: white;
    }
</style>
    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                    <div class="customer-portal-content py-3">
                        <form action="{{ route('attorney_application_form_store') }}" method="post"
                            enctype="multipart/form-data">@csrf
                            <div class="row">
                                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Form</h2>
                                <div
                                    class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                    <div class="circle-icon circle-icon-small step-check active"><i
                                            class="fa-solid fa-check"></i></div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="step-line step-line-small"></div>
                                    <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="offset-md-2 col-md-4 mb-2">
                                        <div class="card radius-20 app-card-for-image">
                                            <label for="imageUpload">
                                                <div class="card-body text-center circle background-primary">
                                                    <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                    <h5 class="card-title font-accent"> Upload <br> Image </h5>
                                                    <input type='file' id="imageUpload" multiple class="image-picker"
                                                        name="image[]" />
                                                    <div class="text-center">
                                                        @error('image.*')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="card radius-20 app-card-for-image">
                                            <label for="fileUpload">
                                                <div class="card-body text-center">
                                                    <i class="fa-solid fa-file accent-color-2 app-form-upload  mb-2"></i>
                                                    <h5 class="card-title font-accent"> Upload <br> Document </h5>
                                                    <input type='file' id="fileUpload" multiple class="doc-picker"
                                                        name="document[]" />
                                                    <div class="text-center">
                                                        @error('document.*')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                    <div>
                                        <label class="font-18 mb-2" for="name_of_applicant">Name of applicant:</label>
                                        <input id="name_of_applicant" name="name_of_applicant"
                                            value="{{ old('name_of_applicant') }}" placeholder="Name of applicant"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('name_of_applicant')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="name_of_firm_you_work_for">Name of firm you work
                                            for:</label>
                                        <input id="name_of_firm_you_work_for" name="name_of_firm_you_work_for"
                                            value="{{ old('name_of_firm_you_work_for') }}"
                                            placeholder="Name of firm you work for"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('name_of_firm_you_work_for')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="do_you_own_this_firm">Do you own this firm? Y or N
                                            If no, who owns this law firm:</label>
                                        <input id="do_you_own_this_firm" name="do_you_own_this_firm"
                                            value="{{ old('do_you_own_this_firm') }}"
                                            placeholder="Do you own this firm? Y or N If no, who owns this law firm"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('do_you_own_this_firm')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2"
                                            for="how_long_have_you_been_in_service_to_the_public">How long have you been in
                                            service to the public?</label>
                                        <input id="how_long_have_you_been_in_service_to_the_public"
                                            name="how_long_have_you_been_in_service_to_the_public"
                                            value="{{ old('how_long_have_you_been_in_service_to_the_public') }}"
                                            placeholder="How long have you been in service to the public?"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('how_long_have_you_been_in_service_to_the_public')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <h5 class="font-accent">Address of business location</h5>
                                    <div>
                                        <label class="font-18 mb-2" for="website">Website</label>
                                        <input id="website" name="website" placeholder="Website"
                                            value="{{ old('website') }}"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('website')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="email">Email:</label>
                                        <input id="email" name="email" placeholder="Email"
                                            value="{{ old('email') }}"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('email')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="phone">Phone:</label>
                                        <input id="phone" name="phone" placeholder="Phone"
                                            value="{{ old('phone') }}"
                                            class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('phone')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="languages_spoken">Languages spoken:</label>
                                        <input id="languages_spoken" name="languages_spoken"
                                            placeholder="Languages spoken" value="{{ old('languages_spoken') }}"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('languages_spoken')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="law_school_name">Law School name:</label>
                                        <input id="law_school_name" name="law_school_name" placeholder="Law school name"
                                            value="{{ old('law_school_name') }}"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('law_school_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="year_graduated">Year Graduated:</label>
                                        <select id="year_graduated" name="year_graduated"
                                            value="{{ old('year_graduated') }}"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                            <option selected disabled hidden>Please select year graduated</option>
                                            @php $years = range(1960, strftime("%Y", time())); @endphp
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}" @if(old('year_graduated') == $year) selected @endif >{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        @error('year_graduated')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="admitted_into_law_in_az">Admitted into law in
                                            AZ?</label>
                                        <input id="admitted_into_law_in_az" name="admitted_into_law_in_az"
                                            value="{{ old('admitted_into_law_in_az') }}"
                                            placeholder="Admitted into law in AZ?"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('admitted_into_law_in_az')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="az_state_bar_number">AZ State bar number:</label>
                                        <input id="az_state_bar_number" name="az_state_bar_number"
                                            value="{{ old('az_state_bar_number') }}" placeholder="AZ State bar number"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('az_state_bar_number')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="font-18 mb-2" for="any_special_certifications">Any special
                                            certifications?</label>
                                        <input id="any_special_certifications" name="any_special_certifications"
                                            value="{{ old('any_special_certifications') }}"
                                            placeholder="Any special certifications"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                            type="text">
                                        @error('any_special_certifications')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div><label class="font-18 mb-2" for="counties_of_preference">Counties of preference</label>
                                        <select id="counties_of_preference" multiple="multiple"
                                            name="counties_of_preference[]"
                                            class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                            <option value="Apache County">Apache County</option>
                                            <option value="Cochise County">Cochise County</option>
                                            <option value="Coconino County">Coconino County</option>
                                            <option value="Gila County">Gila County</option>
                                            <option value="Graham County">Graham County</option>
                                            <option value="Greenlee County">Greenlee County</option>
                                            <option value="La Paz County">La Paz County</option>
                                            <option value="Maricopa County">Maricopa County</option>
                                            <option value="Mohave County">Mohave County</option>
                                            <option value="Navajo County">Navajo County</option>
                                            <option value="Pima County">Pima County</option>
                                            <option value="Pinal County">Pinal County</option>
                                            <option value="Santa Cruz County">Santa Cruz County</option>
                                            <option value="Yavapai County">Yavapai County</option>
                                            <option value="Yuma County">Yuma County</option>
                                        </select>
                                    </div>
                                    <h5 class="font-accent">Areas of practice <br><small>(The areas of practice below are
                                            individually measured and not a collection among other attorneys working for the
                                            same firm)</small></h5>
                                    <div class="card border-0 radius-10 pt-4 pb-4">
                                        <div class="card-body">
                                            <div class="container" id="dynamic-fields-container">
                                                @if (old('area_of_practice'))
                                                    @foreach (old('area_of_practice') as $index => $oldValue)
                                                        <div class="dynamic-field mb-4">
                                                            <div>
                                                                <label class="font-18 mb-2 area-of-practice-label"
                                                                    for="area_of_practice">Area of practice
                                                                    {{ $index + 1 }}:</label>
                                                                <select name="area_of_practice[]" id="area_of_practice" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                    <option selected hidden disabled>Please select area of practice</option>
                                                                    @foreach ($cases as $case)
                                                                        @if ($case->status === 'Enable')
                                                                            <option value="{{$case->title}}" {{$oldValue == $case->title ? 'selected' : ''}}>{{$case->title}} (Active)</option>
                                                                        @elseif($case->status !== 'Archive')
                                                                            <option class="text-grey" value="{{$case->title}}" {{$oldValue == $case->title ? 'selected' : ''}}>{{$case->title}} (Coming soon)</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                @error('area_of_practice.' . $index)
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label class="font-18 mb-2"
                                                                    for="year_started_in_this_area">Year started in this
                                                                    area:</label>
                                                                <select id="year_started_in_this_area"
                                                                    name="year_started_in_this_area[]"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                    <option selected disabled hidden>Please select year
                                                                        started in this area</option>
                                                                    @php $years = range(1980, strftime("%Y", time())); @endphp
                                                                    @foreach ($years as $year)
                                                                        <option value="{{ $year }}"
                                                                            @if (old('year_started_in_this_area.' . $index) == $year) selected @endif>
                                                                            {{ $year }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('year_started_in_this_area.' . $index)
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label class="font-18 mb-2"
                                                                    for="average_no_of_cases_handled_per_year">Average no
                                                                    of cases handled per year</label>
                                                                <input id="average_no_of_cases_handled_per_year"
                                                                    name="average_no_of_cases_handled_per_year[]"
                                                                    value="{{ old('average_no_of_cases_handled_per_year.' . $index) }}"
                                                                    placeholder="Average no of cases handled per year"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                    type="number">
                                                                @error('average_no_of_cases_handled_per_year.' . $index)
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="mt-2 mb-1">
                                                                <button type="button"
                                                                    class="remove-field align-self-start btn bg-primary text-white py-2 px-5 font-20 radius-10"
                                                                    @if ($index == 0) style="display: none;" @endif>x
                                                                    Remove</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="dynamic-field mb-4">
                                                        <div>
                                                            <label class="font-18 mb-2 area-of-practice-label"
                                                                for="area_of_practice">Area of practice 1:</label>
                                                            <select name="area_of_practice[]" id="area_of_practice" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                <option selected hidden disabled>Please select area of practice</option>
                                                                @foreach ($cases as $case)
                                                                        @if ($case->status === 'Enable')
                                                                            <option value="{{$case->title}}">{{$case->title}} (Active)</option>
                                                                        @elseif($case->status !== 'Archive')
                                                                            <option class="text-grey" value="{{$case->title}}">{{$case->title}} (Coming soon)</option>
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                            @error('area_of_practice.*')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="font-18 mb-2"
                                                                for="year_started_in_this_area">Year started in this
                                                                area:</label>
                                                            <select id="year_started_in_this_area"
                                                                name="year_started_in_this_area[]"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                <option selected disabled hidden>Please select year started
                                                                    in this area</option>
                                                                @php $years = range(1980, strftime("%Y", time())); @endphp
                                                                @foreach ($years as $year)
                                                                    <option value="{{ $year }}"
                                                                        @if (old('year_started_in_this_area.0') == $year) selected @endif>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('year_started_in_this_area.*')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="font-18 mb-2"
                                                                for="average_no_of_cases_handled_per_year">Average no of
                                                                cases handled per year</label>
                                                            <input id="average_no_of_cases_handled_per_year"
                                                                name="average_no_of_cases_handled_per_year[]"
                                                                value="{{ old('average_no_of_cases_handled_per_year.0') }}"
                                                                placeholder="Average no of cases handled per year"
                                                                class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                type="number">
                                                            @error('average_no_of_cases_handled_per_year.*')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2 mb-1">
                                                            <button type="button"
                                                                class="remove-field align-self-start btn bg-primary text-white py-2 px-5 font-20 radius-10"
                                                                style="display: none;">x Remove</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="container text-end">
                                                <button type="button" id="add-field"
                                                    class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10">+
                                                    Add</button>
                                            </div>

                                        </div>
                                    </div>
                                        <h5 class="font-accent">The information provided above is accurate and truthful. I
                                            also understand that the information above will be featured in my profile. I
                                            further understand that every lawyer at the firm needs to fill out a separate
                                            application.</h5>
                                        {{-- <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div> --}}
                                        <hr>
                                        <div class="row">
                                            <div class="offset-md-2 col-md-8">
                                                <div class="parent">
                                                    <label class="font-18 mb-2 w-100" for="sign">Signature of
                                                        applicant</label>
                                                    <div class="below">
                                                        <canvas
                                                            class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                                        <input type="hidden" name="signature_of_applicant"
                                                            id="hidden-signature-data" value="">
                                                        <button
                                                            class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10"
                                                            id="signature-trash">X</button>
                                                        <button
                                                            class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10"
                                                            id="confirm-signature">Confirm</button>
                                                    </div>
                                                    @error('signature_of_applicant')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                        <div class="parent text-center">
                                            <label class="font-18 mb-2 w-100" for="sign">Download profile picture here</label>
                                            <div class="card radius-20 border-app">
                                                <div class="card-body app-attorney-footer">
                                                    <img src="{{asset('images/svg/profile-picture.svg')}}" class="download-app-attor" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="parent text-center">
                                            <label class="font-18 mb-2 w-100" for="sign">Download law firm logo here</label>
                                            <div class="card radius-20 border-app">
                                                <div class="card-body app-attorney-footer">
                                                    <img src="{{asset('images/svg/firm-logo.svg')}}" class="download-app-attor" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                        </div>
                                        <button
                                            class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button"
                                            type="submit" onclick="showLoader();" >Submit</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update the labels
            function updateLabels() {
                $('.area-of-practice-label').each(function(index) {
                    $(this).text('Area of practice ' + (index + 1) + ':');
                });
            }

            // Function to add a new set of fields
            $('#add-field').click(function() {
                var newField = $('.dynamic-field:first').clone(); // Clone the first set of fields
                newField.find('input, select').val(''); // Clear the values in the cloned fields

                // Populate with old values
                newField.find('input').each(function(index, element) {
                    var oldVal = $('input[name="area_of_practice[' + index + ']"]').val();
                    $(element).val(oldVal);
                });

                newField.find('select').each(function(index, element) {
                    var oldVal = $('select[name="year_started_in_this_area[' + index + ']"]').val();
                    $(element).val(oldVal);
                });

                newField.find('.remove-field').show(); // Show the remove button
                newField.hide().appendTo('#dynamic-fields-container')
            .slideDown(); // Append and slide down the cloned fields
                updateLabels(); // Update the labels
            });

            // Function to remove a set of fields
            $(document).on('click', '.remove-field', function() {
                if ($('.dynamic-field').length > 1) {
                    $(this).closest('.dynamic-field').slideUp(function() {
                        $(this).remove(); // Remove the closest .dynamic-field after sliding up
                        updateLabels(); // Update the labels
                    });
                } else {
                    alert("At least one set of fields is required."); // Ensure at least one set remains
                }
            });

            // Initial label update and show the first field
            updateLabels();
            $('.dynamic-field:first').show();

            $('#counties_of_preference').select2({
                placeholder: 'Please select counties of preference',
                allowClear: true
            });
        });

        FilePond.setOptions({
            server: {
                process: '/upload-temp',
                revert: '/delete-temp',
            },
            onprocessfile: (error, file) => {
                if (!error) {
                    document.cookie = `uploaded_file=${file.serverId}; path=/; max-age=3600`; // Store for 1 hour
                }
            },
        });

        document.addEventListener('DOMContentLoaded', function () {
            const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
                const [name, value] = cookie.split('=');
                acc[name] = value;
                return acc;
            }, {});

            const uploadedFile = cookies['uploaded_file'];

            if (uploadedFile) {
                FilePond.create(document.querySelector('.filepond'), {
                    files: [
                        {
                            source: uploadedFile,
                            options: {
                                type: 'local',
                            },
                        },
                    ],
                });
            }
        });

    </script>
@endpush
