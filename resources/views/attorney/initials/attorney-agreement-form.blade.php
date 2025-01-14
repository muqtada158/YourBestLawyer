@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attorney Agreement Form')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <form action="{{route('attorney_agreement_form_store')}}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row" class="step">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Agreement of service with YourBestLawyer.com</h2>
                            <div class="col-lg-6 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check active"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                                <div class="step-line step-line-small"></div>
                                <div class="circle-icon circle-icon-small step-check"><i class="fa-solid fa-check"></i></div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div>
                                    <h5 class="font-accent"><strong>Agreement</strong></h5>
                                    <label class="font-18 mb-2" for="attorney_name_agreement_1"> This Agreement is between YourBestLawyer.com LLC DBA Law Pros and</label>
                                    <input placeholder="Attorney Name" value="{{old('attorney_name_agreement_1')}}" name="attorney_name_agreement_1" id="attorney_name_agreement_1" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    @error('attorney_name_agreement_1')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <h5 class="font-accent">YourBestLawyer.com LLC agrees to grant Attorney access to its platform, which provides visibility of leads and enables participation in a reverse bidding process for those leads. In exchange for platform access, Attorney agrees to pay YourBestLawyer.com a monthly subscription fee of $165.00 (currently waived for early sign-ups for the first 3 months). Additionally, should the Attorney successfully secure a client through the platform, a separate flat fee per client will apply. (Please see our flat cost per lead below.). </h5>
                                <div>
                                    <label class="font-18 mb-2">Please select the areas of law below that you would like to receive leads from:</label>
                                    <div>
                                        <div class="col-md-12">
                                            @foreach ($laws as $law)
                                                <div class="row mb-4">
                                                    <div class="agree-div">
                                                        @if ($law->status == 'Enable')
                                                            <input type="checkbox" id="{{$law->title}}" name="law[]" value="{{$law->id}}" class="square-checkbox" {{ in_array($law->id, old('law', [])) ? 'checked' : '' }}>
                                                            <label for="{{$law->title}}">
                                                                &nbsp; {{$law->title}} <small>(Active)</small>
                                                            </label>
                                                        @elseif($law->status == 'Pending')
                                                            <input type="checkbox" id="{{$law->title}}" name="law[]" value="{{$law->id}}" class="square-checkbox" {{ in_array($law->id, old('law', [])) ? 'checked' : '' }}>
                                                            <label for="{{$law->title}}" class="text-grey">
                                                                &nbsp; {{$law->title}} <small>(Coming soon)</small>
                                                            </label>
                                                        @elseif($law->status == 'Disable')
                                                            <input type="checkbox" id="{{$law->title}}" name="law[]" value="{{$law->id}}" class="square-checkbox" {{ in_array($law->id, old('law', [])) ? 'checked' : '' }}>
                                                            <label for="{{$law->title}}" class="text-grey">
                                                                &nbsp; {{$law->title}} <small>(Coming soon)</small>
                                                            </label>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            @error('law')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <h5 class="font-accent">
                                    <input type="checkbox" id="malpractice_insurance" name="malpractice_insurance" value="1" class="square-checkbox" {{ old('malpractice_insurance') == 1 ? 'checked' : '' }}>
                                    <label for="malpractice_insurance">I have <strong>Malpractice insurance</strong> for the topics I selected above.</label>
                                    </h5>
                                    {{-- <input placeholder="Malpractice insurance" value="{{old('malpractice_insurance')}}"  id="malpractice_insurance" name="malpractice_insurance" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text"> --}}

                                    @error('malpractice_insurance')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <h5 class="font-accent">
                                    Attorney presently maintains errors and omissions insurance coverage for the areas of law selected above. <br>
                                    The information provided above is accurate and truthful.  I also understand that the information above will be featured in my profile.  I further understand that every lawyer at the firm needs to fill out a separate application.  I also understand that if the State Bar asks for this application, it will be available at their disposal.
                                </h5>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="font-accent">
                                            <input type="checkbox" id="termsAndConditions" name="termsAndConditions" value="1" class="square-checkbox" {{ old('termsAndConditions') == 1 ? 'checked' : '' }}>
                                            <label for="termsAndConditions">I Agree with YourBestLawyer.com <strong>Terms and conditions</strong>.</label>
                                        </h5>
                                        @error('termsAndConditions')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        <a href="{{route('attorney_terms_and_conditions')}}" target="__blank" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">View Terms & Conditions</a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="font-accent">
                                            <input type="checkbox" id="feeIntake" name="feeIntake" value="1" class="square-checkbox" {{ old('feeIntake') == 1 ? 'checked' : '' }}>
                                            <label for="feeIntake">I Agree with YourBestLawyer.com <strong>Flat cost per lead.</strong></label>
                                        </h5>
                                        @error('feeIntake')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        <a href="javascript:void()" id="fee_intake" target="__blank" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">View YourBestLawyer.com Flat Cost</a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="font-accent">
                                            <input type="checkbox" name="universal_client_attorney_agreement" id="universal_client_attorney_agreement" value="1" class="square-checkbox" {{ old('universal_client_attorney_agreement') == 1 ? 'checked' : '' }}>
                                            <label for="universal_client_attorney_agreement">I Agree with YourBestLawyer.com <strong>Universal Client-Attorney Agreements.</strong></label>
                                        </h5>
                                        @error('universal_client_attorney_agreement')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        <a href="javascript:void()" id="universal_client_attorney_agreements" target="__blank" class="btn bg-primary text-white py-2 px-5 font-20 radius-10">View YourBestLawyer.com Universal Client-Attorney Agreements</a>
                                    </div>
                                </div>
                                <div>
                                    <label class="font-18 mb-2">Date</label>
                                    <input placeholder="Date" readonly value="{{ \Carbon\Carbon::now()->format('m-d-Y') }}"  name="date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" readonly type="text">
                                    @error('date')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="offset-md-2 col-md-8">
                                        <div class="parent">
                                            <label class="font-18 mb-2 w-100" for="sign">Signature of applicant</label>
                                            <div class="below">
                                                <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                                <input type="hidden" name="signature" id="hidden-signature-data" value="">
                                                <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                                <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                            </div>
                                            @error('signature')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12 text-end">
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" type="submit" onclick="showLoader();" >Submit</button>
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
@push('js')


<script>
    $(document).ready(function() {
        // Function to update the labels
        function updateLabels() {
            $('.area-of-practice-label').each(function(index) {
                $(this).text('Area of practice ' + (index + 1) + ':');
            });
        }

        // Function to add a new set of fields
        $('#add-field').click(function() {
            var newField = $('.dynamic-field:first').clone(); // Clone the first set of fields
            newField.find('input, select').val(''); // Clear the values in the cloned fields

            // Populate with old values
            newField.find('input').each(function(index, element) {
                var oldVal = $('input[name="area_of_practice[' + index + ']"]').val();
                $(element).val(oldVal);
            });

            newField.find('select').each(function(index, element) {
                var oldVal = $('select[name="year_started_in_this_area[' + index + ']"]').val();
                $(element).val(oldVal);
            });

            newField.find('.remove-field').show(); // Show the remove button
            newField.hide().appendTo('#dynamic-fields-container').slideDown(); // Append and slide down the cloned fields
            updateLabels(); // Update the labels
        });

        // Function to remove a set of fields
        $(document).on('click', '.remove-field', function() {
            if ($('.dynamic-field').length > 1) {
                $(this).closest('.dynamic-field').slideUp(function() {
                    $(this).remove(); // Remove the closest .dynamic-field after sliding up
                    updateLabels(); // Update the labels
                });
            } else {
                alert("At least one set of fields is required."); // Ensure at least one set remains
            }
        });

        // Initial label update and show the first field
        updateLabels();
        $('.dynamic-field:first').show();
    });
</script>
<script>
    $(function() {
        var today = new Date();
        var oneHundredTwentyYearsAgo = new Date(today.getFullYear() - 120, today.getMonth(), today.getDate());
        // Calculate the date 21 years ago from today
        var twentyOneYearsAgo = new Date(today.getFullYear() - 21, today.getMonth(), today.getDate());

        $("#date").datepicker({
            dateFormat: 'mm-dd-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-120:c',
        });
        $("#in_service_since").datepicker({
            dateFormat: 'mm-dd-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-120:c',
        });
        $("#admitted_in_arizona_since").datepicker({
            dateFormat: 'mm-dd-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-120:c',
        });
        $("#date_of_birth").datepicker({
            dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: oneHundredTwentyYearsAgo.getFullYear() + ':' + twentyOneYearsAgo.getFullYear(), // Allow selection of dates from 120 years ago up to 21 years ago
                maxDate: twentyOneYearsAgo, // Disable all future dates beyond 21 years ago
                minDate: oneHundredTwentyYearsAgo // Disable all dates after 120 years ago
        });
    });

</script>

<script>
    $(document).ready(function() {
        // Function to update URLs based on selected checkboxes
        function updateUrls() {
            // Initialize an array to hold selected law ids
            var selectedLaws = [];

            // Loop through checked checkboxes and get their values (ids)
            $('input[name="law[]"]:checked').each(function() {
                selectedLaws.push($(this).val());
            });

            // Check if any laws are selected
            if (selectedLaws.length > 0) {
                // Generate the URL using the selected law ids
                var url = '{{ route("attorney_fee_intake", ":ids") }}';
                url = url.replace(':ids', selectedLaws.join(',')); // Replace placeholder with actual ids

                // Update the href attribute of the anchor
                $('#fee_intake').attr('href', url);

                // Generate the URL using the selected law ids
                var url2 = '{{ route("attorney_universal_client_attorney_agreements", ":ids2") }}';
                url2 = url2.replace(':ids2', selectedLaws.join(',')); // Replace placeholder with actual ids

                // Update the href attribute of the anchor
                $('#universal_client_attorney_agreements').attr('href', url2);
            } else {
                // Reset the href if no checkboxes are selected
                $('#fee_intake').attr('href', 'javascript:void(0)');
                $('#universal_client_attorney_agreements').attr('href', 'javascript:void(0)');
            }
        }

        // Listen for checkbox changes and call updateUrls on change
        $('input[name="law[]"]').change(updateUrls);

        // Trigger the function on page load in case checkboxes are already selected
        updateUrls();
    });
</script>



@endpush
