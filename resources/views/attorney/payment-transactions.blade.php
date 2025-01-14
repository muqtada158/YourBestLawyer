@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Payment Transactions')

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
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Payment Transaction</h2>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('attorney_attorneyInvoices')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> My YBL Invoices</a>
                        </div>
                    </div>
                    <div class="container">

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">

                                    <div class="card-body">
                                        <h4 class="font-accent fw-bold py-3 px-3">Customer Invoices</h4>
                                        <div class="container">
                                            @foreach ($getInvoices as $invoice)
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
                                                                                    Invoice No # {{$invoice->invoice_no}}
                                                                                    <br>
                                                                                    <span class="accent-color ">Case Sr No # {{$invoice->getCaseDetails->sr_no}}</span>
                                                                                    <br>
                                                                                    <span class="accent-color-4">{{ \Carbon\Carbon::parse($invoice->created_at)->format('H:i M d Y') }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <di class="offset-md-3 col-md-3">
                                                                    <div class="pt-2">
                                                                        <p class="fw-bold text-center">
                                                                            <span class="accent-color-2 ">{{$invoice->status}}</span>
                                                                            <br>
                                                                            ${{$invoice->total_amount}} | <span class="accent-color-2 ">{{$invoice->payment_status}}</span>
                                                                        </p>
                                                                        <a href="{{route('attorney_transactions',[$invoice->id])}}" class="btn-primary w-100 d-block text-center radius-10"> View</a>
                                                                    </div>
                                                                </di>
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
                                            {{ $getInvoices->links() }}
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
