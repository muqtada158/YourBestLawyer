@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Add Application')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form id="multi-step-form">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Application Form</h2>
                            <div class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
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
                                <input id="step-1-next" class="align-self-end btn btn-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Next">
                            </div>
                        </div>
                        <div class="row" class="step" id="step-2" style="display: none;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Payment Details</h2>
                            <div class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div class="container">
                                            <div class="row mt-4">
                                                <div class="col-md-4">
                                                    <img src="{{asset('images/visa-card.png')}}" class="w-100" alt="">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="card border-0 radius-20 mt-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            {{-- <div class="col-md-2">
                                                                <img src="{{asset('images/svg/Mastercard-Logo.svg')}}" class="w-100" alt="">
                                                            </div> --}}
                                                            <div class="col-md-10">
                                                                <h2 class="font-primary">Visa Ending in 2050</h2>
                                                                <h3 class="font-primary">Expiry 06/2050</h3>
                                                                <h3 class="font-primary">****</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="row mt-4">
                                                        <div class="col-sm-12">
                                                            <label class="font-18 mb-2" for="client-name">Place Your Bid:</label>
                                                            <input required name="bid" placeholder="Place your bid" id="bid" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-sm-12">
                                                            <label class="font-18 mb-2" for="client-name">Card Holder Name:</label>
                                                            <input required name="card-holder" placeholder="Card holder name" id="credit-card" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-sm-12">
                                                            <label class="font-18 mb-2" for="client-name">Card Number:</label>
                                                            <input required name="credit-card" placeholder="Card number" id="credit-card" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="client-name">Expiry:</label>
                                                            <input required name="client-name" placeholder="Expiry Date" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="font-18 mb-2" for="client-name">CVC / CVV:</label>
                                                            <input required name="client-name" placeholder="CVC / CVV" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <h3 class="font-primary mt-4">Choose Other Payment Methods</h3>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="offset-md-2 col-md-8">
                                                            <div class="social-login mt-4">
                                                                <a href="#" class="btn button-accent btn-accent-secondary w-100 mt-2">
                                                                    <span><img src="{{asset('images/svg/gpay.svg')}}" class="me-2 me-md-4" alt="Google Logo"> <span class="d-none d-md-inline-block">Continue with</span> Google Pay</span>
                                                                    <span class="btn-arrow">
                                                                        <i class="fa-solid fa-chevron-right text-white"></i>
                                                                    </span>
                                                                </a>
                                                                <a href="#" class="btn button-accent btn-accent-secondary w-100 mt-2">
                                                                    <span><img src="{{asset('images/svg/apay.svg')}}" class="me-2 me-md-4" alt="Google Logo"> <span class="d-none d-md-inline-block">Continue with</span> Apple Pay</span>
                                                                    <span class="btn-arrow">
                                                                        <i class="fa-solid fa-chevron-right text-white"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <h3 class="font-primary mt-2">Note</h3>
                                                <h4 class="font-primary mt-2">Card will not be charged until client approves attorney and has signed  a contract.</h4>
                                            </div>
                                </div>
                                <div class="submit-buttons d-flex justify-content-between flex-column gap-3 flex-md-row">
                                    <input id="step-2-next" class="btn  btn-primary text-white py-2 px-5 font-20  prev-button radius-10" type="button" value="Previous">
                                    <input id="step-2-prev" class="btn  btn-primary text-white py-2 px-5 font-20 next-button radius-10" type="button" value="Next">
                                </div>
                            </div>
                        </div>
                        <div class="row" class="step" id="step-3" style="display: none ;" >
                            <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Preview</h2>
                            <div class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
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
                                                            <small class="small-text mt-0">Your Bid</small>
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
                                            <h3 class="font-accent lh-base">Application in progress.</h3>
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
