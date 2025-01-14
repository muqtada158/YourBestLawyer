@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Payment Transactions')

@section('content')
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
        div:where(.swal2-container) input:where(.swal2-input), div:where(.swal2-container) input:where(.swal2-file), div:where(.swal2-container) textarea:where(.swal2-textarea) {
            box-sizing: border-box;
            width: auto;
            transition: border-color .1s, box-shadow .1s;
            border: 1px solid #b38e6a !important;
            border-radius: 20px !important;
            background: rgba(0, 0, 0, 0);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px rgba(0, 0, 0, 0);
            color: inherit;
            font-size: 1.125em;
        }
        div:where(.swal2-container) input:where(.swal2-input):focus, div:where(.swal2-container) input:where(.swal2-file):focus, div:where(.swal2-container) textarea:where(.swal2-textarea):focus {
            border: 1px solid #b38e6a5c !important;
            outline: none;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px #b38e6a5c !important;
        }
        div:where(.swal2-container) h2:where(.swal2-title) {
            font-family: 'Poppins', serif !important;
            color: black !important;
        }
    </style>
@endpush
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
                                    <div class="card-body payment-transaction-banner radius-20 border-0">
                                        <div class="container">
                                            <div class="row mb-4 mt-4">
                                                <div class="col-md-8">
                                                    <h4 class="text-white font-accent fw-bold">Total Charged Amount</h4>
                                                    <h4 class="text-white font-accent fw-bold">${{number_format($total_charged_amount, 2, '.', ',')}}</h4>
                                                </div>
                                            </div>
                                            <div class="row mb-4 mt-4">
                                                <div class="col-md-8">
                                                    <h4 class="text-white font-accent fw-bold">Total YourBestLawyer.com Fee Collected</h4>
                                                    <h4 class="text-white font-accent fw-bold">${{number_format($total_ybl_fee_collected, 2, '.', ',')}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <div class="row text-center">
                                            {{-- <div class="col-md-6 py-2">
                                                <button id="feeButton" class="btn-primary w-100 d-block text-center radius-10 py-2">Update YBL Fee</button>
                                            </div> --}}
                                            <div class="offset-md-4 col-md-4 py-2">
                                                <a href="{{route('admin_attorney_invoices')}}" class="btn-primary w-100 d-block text-center radius-10 py-2">Go to attorney invoices</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <h4 class="font-accent fw-bold py-3 px-3">Customer to attorney payment History</h4>
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
                                                                                    <span class="fw-bold">Invoice No #</span> {{$invoice->invoice_no}}
                                                                                    <br>
                                                                                    <span class="accent-color "> <span class="fw-bold">Case Sr No #</span> {{$invoice->getCaseDetails->sr_no}}</span>
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
                                                                            <span class="accent-color-4 ">{{$invoice->status}}</span>
                                                                            <br>
                                                                            ${{$invoice->total_amount}} | <span class="accent-color-2 ">{{$invoice->payment_status}}</span>
                                                                        </p>
                                                                        <a href="{{route('admin_transactions',[$invoice->id])}}" class="btn-primary w-100 d-block text-center radius-10"> View</a>
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
    </section>

</div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#feeButton').click(function() {
            Swal.fire({
                title: 'Enter YBL Fee',
                input: 'number',
                inputLabel: 'Fee Percentage',
                inputValue: {{yblFee() * 100}},
                inputPlaceholder: 'Enter fee percentage',
                showCancelButton: true,
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                preConfirm: (fee) => {
                    return $.ajax({
                        url: '{{route("admin_updateYblFee")}}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ybl_fee: fee
                        },
                        success: function(response) {
                            Swal.fire({
                                    title: 'Success!',
                                    text: 'YBL fee updated successfully.',
                                    icon: 'success'
                            }).then(() => {
                                location.reload(); // Refresh the page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update the fee.',
                                icon: 'error'
                            });
                        }
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });
    });
</script>
@endpush
