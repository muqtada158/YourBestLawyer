@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Add Application')

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
                    <form id="multi-step-form">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Form</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
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
                                    <label class="font-18 mb-2" for="client-name">Name of applicant:</label>
                                    <input required name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="client-dob">Name of firm you work for:</label>
                                    <input required name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="preferred-language">Do you own this firm? Y or N If no, who owns this law firm:</label>
                                    <input required name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="court">How long have you been in service to the public?</label>
                                    <input required name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="case-number">Address of business location:</label>
                                    <input required id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="charges">Email:</label>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="next-court-date">Phone:</label>
                                    <input required id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearing-type">Languages spoken:</label>
                                    <input required id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearings-had">Law School name:</label>
                                    <input required id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year Graduated:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Admitted into law in AZ?</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">AZ State bar number:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Any special certifications?</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Areas of practice (the areas of practice below are individually measured and not a collection among other attorneys working for the same firm):</label>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 1:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 2:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 3:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 4:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">The information provided above is accurate and truthful. I also understand that the information above will be featured in my profile. I further understand that every lawyer at the firm needs to fill out a separate application.</label>
                                </div>
                                {{-- <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div> --}}
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
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
                                    </div>
                                </div>
                                <input id="step-1-next" class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Next">
                            </div>
                        </div>
                        <div class="row" class="step" id="step-2" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Modify Or Edit Your Entry</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div>
                                    <label class="font-18 mb-2" for="client-name">Name of applicant:</label>
                                    <input required name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="client-dob">Name of firm you work for:</label>
                                    <input required name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="preferred-language">Do you own this firm? Y or N If no, who owns this law firm:</label>
                                    <input required name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="court">How long have you been in service to the public?</label>
                                    <input required name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="case-number">Address of business location:</label>
                                    <input required id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="charges">Email:</label>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="next-court-date">Phone:</label>
                                    <input required id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearing-type">Languages spoken:</label>
                                    <input required id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearings-had">Law School name:</label>
                                    <input required id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year Graduated:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Admitted into law in AZ?</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">AZ State bar number:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Any special certifications?</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Areas of practice (the areas of practice below are individually measured and not a collection among other attorneys working for the same firm):</label>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 1:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 2:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 3:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Area of practice 4:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Year started in this area:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">Average # of cases handled per</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">The information provided above is accurate and truthful. I also understand that the information above will be featured in my profile. I further understand that every lawyer at the firm needs to fill out a separate application.</label>
                                </div>
                                {{-- <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div> --}}
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
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
                                    </div>
                                </div>
                                <div class="submit-buttons d-flex justify-content-between flex-column gap-3 flex-md-row">
                                    <input id="step-2-next" class="btn bg-primary text-white py-2 px-5 font-20  prev-button radius-10" type="button" value="Previous">
                                    <input id="step-2-prev" class="btn bg-primary text-white py-2 px-5 font-20 next-button radius-10" type="button" value="Next">
                                </div>
                            </div>
                        </div>

                        <div class="row" class="step" id="step-3" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Application Processing</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
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
                                            <h3 class="font-accent lh-base">Registration In Process.</h3>
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


