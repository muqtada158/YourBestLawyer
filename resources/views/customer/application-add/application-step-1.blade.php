@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Application Add')

@section('content')

    @push('css')
        <style>
            .hidden {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s ease-out;
            }

            .visible {
                max-height: 1000px;
                /* Adjust as necessary to fit the content */
                transition: max-height 0.5s ease-in;
            }
        </style>
    @endpush
    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">

                        @include('layouts.sidebar-customer')

                    </div>
                    <div class="customer-portal-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card radius-20 border-0">
                                        <div class="card-body p-4">
                                            <div class="customer-portal-content p-4">
                                                <form action="{{ route('customer_dashboard_intake_application_store_lego') }}"
                                                    method="POST" enctype="multipart/form-data" id="application-form"> @csrf
                                                    <div class="row" class="step" id="step-1">
                                                        <h2 class="fw-bold font-28 mb-0 col-lg-4 font-accent">Application
                                                            Form</h2>
                                                        <div
                                                            class="col-lg-8 text-end d-flex justify-content-center justify-content-lg-end float-start mt-3 mt-lg-0 align-items-center flex-wrap">
                                                            <div class="circle-icon circle-icon-small step-check active"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                            <div class="step-line step-line-small"></div>
                                                            <div class="circle-icon circle-icon-small step-check"><i
                                                                    class="fa-solid fa-check"></i></div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-md-4 mb-2">
                                                                <div class="card radius-20 app-card-for-image">
                                                                    <label for="imageUpload">
                                                                        <div
                                                                            class="card-body text-center circle background-primary">
                                                                            <i
                                                                                class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                                            <h5 class="card-title font-accent"> Upload <br>
                                                                                Image </h5>
                                                                            <input type='file' id="imageUpload" multiple
                                                                                class="image-picker" name="image[]" />
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <div class="card radius-20 app-card-for-image">
                                                                    <label for="videoUpload">
                                                                        <div
                                                                            class="card-body text-center circle background-primary">
                                                                            <i
                                                                                class="fa-solid fa-video accent-color-2 app-form-upload  mb-2"></i>
                                                                            <h5 class="card-title font-accent"> Upload <br>
                                                                                Video </h5>
                                                                            <input type='file' id="videoUpload" multiple
                                                                                class="image-picker" name="video[]" />
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <div class="card radius-20 app-card-for-image">
                                                                    <label for="fileUpload">
                                                                        <div class="card-body text-center">
                                                                            <i
                                                                                class="fa-solid fa-file accent-color-2 app-form-upload  mb-2"></i>
                                                                            <h5 class="card-title font-accent"> Upload <br>
                                                                                Document </h5>
                                                                            <input type='file' id="fileUpload" multiple
                                                                                class="doc-picker" name="document[]" />
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-5 col-12 d-flex flex-column gap-4 ">

                                                            <h5 class="font-accent">
                                                                <strong>Case Information</strong>
                                                            </h5>

                                                            <div>
                                                                <label class="font-18 mb-2" for="case">Case:</label>
                                                                <select name="case" id="case"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                    <option hidden disabled selected>Please select case
                                                                    </option>
                                                                    @foreach ($cases as $case)
                                                                        @if ($case->status == 'Enable')
                                                                            <option value="{{ $case->id }}"
                                                                                {{ old('case') == $case->id ? 'selected' : '' }}>
                                                                                {{ $case->title }} <small>(Active)</small></option>
                                                                        @else
                                                                            <option disabled>{{ $case->title }} <small>(Coming soon)</small></option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                @error('case')
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label class="font-18 mb-2" for="case_sub_cat">Case sub
                                                                    category:</label>
                                                                <select name="case_sub_cat" id="case_sub_cat"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                    <option hidden disabled selected>Please select case sub
                                                                        category</option>
                                                                </select>
                                                                @error('case_sub_cat')
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label class="font-18 mb-2" for="package">Package:</label>
                                                                <select name="package" id="package"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                                                    <option hidden disabled selected>Please select package
                                                                    </option>
                                                                </select>
                                                                @error('package')
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label class="font-18 mb-2" for="client-name">Place Your
                                                                    Bid:
                                                                    <small id="bid_in_percentage" style="display: none;">(Your bid should be in percentage. %)</small>
                                                                </label>
                                                                <input value="{{ old('bid') }}" name="bid"
                                                                    placeholder="Place your bid" id="bid"
                                                                    class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                    type="number">
                                                                @error('bid')
                                                                    <span class="text-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <hr>
                                                            <div id="same_person" class="hidden">

                                                                <h5 class="font-accent">
                                                                    <strong>Detailed Information</strong>
                                                                </h5>
                                                                <div>
                                                                    <label class="font-18 mb-2" for="client-name">Is the
                                                                        person filling out this form the one who needs legal
                                                                        services?</label>
                                                                    <div class="agree-div">
                                                                        <input type="radio" id="Yes"
                                                                            class="square-radio radius-20 py-2"
                                                                            name="person_accused" value="1"
                                                                            {{ old('person_accused') == '1' ? 'checked' : '' }}>
                                                                        <label for="Yes" class="mr-4">&nbsp;Yes
                                                                            &nbsp; &nbsp;</label>
                                                                            <br>

                                                                        <input type="radio" id="No"
                                                                            class="square-radio radius-20 py-2"
                                                                            name="person_accused" value="0"
                                                                            {{ old('person_accused') == '0' ? 'checked' : '' }}>
                                                                        <label for="No" class="mr-4">&nbsp;No
                                                                            &nbsp; &nbsp;</label>


                                                                        @error('person_accused')
                                                                            <span class="text-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if (old('person_accused') !== null && old('person_accused') == 0)
                                                                    <div class="container visible" id="accused">
                                                                    @else
                                                                        <div class="container hidden" id="accused">
                                                                @endif

                                                                <div>
                                                                    <label class="font-18 mb-2"
                                                                        for="convictee_name">Client Name:</label>
                                                                    <input name="convictee_name" id="convictee_name"
                                                                        placeholder="Client Name"
                                                                        class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                        type="text"
                                                                        value="{{ old('convictee_name') }}">
                                                                    @error('convictee_name')
                                                                        <span class="text-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <label class="font-18 mb-2"
                                                                        for="convictee_dob">Client DOB:</label>
                                                                    <input name="convictee_dob" id="convictee_dob"
                                                                        placeholder="Client DOB"
                                                                        class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                        readonly value="{{ old('convictee_dob') }}">
                                                                    @error('convictee_dob')
                                                                        <span class="text-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <label class="font-18 mb-2"
                                                                        for="relation_with_convictee">Relationship with
                                                                        client:</label>
                                                                    <input name="relation_with_convictee"
                                                                        id="relation_with_convictee"
                                                                        placeholder="Relationship with client"
                                                                        class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium"
                                                                        type="text"
                                                                        value="{{ old('relation_with_convictee') }}">
                                                                    @error('relation_with_convictee')
                                                                        <span class="text-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{-- <div>
                                                            <label class="font-18 mb-2" for="application">Application:</label>
                                                            <textarea name="application" id="application" cols="30" rows="10" class="form-control-lg w-100 radius-20 input-border form-input form-input-medium" style="height: 150px" placeholder="Describe your case in few lines">{{ old('application') }}</textarea>
                                                            @error('application')
                                                                <span class="text-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div> --}}
                                                        <div id="dynamic_form_div">
                                                            <p class="font-accent font-20 text-center"><strong>Please select any case to proceed.</strong></p>
                                                        </div>

                                                        <div id="button_div" class="hidden d-flex flex-column gap-4">
                                                            <h5 class="font-accent">
                                                                <strong>Note: </strong>
                                                                <label class="font-18 mb-2" for="asd">You have to submit
                                                                    a new application if you input wrong information.</label>
                                                            </h5>
                                                            <button class="align-self-end btn btn-primary text-white py-2 px-5 font-20 radius-10" id="submit-button"  type="submit">Submit</button>
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
                </div>

            </div>
    </div>
    </section>

    </div>

@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yesRadio = document.getElementById('Yes');
            const noRadio = document.getElementById('No');
            const accusedDiv = document.getElementById('accused');

            yesRadio.addEventListener('change', function() {
                if (this.checked) {
                    accusedDiv.classList.remove('visible');
                    accusedDiv.classList.add('hidden');
                }
            });

            noRadio.addEventListener('change', function() {
                if (this.checked) {
                    accusedDiv.classList.remove('hidden');
                    accusedDiv.classList.add('visible');
                }
            });
        });
    </script>
    <script>
        function setDatePicker(){
            var today = new Date();
            var oneHundredTwentyYearsAgo = new Date(today.getFullYear() - 120, today.getMonth(), today.getDate());
            var twentyOneYearsAgo = new Date(today.getFullYear() - 21, today.getMonth(), today.getDate());

            $("#convictee_dob").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: oneHundredTwentyYearsAgo.getFullYear() + ':' + twentyOneYearsAgo.getFullYear(),
                maxDate: twentyOneYearsAgo,
                minDate: oneHundredTwentyYearsAgo
            });
            $("#client_dob").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: oneHundredTwentyYearsAgo.getFullYear() + ':' + twentyOneYearsAgo.getFullYear(),
                maxDate: twentyOneYearsAgo,
                minDate: oneHundredTwentyYearsAgo
            });
            $("#next_court_hearing").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                minDate: today,
            });
            $("#marriage_date").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                maxDate: today,
            });
            $("#date_of_violation").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                maxDate: today,
            });
            $("#date_of_injury").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                maxDate: today,
            });
            $("#when_were_you_served").datepicker("destroy").datepicker({
                dateFormat: 'mm-dd-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-120:c',
                maxDate: today,
            });

        }

        function applyFieldCustomizations() {
            $('input[type="date"]').each(function() {
                $(this).attr('type', 'text')
                    .attr('readonly', true)
            });
        }

        function toggleNextFieldsBasedOnDropdown(dropdownName, showValue, count) {
            var dropdown = $(`select[name="${dropdownName}"]`);

            dropdown.on('change', function() {
                var selectedValue = $(this).val();

                // Find the closest .form-group container
                var formGroup = $(this).closest('.form-group');

                // Select the next 'count' .form-group divs
                var nextFields = formGroup.nextAll('.form-group').slice(0, count);

                if (selectedValue === showValue) {
                    // Show the next 'count' .form-group divs
                    nextFields.fadeIn('slow');
                } else {
                    // Hide the next 'count' .form-group divs
                    nextFields.fadeOut('slow');
                }
            });
        }


    </script>
    <script>
        $(document).ready(function() {
            // Get the old values
            var oldCaseId = "{{ old('case') }}";
            var oldCaseSubCatId = "{{ old('case_sub_cat') }}";
            var oldPackageId = "{{ old('package') }}";

            // Function to fetch subcategories
            function fetchSubCategories(caseId, selectedSubCatId = null) {
                if (caseId) {
                    $.ajax({
                        url: '{{ route('customer_get_law_sub_cats') }}/' + caseId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#case_sub_cat').empty();
                            $('#case_sub_cat').append(
                                '<option hidden disabled selected>Please select case sub category</option>'
                                );
                            if (data.law_sub_cat && data.law_sub_cat.length > 0) {
                                $.each(data.law_sub_cat, function(key, value) {
                                    $('#case_sub_cat').append('<option value="' + value.id +
                                        '"' + (selectedSubCatId == value.id ? ' selected' :
                                            '') + '>' + value.title + '</option>');
                                });
                            } else {
                                $('#case_sub_cat').append('<option disabled>No data found</option>');
                            }

                            // If there's a selected subcategory, fetch the packages
                            if (selectedSubCatId) {
                                fetchPackages(selectedSubCatId, oldPackageId);
                            }
                            var caseSubCatIdFromCookie = Cookies.get('cookie_case_sub_id');
                            if (caseSubCatIdFromCookie) {
                                $('#case_sub_cat').val(caseSubCatIdFromCookie).trigger('change');
                                console.log(caseSubCatIdFromCookie);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subcategories:', error);
                        }
                    });
                } else {
                    $('#case_sub_cat').empty();
                    $('#case_sub_cat').append(
                        '<option hidden disabled selected>Please select case sub category</option>');
                }
            }

            // Function to fetch packages
            function fetchPackages(subCatId, selectedPackageId = null) {
                if (subCatId) {
                    $.ajax({
                        url: '{{ route('customer_get_packages') }}/' + subCatId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#package').empty();
                            $('#package').append(
                                '<option hidden disabled selected>Please select package</option>');
                            if (data.packages && data.packages.length > 0) {
                                $.each(data.packages, function(key, value) {
                                    if (value.sub_cat_id == 18 || value.sub_cat_id ==
                                        19) { // if personal injury then change $ to %
                                        $('#package').append('<option value="' + value.id +
                                            '"' + (selectedPackageId == value.id ?
                                                ' selected' : '') + '>' + value.title +
                                            ' ( Min-Bid: ' + value.min_amount + '%' +
                                            ' , Max-Bid: ' + value.max_amount + '%' +
                                            ')</option>');
                                    } else {
                                        $('#package').append('<option value="' + value.id +
                                            '"' + (selectedPackageId == value.id ?
                                                ' selected' : '') + '>' + value.title +
                                            ' ( Min-Bid: $' + value.min_amount +
                                            ' , Max-Bid: $' + value.max_amount +
                                            ')</option>');
                                    }
                                });
                            } else {
                                $('#package').append('<option disabled>No data found</option>');
                            }
                            var packageIdFromCookie = Cookies.get('cookie_package_id');
                            // If a package ID is found in the cookie, set the select element to that value
                            if (packageIdFromCookie) {
                                $('#package').val(packageIdFromCookie).trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching packages:', error);
                        }
                    });
                } else {
                    $('#package').empty();
                    $('#package').append('<option hidden disabled selected>Please select package</option>');
                }
            }

            //calling dynamic forms
            function callDynamicForms(caseId) {
                if (caseId) {
                    $.ajax({
                        url: '{{ route('customer_dynamic_forms') }}/' + caseId,
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                var formFields = response.form.form;
                                var formHtml = generateFormHtml(formFields);
                                $('#dynamic_form_div').hide().html(formHtml).fadeIn('slow');
                                $('#button_div').removeClass('hidden');
                                $('#same_person').removeClass('hidden');
                                $('#same_person').hide().fadeIn('slow');

                                applyFieldCustomizations();
                                setDatePicker();

                                //toggling show hide of connected fields
                                toggleNextFieldsBasedOnDropdown('prior_dui_convictions_within_the_last_7_years', 'Yes',1);
                                toggleNextFieldsBasedOnDropdown('any_prior_misdemeanor_convictions_within_the_last_7_years', 'Yes',1);
                                toggleNextFieldsBasedOnDropdown('were_you_cited', 'Yes',1);
                                toggleNextFieldsBasedOnDropdown('did_you_notify', 'Yes',3);
                                toggleNextFieldsBasedOnDropdown('do_you_own_a_home', 'Yes',2);
                                toggleNextFieldsBasedOnDropdown('matter_type', 'Business',3);
                                toggleNextFieldsBasedOnDropdown('are_you_involved_in_legal_proceedings', 'Yes',1);
                                toggleNextFieldsBasedOnDropdown('do_you_have_outstanding_tax_obligations', 'Yes',1);
                                toggleNextFieldsBasedOnDropdown('are_you_facing_lawsuits', 'Yes',3);
                            }
                        },
                        error: function() {
                            Toast.fire({
                                icon: 'error',
                                title: 'Error loading form...'
                            })
                        }
                    });
                } else {
                    $('#dynamic_form_div').empty();
                }
            }

            //generate html forms
            function generateFormHtml(formData) {
                var html = '';

                formData.forEach(function(field) {
                    html += '<div class="form-group">'; // Add form-group class for styling

                    html += '<label class="font-18 mb-2 mt-2">' + field.label + (field.required ?
                        ' <span style="color:red">*</span>' : '') + '</label>'; // Add required mark

                    if (field.type === 'dropdown') {
                        html += '<select name="' + field.name +
                            '" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" ' + '>';
                        field.options.forEach(function(option) {
                            html += '<option value="' + option + '">' + option + '</option>';
                        });
                        html += '</select>';
                    } else if (field.type === 'text' || field.type === 'number') {
                        html += '<input type="' + field.type + '" name="' + field.name + '"placeholder="'+ field.placeholder +
                            '" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" ' + '>';
                    } else if (field.type === 'textarea') {
                        html += '<textarea name="' + field.name + '"placeholder="'+ field.placeholder +
                            '" class="form-control-lg height-150 w-100 radius-20 input-border form-input form-input-medium" ' + '></textarea>';
                    }
                     else if (field.type === 'date') {
                        html += '<input type="' + field.type + '" name="' + field.name + '" id="' + field.id + '"placeholder="'+ field.placeholder +
                            '" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" ' + '>';
                    }

                    html += '<br></div>'; // Close div
                });

                return html;
            }




            // Fetch subcategories if a case is selected
            if (oldCaseId) {
                fetchSubCategories(oldCaseId, oldCaseSubCatId);
            }

            // Fetch subcategories on case change
            $('#case').on('change', function() {
                var caseId = $(this).val();
                fetchSubCategories(caseId);
                callDynamicForms(caseId);
                if (caseId == 3) {
                    // Show the bid_in_percentage if caseId is 3
                    $('#bid_in_percentage').show();
                } else {
                    // Hide the bid_in_percentage otherwise
                    $('#bid_in_percentage').hide();
                }

            });

            // Fetch packages on case subcategory change
            $('#case_sub_cat').on('change', function() {
                var subCatId = $(this).val();
                fetchPackages(subCatId);
            });


            var caseIdFromCookie = Cookies.get('cookie_case_id');
            // If a case ID is found in the cookie, set the select element to that value
            if (caseIdFromCookie) {
                $('#case').val(caseIdFromCookie).trigger('change');
            }
        });


    </script>

    <script>
        //to validate case bid


    </script>

    <script>
        $(document).ready(function() {
            $('#application-form').on('submit', function(event) {
                showLoader();
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    method: 'POST',
                    data: new FormData(this), // Form data
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            // Redirect or show success message
                            window.location.href = response.redirectUrl;
                        } else {
                            hideLoader();
                            // Handle success responses if needed
                        }
                    },
                    error: function(xhr) {
                        hideLoader();
                        var errors = xhr.responseJSON.errors;
                        handleErrors(errors);
                    }
                });
            });

            function handleErrors(errors) {
    // Clear previous errors
    $('.error').remove();

    var firstErrorElement = null;

    // Loop through each error and display the message
    $.each(errors, function(field, message) {
        var fieldName = '[name="' + field + '"]';
        var errorElement;

        // Handle specific cases for file uploads (image.*, video.*, document.*)
        if (field.startsWith('image')) {
            errorElement = $('#imageUpload').after('<span class="error text-danger">' + message + '</span>');
            firstErrorElement = firstErrorElement || $('#imageUpload'); // Capture first error element for scrolling
        } else if (field.startsWith('video')) {
            errorElement = $('#videoUpload').after('<span class="error text-danger">' + message + '</span>');
            firstErrorElement = firstErrorElement || $('#videoUpload'); // Capture first error element for scrolling
        } else if (field.startsWith('document')) {
            errorElement = $('#fileUpload').after('<span class="error text-danger">' + message + '</span>');
            firstErrorElement = firstErrorElement || $('#fileUpload'); // Capture first error element for scrolling
        } else if (field === 'person_accused') {
            errorElement = $('.agree-div').after('<span class="error text-danger">' + message + '</span>');
            firstErrorElement = firstErrorElement || $('.agree-div'); // Capture first error element
        } else {
            // Handle regular fields
            errorElement = $(fieldName).after('<span class="error text-danger">' + message + '</span>');
            firstErrorElement = firstErrorElement || $(fieldName); // Capture first error element
        }
    });
    console.log(firstErrorElement);
    // Scroll to the first error element if it exists
    if (firstErrorElement && firstErrorElement.length) {
        $('html, body').animate({
            scrollTop: firstErrorElement.offset().top - 100 // Adjust -100 to add some padding from the top
        }, 500);
    }

    // Display toast notification
    Toast.fire({
        icon: 'error',
        title: 'There are some issues with your submission. Please check the highlighted fields and try again.'
    });
}


        });
    </script>

@endpush
