@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies')

@section('content')

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
                    <div class="customer-portal-content py-3">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Hired Attornies</h2>
                        <div class="container">
                            @forelse ($hiredAttornies as $key => $attorney)
                                <div class="row mt-3">
                                    <div class="card card-border-bottom">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md-2 text-center">
                                                        <div class="icon-large">
                                                            <div class="customer-avatar text-center">
                                                                <img class="w-100"
                                                                    src="{{ asset($attorney->getAttornies->getUserDetails->image) }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 border-box-left">
                                                        <div class="pt-2">
                                                            <p class="font-accent">
                                                                <span
                                                                    class="font-20 fw-bold">{{ $attorney->getAttornies->getUserDetails->first_name }}
                                                                    {{ $attorney->getAttornies->getUserDetails->last_name }}</span>
                                                                <br>
                                                                <small class="accent-color-3">SR #
                                                                    {{ $attorney->getCaseDetail->sr_no }}</small>
                                                                <br>
                                                                <span
                                                                    class="font-14">{{ truncate_text($attorney->getAttornies->getUserDetails->bio) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center xy-center">
                                                        <div class="row xy-center">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="rating-box">
                                                                        <div class="rating-container">
                                                                            <input disabled type="radio" name="rating{{$key}}" value="5"
                                                                                id="star-{{$key}}5" {{attorneyRatings($attorney->getAttornies->id) == 5 ? 'checked' : ''}}> <label for="star-{{$key}}5" title="Ratings : {{attorneyRatings($attorney->getAttornies->id)}}">&#9733;</label>

                                                                            <input disabled type="radio" name="rating{{$key}}" value="4"
                                                                                id="star-{{$key}}4" {{attorneyRatings($attorney->getAttornies->id) == 4 ? 'checked' : ''}}> <label for="star-{{$key}}4" title="Ratings : {{attorneyRatings($attorney->getAttornies->id)}}">&#9733;</label>

                                                                            <input disabled type="radio" name="rating{{$key}}" value="3"
                                                                                id="star-{{$key}}3" {{attorneyRatings($attorney->getAttornies->id) == 3 ? 'checked' : ''}}> <label for="star-{{$key}}3" title="Ratings : {{attorneyRatings($attorney->getAttornies->id)}}">&#9733;</label>

                                                                            <input disabled type="radio" name="rating{{$key}}" value="2"
                                                                                id="star-{{$key}}2" {{attorneyRatings($attorney->getAttornies->id) == 2 ? 'checked' : ''}}> <label for="star-{{$key}}2" title="Ratings : {{attorneyRatings($attorney->getAttornies->id)}}">&#9733;</label>

                                                                            <input disabled type="radio" name="rating{{$key}}" value="1"
                                                                                id="star-{{$key}}1" {{attorneyRatings($attorney->getAttornies->id) == 1 ? 'checked' : ''}}> <label for="star-{{$key}}1" title="Ratings : {{attorneyRatings($attorney->getAttornies->id)}}">&#9733;</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="fw-bold">$
                                                                    {{ $attorney->caseAttorneyBid->attorney_bid }}</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <a href="{{ route('customer_attornies_details', [$attorney->id]) }}"
                                                                    class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10">
                                                                    View Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="row mt-3">
                                    <div class="card card-border-bottom">
                                        <div class="card-body">
                                            <div class="container text-center">
                                                <p>No Attornies Found...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Pagination links -->
                                    <div class="pagination w-100">
                                        {{ $hiredAttornies->links() }}
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
