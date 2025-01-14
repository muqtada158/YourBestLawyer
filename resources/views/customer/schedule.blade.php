@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Schedule')

@section('content')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css">
<style>
    .fc-event {
        position: relative;
        display: block;
        font-size: .85em;
        line-height: 1.4;
        border-radius: 3px;
        text-align: center;
        border: 1px solid #b38e6a !important;
    }
</style>
@endpush

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
        </div>

        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section p-3 p-md-5 background-attorney">
                <div class="customer-portal-sidebar-section">
                    @include('layouts.sidebar-customer')

                </div>
                <div class="customer-portal-content py-3">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Schedule</h2>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('customer_schedule_appointment')}}" class="btn-primary w-100 d-block text-center p-1 mb-2 pt-3 pb-3 radius-10"> Schedule Appointment</a>
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

                        <h2 class="fw-bold font-20 mb-0 col-lg-6 font-accent mt-4 -mb-2">Upcoming Appointments</h2>
                        <div class="row mt-2">
                            @foreach ($schedules_upcoming as $schedule)
                                <div class="col-md-4 mt-4">
                                    <div class="card radius-20 border-0 bg-primary">
                                        <div class="card-body">
                                            <div class="row">
                                                <h3 class="font-20 font-accent text-white mb-4">Attorney # {{$schedule->getAttornies->getUserDetails->first_name}} {{$schedule->getAttornies->getUserDetails->last_name}}</h3>
                                                <h3 class="font-20 font-accent text-white mb-4">SR # {{$schedule->case_sr_no}}</h3>
                                                <p class="font-accent text-white">{{$schedule->date}} | {{$schedule->time}}</p><hr>
                                                <p class="font-accent text-white">Summary : {{$schedule->summary}}</p>
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
    </section>
</div>

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

        const myEvents = JSON.parse(localStorage.getItem('events')) || [
            @foreach ($schedules as $key => $schedule)
            {
                id: '{{$key}}',
                title: `{{$schedule->getAttornies->getUserDetails->first_name}} | SR #{{$schedule->case_sr_no}}`,
                start: '{{ \Carbon\Carbon::createFromFormat('m-d-Y', $schedule->date)->format('Y-m-d') }}T{{ $schedule->time }}',// Including time
                backgroundColor: '#b38e6a',
                allDay: true,
                editable: false,
            },
            @endforeach
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
