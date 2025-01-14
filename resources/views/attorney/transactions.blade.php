@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Transactions')
@push('css')
    <style>
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
            border: 0;
            border-radius: .25em;
            background: initial;
            background-color: #b38e6a !important;
            color: #fff;
            font-size: 1em;
        }
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-cancel) {
            border: #b38e6a 1px solid !important;
            border-radius: .25em;
            background: initial;
            background-color: #6e788105 !important;
            color: #b38e6a !important;
            font-size: 1em;
        }
    </style>
@endpush
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
                    <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Payment Transaction</h2>
                    <div class="container">

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="font-accent fw-bold py-3 px-3">Transactions</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="font-accent fw-bold py-3 px-3">Invoice No # {{$getInvoice->invoice_no}}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="font-accent fw-bold py-3 px-3">Case Sr No # {{$getInvoice->getCaseDetails->sr_no}}</h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="container">
                                            @foreach ($getTransactions as $key => $transactions)
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
                                                                                    <span class="fw-bold">{{$transactions->getCustomers->getUserDetails->first_name}} {{$transactions->getCustomers->getUserDetails->last_name}}</span>
                                                                                    <br>
                                                                                    @if ($getInvoice->installments == 'no')
                                                                                        <span class="accent-color-3 fst-italic">Full Payment</span>
                                                                                    @else
                                                                                        <span class="accent-color-3 fst-italic">{{ $key == 0 ? "Down Payment" : "Installment No # ". $key }}</span>
                                                                                    @endif
                                                                                    <br>
                                                                                    <span class="accent-color-4">{{ \Carbon\Carbon::parse($transactions->date_of_charge)->format('d M Y') }}</span>


                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <di class="offset-md-3 col-md-3">
                                                                    <div class="pt-2">
                                                                        <p class="fw-bold text-center mt-2">
                                                                            $ {{$transactions->amount}}</span> |
                                                                            @if ($transactions->status == "Success")
                                                                                <span class="text-success fw-bold">{{$transactions->status}}</span>
                                                                            @elseif ($transactions->status == "Failed")
                                                                                <span class="text-danger fw-bold">{{$transactions->status}}</span>
                                                                            @else
                                                                                <span class="text-warning fw-bold">{{$transactions->status}}</span>
                                                                            @endif
                                                                        </p>
                                                                        @if ($transactions->status == "Failed")
                                                                        <a href="{{route('attorney_attorneyManualTransactionApply',[$transactions->payment_plan_id , $transactions->id])}}" id="charge" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Charge</a>
                                                                        @endif
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
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
@push('js')
<script>
    $(function(){
        $(document).on('click','#charge',function(e){
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Charge Manually?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, charge it!',
                cancelButtonText: 'No, close',
            }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = link
                }
            })
        });
    });
</script>
@endpush
