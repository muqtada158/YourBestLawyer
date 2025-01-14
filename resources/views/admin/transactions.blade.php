@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Transactions')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Super-Admin Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-superadmin')
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
                                                                                    <span class="fw-bold">{{$transactions->getAttornies->getUserDetails->first_name}} {{$transactions->getAttornies->getUserDetails->last_name}}</span>
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
                                                                                <span class="text-success fw-bold">{{$transactions->status}}</span><br>
                                                                                <input type="hidden" id="hiddenValue" value="{{$transactions->stripe_charge_id == null ? "Payment id not found" : $transactions->stripe_charge_id}}">
                                                                                <button id="copyButton" class="btn-primary w-100 d-block text-center radius-10">Copy payment id</button>
                                                                            @elseif ($transactions->status == "Failed")
                                                                                <span class="text-danger fw-bold">{{$transactions->status}}</span>
                                                                            @else
                                                                                <span class="text-warning fw-bold">{{$transactions->status}}</span>
                                                                            @endif

                                                                        </p>
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
    $(document).ready(function() {
            $('#copyButton').click(function() {
                // Get the hidden value
                var hiddenValue = $('#hiddenValue').val();

                // Create a temporary textarea to hold the hidden value
                var $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(hiddenValue).select();

                // Copy the value to the clipboard
                document.execCommand('copy');

                // Remove the temporary textarea
                $temp.remove();

                // Optional: Alert or inform the user using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Payment id copied successfully.',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        });
</script>
@endpush
