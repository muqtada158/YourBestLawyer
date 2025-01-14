@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Contract')

@section('content')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css">
@endpush

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
                    <form id="multi-step-form">
                        <div class="row" class="step" id="step-1">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Contract Form</h2>
                            <div class="row mt-4">
                                <div class="offset-md-6 col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="imageUpload">
                                            <div class="card-body text-center circle background-primary">
                                                <i class="fa-solid fa-camera accent-color-2 app-form-upload  mb-2"></i>
                                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Image </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="videoUpload">
                                            <div class="card-body text-center">
                                                <i class="fa-solid fa-video accent-color-2 app-form-upload mb-2"></i>
                                                <input type='file' id="videoUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Video </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="card radius-20 app-card">
                                        <label for="fileUpload">
                                            <div class="card-body text-center">
                                                <i class="fa-solid fa-file accent-color-2 app-form-upload  mb-2"></i>
                                                <input type='file' id="fileUpload" accept=".png, .jpg, .jpeg" class="d-none" />
                                                <h5 class="card-title font-accent"> Upload <br> Document </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 col-12 d-flex flex-column gap-4 ">
                                <div>
                                    <input required placeholder="Buyer Name" name="client-name" id="client-name" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="client-dob" id="client-dob" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="preferred-language" id="preferred-language" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" name="court" id="court" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="case-number" name="case-number" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    {{-- <label class="font-18 mb-2" for="next-court-date">Buyer Name</label> --}}
                                    <input required placeholder="Buyer Name" id="next-court-date" name="next-court-date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="hearing-type" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required placeholder="Buyer Name" id="hearings-had" name="hearings-had" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Buyer Name</span>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="yes" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="no" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <input required id="hearing-type" placeholder="note" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input required id="hearing-type" placeholder="Buyer Name" name="hearing-type" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms1" class="square-checkbox">
                                            <label for="terms1">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms2" class="square-checkbox">
                                            <label for="terms2">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms3" class="square-checkbox">
                                            <label for="terms3">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="agree-div">
                                            <input type="checkbox" id="terms4" class="square-checkbox">
                                            <label for="terms4">&nbsp; Lorem Ipsum</label>
                                        </div>
                                    </div>
                                </div>
                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Description</span>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div>
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="text">
                                </div>
                                <div class="col-md-6">
                                    <input required id="charges" name="charges" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium" type="date">
                                </div>

                                <div class="container">
                                    <div class="row mt-2">
                                        <div class="card radius-20 border-0">
                                            <div class="card-body">
                                                <div id='calendar' class="mt-2 mb-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <label class="font-18 mb-2" for="next-court-date">Gender</label>
                                    <div class="row">
                                        <div class="agree-div">
                                            <input type="checkbox" id="Male" class="square-checkbox">
                                            <label for="Male">&nbsp; Male</label>
                                        </div>
                                        <div class="agree-div mt-3">
                                            <input type="checkbox" id="Female" class="square-checkbox">
                                            <label for="Female">&nbsp; Female</label>
                                        </div>
                                        <div class="agree-div mt-3">
                                            <input type="checkbox" id="No Preference" class="square-checkbox">
                                            <label for="No Preference">&nbsp; No Preference</label>
                                        </div>
                                    </div>
                                </div>

                                <span class="btn bg-primary text-white py-2 px-5 font-20 next-button text-center w-100">Terms & Conditions</span>
                                <div>
                                    <ol>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                        <li>
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                                        </li>
                                    </ol>
                                </div>
                                <div class="agree-div">
                                    <input type="checkbox" id="terms" class="square-checkbox">
                                    <label for="terms">&nbsp; Agree the terms & conditions of YourBestLawyer...</label>
                                </div>
                                <div class="row col-md-6 col-sm-12">
                                    <label class="font-18 mb-2 w-100" for="Date">Date:</label>
                                    <input type="date" class="form-control-lg height-60 w-100 radius-20 input-border form-input form-input-medium">
                                </div>
                                <div class="parent">
                                    <label class="font-18 mb-2 w-100" for="sign">Please sign below: <small>(After sign please click on confirm)</small></label>
                                    <div class="below">
                                        <canvas class="sign form-control-lg height-60 w-100 radius-20"></canvas>
                                        <input type="hidden" name="signature_data" id="hidden-signature-data" value="">
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="signature-trash">X</button>
                                        <button class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10" id="confirm-signature">Confirm</button>
                                    </div>
                                </div>
                                <input class="align-self-end btn bg-primary text-white py-2 px-5 font-20 radius-10 next-button" type="button" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- Add modal -->

<div class="modal fade edit-form" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class="form-group">
                        <label for="event-title">Event name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="event-title" placeholder="Enter event name" required>
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start-date" placeholder="start-date" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End date - <small class="text-muted">Optional</small></label>
                        <input type="date" class="form-control" id="end-date" placeholder="end-date">
                    </div>
                    <div class="form-group">
                        <label for="event-color">Color</label>
                        <input type="color" class="form-control" id="event-color" value="#3788d8">
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success" id="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="delete-modal-body">
                Are you sure you want to delete the event?
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-sm" data-dismiss="modal" id="cancel-button">Cancel</button>
                <button type="button" class="btn btn-danger rounded-lg" id="delete-button">Delete</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        const canvas = document.querySelector(".sign");
        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        $('#signature-trash').click(function(e) {
            e.preventDefault();
            signaturePad.clear();
            $('#hidden-signature-data').val('');
        });

        $('#confirm-signature').click(function(e) {
            e.preventDefault();
            if ($('#confirm-signature').text() === 'Confirm') {
                // Disable signature area
                signaturePad.off();
                var signatureData = signaturePad.toDataURL();
                $('#hidden-signature-data').val(signatureData);
                $('#confirm-signature').text('Edit').removeClass('bg-primary').addClass('bg-secondary');
            } else {
                // Enable signature area
                signaturePad.on();
                signaturePad.clear();
                $('#hidden-signature-data').val('');
                $('#confirm-signature').text('Edit').removeClass('bg-secondary').addClass('bg-primary');
                $('#confirm-signature').text('Confirm');
            }
        });

        $('#save-signature').click(function() {
            var signatureData = signaturePad.toDataURL();
            $('#hidden-signature-data').val(signatureData);
            $('#signature-form').submit(); // Assuming your form has the ID 'signature-form'
        });
    </script>


<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuidv4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const myModal = new bootstrap.Modal(document.getElementById('form'));
        const dangerAlert = document.getElementById('danger-alert');
        const close = document.querySelector('.btn-close');




        const myEvents = JSON.parse(localStorage.getItem('events')) || [{
                id: uuidv4(),
                title: `Edit Me`,
                start: '2023-04-11',
                backgroundColor: 'red',
                allDay: false,
                editable: false,
            },
            {
                id: uuidv4(),
                title: `Delete me`,
                start: '2023-04-17',
                end: '2023-04-21',

                allDay: false,
                editable: false,
            },
        ];


        const calendar = new FullCalendar.Calendar(calendarEl, {
            customButtons: {
                // customButton: {
                //     text: 'Add Event',
                //     click: function() {
                //         myModal.show();
                //         const modalTitle = document.getElementById('modal-title');
                //         const submitButton = document.getElementById('submit-button');
                //         modalTitle.innerHTML = 'Add Event'
                //         submitButton.innerHTML = 'Add Event'
                //         submitButton.classList.remove('btn-primary');
                //         submitButton.classList.add('btn-success');



                //         close.addEventListener('click', () => {
                //             myModal.hide()
                //         })



                //     }
                // }
            },
            header: {
                center: 'customButton', // add your custom button here
                right: 'today, prev,next '
            },
            plugins: ['dayGrid', 'interaction'],
            allDay: false,
            editable: true,
            selectable: true,
            unselectAuto: false,
            displayEventTime: false,
            events: myEvents,
            eventRender: function(info) {
                info.el.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    let existingMenu = document.querySelector('.context-menu');
                    existingMenu && existingMenu.remove();
                    let menu = document.createElement('div');
                    menu.className = 'context-menu';
                    menu.innerHTML = `<ul>
    <li><i class="fas fa-edit"></i>Edit</li>
    <li><i class="fas fa-trash-alt"></i>Delete</li>
    </ul>`;

                    const eventIndex = myEvents.findIndex(event => event.id === info.event.id);


                    document.body.appendChild(menu);
                    menu.style.top = e.pageY + 'px';
                    menu.style.left = e.pageX + 'px';

                    // Edit context menu

                    menu.querySelector('li:first-child').addEventListener('click', function() {
                        menu.remove();

                        const editModal = new bootstrap.Modal(document.getElementById('form'));
                        const modalTitle = document.getElementById('modal-title');
                        const titleInput = document.getElementById('event-title');
                        const startDateInput = document.getElementById('start-date');
                        const endDateInput = document.getElementById('end-date');
                        const colorInput = document.getElementById('event-color');
                        const submitButton = document.getElementById('submit-button');
                        const cancelButton = document.getElementById('cancel-button');
                        modalTitle.innerHTML = 'Edit Event';
                        titleInput.value = info.event.title;
                        startDateInput.value = moment(info.event.start).format('YYYY-MM-DD');
                        endDateInput.value = moment(info.event.end, 'YYYY-MM-DD').subtract(1, 'day').format('YYYY-MM-DD');
                        colorInput.value = info.event.backgroundColor;
                        submitButton.innerHTML = 'Save Changes';





                        editModal.show();

                        submitButton.classList.remove('btn-success')
                        submitButton.classList.add('btn-primary')

                        // Edit button

                        submitButton.addEventListener('click', function() {
                            const updatedEvents = {
                                id: info.event.id,
                                title: titleInput.value,
                                start: startDateInput.value,
                                end: moment(endDateInput.value, 'YYYY-MM-DD').add(1, 'day').format('YYYY-MM-DD'),
                                backgroundColor: colorInput.value
                            }

                            if (updatedEvents.end <= updatedEvents.start) { // add if statement to check end date
                                dangerAlert.style.display = 'block';
                                return;
                            }

                            const eventIndex = myEvents.findIndex(event => event.id === updatedEvents.id);
                            myEvents.splice(eventIndex, 1, updatedEvents);

                            localStorage.setItem('events', JSON.stringify(myEvents));

                            // Update the event in the calendar
                            const calendarEvent = calendar.getEventById(info.event.id);
                            calendarEvent.setProp('title', updatedEvents.title);
                            calendarEvent.setStart(updatedEvents.start);
                            calendarEvent.setEnd(updatedEvents.end);
                            calendarEvent.setProp('backgroundColor', updatedEvents.backgroundColor);



                            editModal.hide();

                        })



                    });

                    // Delete menu
                    menu.querySelector('li:last-child').addEventListener('click', function() {
                        const deleteModal = new bootstrap.Modal(document.getElementById('delete-modal'));
                        const modalBody = document.getElementById('delete-modal-body');
                        const cancelModal = document.getElementById('cancel-button');
                        modalBody.innerHTML = `Are you sure you want to delete <b>"${info.event.title}"</b>`
                        deleteModal.show();

                        const deleteButton = document.getElementById('delete-button');
                        deleteButton.addEventListener('click', function() {
                            myEvents.splice(eventIndex, 1);
                            localStorage.setItem('events', JSON.stringify(myEvents));
                            calendar.getEventById(info.event.id).remove();
                            deleteModal.hide();
                            menu.remove();

                        });

                        cancelModal.addEventListener('click', function() {
                            deleteModal.hide();
                        })




                    });
                    document.addEventListener('click', function() {
                        menu.remove();
                    });
                });
            },

            eventDrop: function(info) {
                let myEvents = JSON.parse(localStorage.getItem('events')) || [];
                const eventIndex = myEvents.findIndex(event => event.id === info.event.id);
                const updatedEvent = {
                    ...myEvents[eventIndex],
                    id: info.event.id,
                    title: info.event.title,
                    start: moment(info.event.start).format('YYYY-MM-DD'),
                    end: moment(info.event.end).format('YYYY-MM-DD'),
                    backgroundColor: info.event.backgroundColor
                };
                myEvents.splice(eventIndex, 1, updatedEvent); // Replace old event data with updated event data
                localStorage.setItem('events', JSON.stringify(myEvents));
                console.log(updatedEvent);
            }

        });

        calendar.on('select', function(info) {

            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');
            startDateInput.value = info.startStr;
            const endDate = moment(info.endStr, 'YYYY-MM-DD').subtract(1, 'day').format('YYYY-MM-DD');
            endDateInput.value = endDate;
            if (startDateInput.value === endDate) {
                endDateInput.value = '';
            }
        });


        calendar.render();

        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // prevent default form submission

            // retrieve the form input values
            const title = document.querySelector('#event-title').value;
            const startDate = document.querySelector('#start-date').value;
            const endDate = document.querySelector('#end-date').value;
            const color = document.querySelector('#event-color').value;
            const endDateFormatted = moment(endDate, 'YYYY-MM-DD').add(1, 'day').format('YYYY-MM-DD');
            const eventId = uuidv4();

            console.log(eventId);

            if (endDateFormatted <= startDate) { // add if statement to check end date
                dangerAlert.style.display = 'block';
                return;
            }

            const newEvent = {
                id: eventId,
                title: title,
                start: startDate,
                end: endDateFormatted,
                allDay: false,
                backgroundColor: color
            };

            // add the new event to the myEvents array
            myEvents.push(newEvent);

            // render the new event on the calendar
            calendar.addEvent(newEvent);

            // save events to local storage
            localStorage.setItem('events', JSON.stringify(myEvents));

            myModal.hide();
            form.reset();
        });

        myModal._element.addEventListener('hide.bs.modal', function() {
            dangerAlert.style.display = 'none';
            form.reset();
        });

    });
</script>
@endpush
