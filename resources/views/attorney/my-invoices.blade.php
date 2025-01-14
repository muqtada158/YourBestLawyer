@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Invoices')

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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">My YBL Invoices</h2>
                    <div class="container">

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="font-accent fw-bold py-3 px-3">Transactions</h4>
                                            </div>
                                        </div>
                                        <div class="container">
                                            @foreach ($getInvoice as $invoice)
                                            <div class="row mt-3">
                                                <div class="card border-card-transaction">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-2 text-center">
                                                                            <div class="icon-large">
                                                                                <i class="fa-solid fa-wallet" style="color: #b38e6a;"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="pt-2">
                                                                                <p>
                                                                                    <span class="accent-color-4">Invoice no # {{$invoice->invoice_no}}</span>
                                                                                    <br>
                                                                                    <span class="fw-bold">{{$invoice->getAttorney->getUserDetails->first_name}} {{$invoice->getAttorney->getUserDetails->last_name}}</span>
                                                                                    <br>
                                                                                    <span class="accent-color-4">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="offset-md-3 col-md-3">
                                                                    <div class="pt-2">
                                                                        <p class="fw-bold text-center mt-2">
                                                                            $ {{$invoice->amount}} |
                                                                            @if ($invoice->status == "Paid")
                                                                                <span class="text-success fw-bold">{{$invoice->status}}</span><br>
                                                                                <a href="{{isset($invoice->stripe_invoice_url) ? $invoice->stripe_invoice_url : '#' }}" target="__blank" class="btn-primary w-100 d-block text-center radius-10 py-2">Invoice</a>
                                                                            @else
                                                                                <span class="text-warning fw-bold">{{$invoice->status}}</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>


                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Pagination links -->
                                        <div class="pagination w-100">
                                            {{ $getInvoice->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
