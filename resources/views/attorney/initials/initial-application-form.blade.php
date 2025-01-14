@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Initial Add Application')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form id="multi-step-form">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Form</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="row mt-4">
                                <div class="offset-md-2 col-md-4 mb-2">
                                    <div class="card radius-20 app-card-for-image">
                                        <label for="imageUpload">
                                            <div class="card-body text-center circle background-primary">
                                                    <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                    <h5 class="card-title font-accent"> Upload <br> Image </h5>
                                                    <input type='file' id="imageUpload" multiple class="mypicker" name="image" />
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
                                                    <input type='file' id="fileUpload" multiple class="mypicker" name="doc"/>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div>
                                    <label class="font-18 mb-2" for="client-name">Name of applicant:</label>
                                    <input required name="name_of_applicant" placeholder="Name of applicant" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="client-dob">Name of firm you work for:</label>
                                    <input required name="name_of_firm_you_work_for" placeholder="Name of firm you work for" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="preferred-language">Do you own this firm? Y or N If no, who owns this law firm:</label>
                                    <input required name="do_you_own_this_firm" placeholder="Do you own this firm? Y or N If no, who owns this law firm" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="court">How long have you been in service to the public?</label>
                                    <input required name="how_long_have_you_been_in_service_to_the_public" placeholder="How long have you been in service to the public?" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <h5 class="font-accent">Address of business location</h5>
                                <div>
                                    <label class="font-18 mb-2" for="website">Website</label>
                                    <input required id="website" name="website" placeholder="Website" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="charges">Email:</label>
                                    <input required id="charges" name="email" placeholder="Email" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="phone">Phone:</label>
                                    <input required id="phone" name="phone" placeholder="Phone" class="form-control-lg phone-number height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="languages_spoken">Languages spoken:</label>
                                    <input required id="languages_spoken" name="languages_spoken" placeholder="Languages spoken" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="Law School name">Law School name:</label>
                                    <input required id="Law School name" name="law_school_name" placeholder="Law school name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="Year Graduated">Year Graduated:</label>
                                    <select required name="year_graduated" id="year_graduated" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" >
                                        <option selected disabled hidden>Please select year graduated</option>
                                        @php $years = range(1960, strftime("%Y", time())); @endphp
                                        @foreach ($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="Admitted into law in AZ">Admitted into law in AZ?</label>
                                    <input required id="Admitted into law in AZ" name="admitted_into_law_in_az" placeholder="Admitted into law in AZ?" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="AZ State bar number">AZ State bar number:</label>
                                    <input required id="AZ State bar number" name="az_state_bar_number" placeholder="AZ State bar number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="Any special certifications">Any special certifications?</label>
                                    <input required id="Any special certifications" name="any_special_certifications" placeholder="Any special certifications" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <h5 class="font-accent">Areas of practice <br><small>(The areas of practice below are individually measured and not a collection among other attorneys working for the same firm)</small></h5>
                                <div class="card border-0 radius-10 pt-4 pb-4">
                                    <div class="card-body">
                                        <div class="container" id="dynamic-fields-container">
                                            <div class="dynamic-field mb-4">
                                                <div>
                                                    <label class="font-18 mb-2 area-of-practice-label" for="Area of practice">Area of practice 1:</label>
                                                    <input required name="area_of_practice[]" placeholder="Area of practice" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                                <div>
                                                    <label class="font-18 mb-2" for="Year started in this area">Year started in this area:</label>
                                                    <select required name="year_started_in_this_area[]" id="year_graduated" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" >
                                                        <option selected disabled hidden>Please select year started in this area</option>
                                                        @php $years = range(1980, strftime("%Y", time())); @endphp
                                                        @foreach ($years as $year)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="font-18 mb-2" for="Average no of cases handled per year">Average no of cases handled per year</label>
                                                    <input required name="average_no_of_cases_handled_per_year[]" placeholder="Average no of cases handled per year" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="numer">
                                                </div>
                                                <div class="mt-2 mb-1">
                                                    <button type="button" class="remove-field align-self-start btn bg-primary text-white py-2 px-5 font-20 radius-10" style="display: none;">x Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container text-end">
                                        <button type="button" id="add-field" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10">+ Add</button>
                                    </div>
                                </div>
                                <h5 class="font-accent">The information provided above is accurate and truthful. I also understand that the information above will be featured in my profile. I further understand that every lawyer at the firm needs to fill out a separate application.</h5>
                                {{-- <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div> --}}
                                <hr>
                                <div class="row">
                                    <div class="offset-md-2 col-md-8">
                                        <div class="parent">
                                            <label class="font-18 mb-2 w-100" for="sign">Signature of applicant</label>
                                            <div class="below">
                                                <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                                <input type="hidden" name="signature_data" id="hidden-signature-data" value="">
                                                <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                                <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                            </div>
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
                                <input id="step-1-next" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Next">
                            </div>
                        </div>
                        <div class="row" class="step" id="step-2" style="display: none;">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Contract Form</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="row mt-4">
                                <div class="offset-md-6 col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="imageUpload">
                                            <div class="card-body text-center circle background-primary">
                                                <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Image </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="videoUpload">
                                            <div class="card-body text-center">
                                                <i class="fa-solid fa-video accent-color-2 app-form-upload mb-2"></i>
                                                <input type='file' id="videoUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Video </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="fileUpload">
                                            <div class="card-body text-center">
                                                <i class="fa-solid fa-file accent-color-2 app-form-upload  mb-2"></i>
                                                <input type='file' id="fileUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Document </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div>
                                    <input required placeholder="Buyer Name" name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    {{-- <label class="font-18 mb-2" for="next-court-date">Buyer Name</label> --}}
                                    <input required placeholder="Buyer Name" id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Buyer Name</span>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms1" class="square-checkbox">
                                            <label for="terms1">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms2" class="square-checkbox">
                                            <label for="terms2">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms3" class="square-checkbox">
                                            <label for="terms3">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms4" class="square-checkbox">
                                            <label for="terms4">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                </div>
                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Description</span>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div class="col-md-6">
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>

                                <div class="container">
                                    <div class="row mt-2">
                                        <div class="card radius-20 border-0">
                                            <div class="card-body">
                                                <div id='calendar' class="mt-2 mb-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <label class="font-18 mb-2" for="next-court-date">Gender</label>
                                    <div class="row">
                                        <div class="agree-div">
                                            <input type="checkbox" id="Male" class="square-checkbox">
                                            <label for="Male">&nbsp; Male</label>
                                        </div>
                                        <div class="agree-div mt-3">
                                            <input type="checkbox" id="Female" class="square-checkbox">
                                            <label for="Female">&nbsp; Female</label>
                                        </div>
                                        <div class="agree-div mt-3">
                                            <input type="checkbox" id="No Preference" class="square-checkbox">
                                            <label for="No Preference">&nbsp; No Preference</label>
                                        </div>
                                    </div>
                                </div>

                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Terms & Conditions</span>
                                <div>
                                    <ol>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                    </ol>
                                </div>
                                <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div>
                                <div class="row col-md-6 col-sm-12">
                                    <label class="font-18 mb-2 w-100" for="Date">Date:</label>
                                    <input type="date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                </div>
                                {{-- <div class="parent">
                                    <label class="font-18 mb-2 w-100" for="sign">Please sign below: <small>(After sign please click on confirm)</small></label>
                                    <div class="below">
                                        <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                        <input type="hidden" name="signature_data" id="hidden-signature-data" value="">
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                    </div>
                                </div> --}}
                                <div class="parent">
                                    <label class="font-18 mb-2 w-100" for="sign">Signature of applicant</label>
                                    <div class="below">
                                        <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                        <input type="hidden" name="signature_data" id="hidden-signature-data" value="">
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <input class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 prev-button" type="button" value="Previous">
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <input class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Next">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" class="step" id="step-3" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Payment Details</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check "><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check "><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5">
                                <div class="container">
                                    <div class="row mt-4">
                                        <div class="offset-md-3 col-md-6">
                                            <img src="{{asset('images/stripe.png')}}" class="w-100" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="offset-md-4 col-md-4">
                                            <div class="social-login mt-4">
                                                <a href="#" class="btn button-accent btn-accent-secondary w-100 mt-2">
                                                    <span><img src="{{asset('images/svg/stripe.svg')}}" class="me-2 me-md-4" alt="Stripe"> <span class="d-none d-md-inline-block">Continue with</span> Stripe</span>
                                                    <span class="btn-arrow">
                                                        <i class="fa-solid fa-chevron-right text-white"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <h3 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Note</h3>
                                        <h4 class="font-primary">Card will not be charged until client approves attorney and has signed a contract.</h4>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <input class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 prev-button" type="button" value="Previous">
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <input class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Next">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" class="step" id="step-4" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Processing</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div class="card border-0 radius-10 pt-4 pb-4">
                                    <div class="card-body">
                                        <div class="container">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Profile Details</h2>
                                            <div class="row">
                                                <div class="col-md-9">
                                                <div class="row">
                                                        <p class="fs-5">Julia Grey</p>
                                                        <small class="small-text">Name</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">renata123@gmail.com</p>
                                                        <small class="small-text">Email</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">julia_grey</p>
                                                        <small class="small-text">Username</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">+88017123456789</p>
                                                        <small class="small-text">Phone Number</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">89, New York, USA 1217</p>
                                                        <small class="small-text">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="avatar-preview">
                                                        <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="https://adminlte.io/themes/AdminLTE/dist/img/user3-128x128.jpg" alt="User profile picture">
                                                        <h4 class="customer-name font-18 mt-2 fw-bold font-accent">Julia Grey</h4>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 radius-10 pt-4 pb-4">
                                    <div class="card-body">
                                        <div class="container">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Application Details</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p class="fs-5">Julia Grey</p>
                                                        <small class="small-text">Client-Name</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">renata123@gmail.com</p>
                                                        <small class="small-text">Clients DOB</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">julia_grey</p>
                                                        <small class="small-text">Preferred language</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">+88017123456789</p>
                                                        <small class="small-text">Court where the case is at</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">89, New York, USA 1217</p>
                                                        <small class="small-text">Case or citation number</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p class="fs-5">Julia Grey</p>
                                                        <small class="small-text">Charges (please name all of them)</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">renata123@gmail.com</p>
                                                        <small class="small-text">Next Court date</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">julia_grey</p>
                                                        <small class="small-text">Type of hearing</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">+88017123456789</p>
                                                        <small class="small-text">How many hearings have you had</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">89, New York, USA 1217</p>
                                                        <small class="small-text">List all prior criminal convictions</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row mt-4">
                                                        <p class="fs-5">89, New York, USA 1217</p>
                                                        <small class="small-text">Further Details</small>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 radius-10 pt-4 pb-4">
                                    <div class="card-body">
                                        <div class="container">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Attached Media</h2>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{asset('images/slide1.png')}}" alt="" class="w-100 mt-3 mb-3 form-image">
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="{{asset('images/slide2.png')}}" alt="" class="w-100 mt-3 mb-3 form-image">
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="{{asset('images/slide3.png')}}" alt="" class="w-100 mt-3 mb-3 form-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 radius-10 pt-4 pb-4">
                                    <div class="card-body">
                                        <div class="container">
                                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent mb-4">Card Details</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p class="fs-5">**** **** **** 5513</p>
                                                        <small class="small-text">Card number</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">12/24</p>
                                                        <small class="small-text">Expiry date</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">***</p>
                                                        <small class="small-text">CVC / CVV</small>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <p class="fs-5">Sam Dingo</p>
                                                        <small class="small-text">Name of card holder</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-center container text-white mt-5">
                                                        <div class="credit-card p-2 px-3 py-3">
                                                            <div class="d-flex justify-content-between align-items-center p-4"></div>
                                                            <span class="light">Card Number</span>
                                                            <div class=""><span class="mr-3">**** </span><span class="mr-3">**** </span><span class="mr-3">**** </span><span class="mr-2">5513</span></div>
                                                            <div class="d-flex justify-content-between card-details mt-3 mb-3">
                                                                <div class="d-flex flex-column"><span class="light">Card Holder</span><span>Sam Dingo</span></div>
                                                                <div class="d-flex flex-row">
                                                                    <div class="d-flex flex-column mr-3"><span class="light">Expired On</span><span>12/24</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-4">
                                                <div class="col-md-12 mt-2">
                                                    <div class="text-center">
                                                        <div class="row">
                                                            <small class="small-text mt-0">Customer's Bid</small>
                                                            <h3 class="font-primary mb-0">$500</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="submit-buttons d-flex justify-content-between flex-column gap-3 flex-md-row">
                                    <input id="step-2-next" class="btn btn-primary text-white py-2 px-5 font-20  prev-button radius-10" type="button" value="Previous">
                                    <input id="step-2-prev" class="btn btn-primary text-white py-2 px-5 font-20 next-button radius-10" type="button" value="Make an offer">
                                </div>
                            </div>
                        </div>
                        <div class="row" class="step" id="step-5" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Processing</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                        <div class="avatar-preview">
                                            <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="https://adminlte.io/themes/AdminLTE/dist/img/user3-128x128.jpg" alt="User profile picture">
                                            <h4 class="customer-name font-18 mt-2 fw-bold font-accent">Julia Grey</h4>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 pt-4">
                                        <div class="offset-md-2 col-md-8 text-center">
                                            <h3 class="font-accent lh-base">Application In Process.</h3>
                                        </div>
                                        <div class="offset-md-2 col-md-8 text-center mt-4">
                                            <h2 class="font-accent"><strong>Thank you</strong></h2>
                                        </div>
                                    </div>
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
@push('js')


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
            newField.find('input').val(''); // Clear the values in the cloned fields
            newField.find('.remove-field').show(); // Show the remove button
            newField.hide().appendTo('#dynamic-fields-container').slideDown(); // Append and slide down the cloned fields
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
    });
</script>


@endpush

