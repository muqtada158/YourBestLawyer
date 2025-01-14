@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Schedule Appointment')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Schedule Appointment</h2>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 mt-4">
                            <form action="{{route('customer_schedule_appointment_store')}}" method="POST" enctype="multipart/form-data"> @csrf
                                <div class="container mb-4">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="case_sr_no">Case Sr No :</label>
                                            <select name="case_sr_no" id="case_sr_no" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                <option selected hidden disabled>Please select case sr no</option>
                                                @foreach ($cases as $case)
                                                    <option value="{{$case->sr_no}}">{{$case->sr_no}}</option>
                                                @endforeach
                                            </select>
                                            @error('case_sr_no')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="appointee">Appointee :</label>
                                            <input type="hidden" id="appointee_id" value="" name="attorney_id">
                                            <input placeholder="Appointee" readonly name="appointee" id="appointee" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                            @error('appointee')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="case_type">Case Type :</label>
                                            <input placeholder="Case Type" readonly name="case_type" id="case_type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                            @error('case_type')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="date">Date :</label>
                                            <input placeholder="Date" name="date" id="date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                            @error('date')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="time">Time :</label>
                                            <input placeholder="Time" name="time" id="time" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text" readonly>
                                            @error('time')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="font-18 mb-2" for="summary">Summary :</label>
                                            <textarea id="summary" placeholder="Summary" name="summary" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" style="height: 150px;" id="" rows="10"></textarea>
                                            @error('summary')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="offset-md-8 col-md-4 mt-2">
                                            <button type="submit" class="btn-primary d-block text-center w-100 p-1 mb-2 pt-3 pb-3 radius-10"  onclick="showLoader();"> Add Appointment</button>
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
@push('js')
<script>
    $(document).ready(function() {
        $('#case_sr_no').change(function() {
            var caseSrNo = $(this).val();
            var customerId = {{auth()->user()->id}};

            $.ajax({
                url: '{{ route("customer_initial_get_appointment_details") }}', // Adjust this to your actual route
                type: 'GET',
                data: {
                    case_sr_no: caseSrNo,
                    customer_id: customerId
                },
                success: function(response) {
                    if(response.success) {
                        $('#appointee_id').val(response.data.appointee_id);
                        $('#appointee').val(response.data.appointee);
                        $('#case_type').val(response.data.case_type);
                        // Populate other fields as needed
                    } else {
                        alert('Failed to fetch case details.');
                    }
                },
                error: function() {
                    alert('Error fetching case details.');
                }
            });
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script>
    $(function() {
        var today = new Date();
        today.setDate(today.getDate() + 1); // Add 1 day to today's date
        var oneHundredTwentyYearsAgo = new Date(today.getFullYear() - 120, today.getMonth(), today.getDate());

        $("#date").datepicker({
            dateFormat: 'mm-dd-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-120:c',
            minDate: today, // Set the minimum date to tomorrow
        });
        $("#time").timepicker({
            timeFormat: 'HH:mm:ss'
        });
    });
</script>
@endpush
