@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Invite Send')

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
                    <div class="row">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Send Invite</h2>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 mt-4">
                            <form action="#">
                                <div class="container mb-4">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="name">Name :</label>
                                            <input required name="name" id="name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="case_title">Case Title :</label>
                                            <input required name="case_title" id="case_title" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="category">Category :</label>
                                            <input required name="category" id="category" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="summary">Summary :</label>
                                            <textarea id="summary" name="summary" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" style="height: 150px;" id="" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="offset-md-8 col-md-4 mt-2">
                                            <button type="submit" class="btn-primary d-block text-center w-100 p-1 mb-2 pt-3 pb-3 radius-10"> Send Invite</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
