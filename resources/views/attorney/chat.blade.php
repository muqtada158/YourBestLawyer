@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Chat')

@push('css')
    <style>
        .card.border-0:hover {
            background-color: #b0907040;
        }
        .bg-danger {
            background-color: #b29171 !important;
        }
    </style>
@endpush

@section('content')

    <div id="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" id="event" value="App\Events\MessageSent">

        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-attorney')
                    </div>
                    <div class="customer-portal-content py-3">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Chat Conversations</h2>
                        <div class="container mt-4 pb-4">



                                @forelse ($converse as $conversation)
                                @if ($conversation['lastMessage'] !== null)
                                    <div class="row mt-2">
                                        <a href="{{ route('attorney_messages', [$conversation['customer']->id]) }}">
                                            <div class="col-md-12">
                                                <div class="card border-0">
                                                    <div class="row">
                                                        <div class="col-md-2 text-center mt-2 mb-2">
                                                            <div class="icon-large">
                                                                <div class="text-center">
                                                                    <img class="message-user-icon"
                                                                        src="{{ asset($conversation['customer']->getUserDetails->image) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="pt-2">
                                                                <p class="font-accent">
                                                                    <span
                                                                        class="font-20 fw-bold accent-color-2">{{ $conversation['customer']->getUserDetails->first_name . ' ' . $conversation['customer']->getUserDetails->last_name }}</span>
                                                                    <br>
                                                                    <small
                                                                        class="accent-color-3">{!! truncate_text(
                                                                            $conversation['lastMessage']->message == ' '
                                                                                ? '<i class="fa-solid fa-paperclip"></i> Attachments'
                                                                                : $conversation['lastMessage']->message,
                                                                            60,
                                                                        ) !!}</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center xy-center">
                                                            <div class="row xy-center accent-color-3">

                                                                @if ($conversation['unreadCount'] > 0)
                                                                    <span
                                                                        class="badge bg-danger w-50">{{ $conversation['unreadCount'] }}</span>
                                                                @endif
                                                                {{ \Carbon\Carbon::parse($conversation['lastMessage']->created_at)->diffForHumans() }}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                    @endif
                                @empty
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="card border-0">
                                                <div class="row">
                                                    <p class="font-accent">No Coversations Found...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse


                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
