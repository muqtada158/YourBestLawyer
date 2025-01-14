@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Add Application')

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
                                    <label class="font-18 mb-2" for="client-name">Client's Name:</label>
                                    <input required name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="client-dob">Clients DOB:</label>
                                    <input required name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="preferred-language">Preferred Language:</label>
                                    <input required name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="court">Court where is the case is at:</label>
                                    <input required name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="case-number">Case or citation number:</label>
                                    <input required id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="charges">Charges (please name all of them):</label>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="next-court-date">Next Court date:</label>
                                    <input required id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearing-type">Type of hearing:</label>
                                    <input required id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearings-had">How many hearings have you had:</label>
                                    <input required id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">List all prior criminal convictions:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="further_details">Further Details:</label>
                                    <textarea id="further_details" name="further_details" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" style="height: 150px;" id="" rows="10"></textarea>
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
                                    <label class="font-18 mb-2" for="client-name">Client's Name:</label>
                                    <input required name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="client-dob">Clients DOB:</label>
                                    <input required name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="preferred-language">Preferred Language:</label>
                                    <input required name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="court">Court where is the case is at:</label>
                                    <input required name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="case-number">Case or citation number:</label>
                                    <input required id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="charges">Charges (please name all of them):</label>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="next-court-date">Next Court date:</label>
                                    <input required id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearing-type">Type of hearing:</label>
                                    <input required id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="hearings-had">How many hearings have you had:</label>
                                    <input required id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="prior-criminal-convictions">List all prior criminal convictions:</label>
                                    <input required id="prior-criminal-convictions" name="prior-criminal-convictions" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="further_details">Further Details:</label>
                                    <textarea id="further_details" name="further_details" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" style="height: 150px;" id="" rows="10"></textarea>
                                </div>
                                <div>
                                    <label class="font-18 mb-2" for="further_details">Attached Media:</label>
                                    <div class="card radius-20 border-0">
                                        <div class="card-body">
                                            <div class="container">
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
                                            <h3 class="font-accent lh-base">Your application has been authorized for attorneys to bid on the best possible match type.</h3>
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
