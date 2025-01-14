@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Schedule')

@section('content')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css">
@endpush

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Schedule</h2>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('customer_initial_schedule_appointment')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Schedule Appointment</a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row mt-2">
                            <div class="card radius-20 border-0">
                                <div class="card-body">
                                    <div id='calendar' class="mt-2 mb-2"></div>
                                </div>
                            </div>
                        </div>

                        {{-- <h2 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4 -mb-2">Case Details</h2>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="card radius-20 border-0 bg-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <h3 class="font-20 font-accent text-white mb-4">Case Name</h3>
                                            <p class="font-accent text-white mb-0">30 Minutes</p>
                                            <p class="font-accent text-white">Date</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card radius-20 border-0 bg-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <h3 class="font-20 font-accent text-white mb-4">Case Name</h3>
                                            <p class="font-accent text-white mb-0">30 Minutes</p>
                                            <p class="font-accent text-white">Date</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card radius-20 border-0 bg-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <h3 class="font-20 font-accent text-white mb-4">Case Name</h3>
                                            <p class="font-accent text-white mb-0">30 Minutes</p>
                                            <p class="font-accent text-white">Date</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuidv4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const myEvents = JSON.parse(localStorage.getItem('events')) || [{
                id: uuidv4(),
                title: ``,
                start: '2024-07-13T10:00:00', // Including time
                end: '2024-07-13T11:00:00', // Including time
                backgroundColor: '#fffff',
                allDay: true,
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
            plugins: ['dayGrid', 'interaction'],
            events: myEvents,
            editable: true,
            droppable: true,
        });

        calendar.render();
    });
</script>
@endpush
