@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Add Payment Transactions')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Deposit Payment</h2>
                    <div class="card border-0 radius-20 mt-4">
                        <div class="card-body">
                            <div class="container">
                                <form action="#">
                                    <div class="row mt-4">
                                        <div class="col-md-12 font-accent">
                                            <ul class="deposit-list">
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p>Desired Amount I want to pay</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="radio" class="square-radio" name="payment_type" id="">
                                                        </div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p>Paid A Full Payment Plan</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="radio" class="square-radio" name="payment_type" id="">
                                                        </div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p>Down Payment</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="radio" class="square-radio" name="payment_type" id="">
                                                        </div>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p>Monthly Payment</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="radio" class="square-radio" name="payment_type" id="">
                                                        </div>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <input required name="credit-card" placeholder="Credit-card number" id="credit-card" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-4">
                                                    <input required name="client-name" placeholder="Expiry Date" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                                <div class="col-sm-8">
                                                    <input required name="client-name" placeholder="CVC / CVV" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <input required name="client-name" placeholder="Name of card holder" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-4">
                                                    <input required name="client-name" placeholder="Case Id" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                                <div class="col-sm-8">
                                                    <input required name="client-name" placeholder="Attorney name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <input required name="client-name" placeholder="Custom price" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <button class="btn bg-primary text-white py-2 px-5 font-20  prev-button radius-10">Submit</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
