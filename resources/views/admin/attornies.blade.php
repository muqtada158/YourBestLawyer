@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Attornies')

@section('content')

    <div id="content">


        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Super-Admin Portal</h2>
            </div>

            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-superadmin')
                    </div>
                    <div class="customer-portal-content py-3">
                        <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">All Attornies</h2>
                        <div class="container">
                            @foreach ($attornies as $key => $attorney)
                                <div class="row mt-4">
                                    <div class="card card-border-bottom radius-20">
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col-md-2 text-center">
                                                    <div class="icon-large">
                                                        <div class="customer-avatar text-center">
                                                            <img class="w-100"
                                                                src="{{ isset($attorney->getUserDetails->image) ? asset($attorney->getUserDetails->image) : asset('images/user-dummy.jpg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 border-box-left">
                                                    <div class="pt-0">
                                                        <div class="row">
                                                            <div class="col-sm-6 pt-2">
                                                                <span
                                                                    class="font-20 fw-bold ">{{ isset($attorney->getUserDetails->first_name) ? ucfirst($attorney->getUserDetails->first_name) : $attorney->user_name }}
                                                                    {{ isset($attorney->getUserDetails->last_name) ? ucfirst($attorney->getUserDetails->last_name) : '' }}</span>
                                                                    <br>
                                                                        <small class="accent-color-3">{{ isset($attorney->email) ? $attorney->email : '' }}</small>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="rating-box">
                                                                    <div class="rating-container">
                                                                        <input disabled type="radio" name="rating{{$key}}" value="5"
                                                                            id="star-{{$key}}5" {{attorneyRatings($attorney->id) == 5 ? 'checked' : ''}}> <label for="star-{{$key}}5" title="Ratings : {{attorneyRatings($attorney->id)}}">&#9733;</label>

                                                                        <input disabled type="radio" name="rating{{$key}}" value="4"
                                                                            id="star-{{$key}}4" {{attorneyRatings($attorney->id) == 4 ? 'checked' : ''}}> <label for="star-{{$key}}4" title="Ratings : {{attorneyRatings($attorney->id)}}">&#9733;</label>

                                                                        <input disabled type="radio" name="rating{{$key}}" value="3"
                                                                            id="star-{{$key}}3" {{attorneyRatings($attorney->id) == 3 ? 'checked' : ''}}> <label for="star-{{$key}}3" title="Ratings : {{attorneyRatings($attorney->id)}}">&#9733;</label>

                                                                        <input disabled type="radio" name="rating{{$key}}" value="2"
                                                                            id="star-{{$key}}2" {{attorneyRatings($attorney->id) == 2 ? 'checked' : ''}}> <label for="star-{{$key}}2" title="Ratings : {{attorneyRatings($attorney->id)}}">&#9733;</label>

                                                                        <input disabled type="radio" name="rating{{$key}}" value="1"
                                                                            id="star-{{$key}}1" {{attorneyRatings($attorney->id) == 1 ? 'checked' : ''}}> <label for="star-{{$key}}1" title="Ratings : {{attorneyRatings($attorney->id)}}">&#9733;</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="font-accent">
                                                            {{-- <small class="accent-color-3">DUI Expert</small> --}}
                                                            {{-- <br> --}}
                                                            <span
                                                                class="font-14">{{ isset($attorney->getUserDetails->bio) ? truncate_text($attorney->getUserDetails->bio, 100) : 'Profile not completed.' }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="row text-end mb-2 mt-2">
                                                        <div class="offset-md-4 col-md-8">
                                                            @if ((isset($attorney)) AND $attorney->restricted_steps > 11)
                                                                <label class="btn-accepted w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                    Application received
                                                                </label>
                                                            @else
                                                                <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1">
                                                                    Application not received yet
                                                                </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4 xy-center">
                                                        @if ((isset($attorney)) AND $attorney->restricted_steps > 7)
                                                            <div class="col-md-12">
                                                                <a href="{{ route('admin_attornies_details',[$attorney->id]) }}"
                                                                    class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10">
                                                                    View Details</a>
                                                            </div>
                                                        @else

                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Pagination links -->
                                    <div class="pagination w-100">
                                        {{ $attornies->links() }}
                                    </div>
                                </div>
                            </div>

                        {{-- <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/interested-attorney.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-0">
                                                    <div class="row">
                                                        <div class="col-sm-4 pt-2">
                                                            <span class="font-20 fw-bold ">Robin Hood</span>
                                                        </div>
                                                        <div class="col-sm-8"><div class="rating-box">
                                                            <div class="rating-container">
                                                                <input disabled type="radio" name="rating6" value="5" id="star-5"> <label for="star-5">&#9733;</label>

                                                                <input disabled type="radio" name="rating7" value="4" id="star-4" checked> <label for="star-4">&#9733;</label>

                                                                <input disabled type="radio" name="rating8" value="3" id="star-3"> <label for="star-3">&#9733;</label>

                                                                <input disabled type="radio" name="rating9" value="2" id="star-2"> <label for="star-2">&#9733;</label>

                                                                <input disabled type="radio" name="rating99" value="1" id="star-1"> <label for="star-1">&#9733;</label>
                                                            </div>
                                                        </div></div>
                                                    </div>
                                                <p class="font-accent">
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_attornies_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/interested-attorney.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-0">
                                                    <div class="row">
                                                        <div class="col-sm-4 pt-2">
                                                            <span class="font-20 fw-bold ">Robin Hood</span>
                                                        </div>
                                                        <div class="col-sm-8"><div class="rating-box">
                                                            <div class="rating-container">
                                                                <input disabled type="radio" name="rating11" value="5" id="star-5" checked> <label for="star-5">&#9733;</label>

                                                                <input disabled type="radio" name="rating12" value="4" id="star-4" > <label for="star-4">&#9733;</label>

                                                                <input disabled type="radio" name="rating13" value="3" id="star-3" > <label for="star-3">&#9733;</label>

                                                                <input disabled type="radio" name="rating14" value="2" id="star-2"> <label for="star-2">&#9733;</label>

                                                                <input disabled type="radio" name="rating15" value="1" id="star-1"> <label for="star-1">&#9733;</label>
                                                            </div>
                                                        </div></div>
                                                    </div>
                                                <p class="font-accent">
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-pending w-100 d-block text-center radius-10 pt-1 pb-1"> Pending</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_attornies_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="card card-border-bottom radius-20">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-md-2 text-center">
                                            <div class="icon-large">
                                                <div class="customer-avatar text-center">
                                                    <img class="w-100" src="{{asset('images/interested-attorney.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 border-box-left">
                                            <div class="pt-0">
                                                    <div class="row">
                                                        <div class="col-sm-4 pt-2">
                                                            <span class="font-20 fw-bold ">Robin Hood</span>
                                                        </div>
                                                        <div class="col-sm-8"><div class="rating-box">
                                                            <div class="rating-container">
                                                                <input disabled type="radio" name="rating111" value="5" id="star-5" > <label for="star-5">&#9733;</label>

                                                                <input disabled type="radio" name="rating112" value="4" id="star-4" > <label for="star-4">&#9733;</label>

                                                                <input disabled type="radio" name="rating113" value="3" id="star-3" > <label for="star-3">&#9733;</label>

                                                                <input disabled type="radio" name="rating114" value="2" id="star-2" checked> <label for="star-2">&#9733;</label>

                                                                <input disabled type="radio" name="rating115" value="1" id="star-1"> <label for="star-1">&#9733;</label>
                                                            </div>
                                                        </div></div>
                                                    </div>
                                                <p class="font-accent">
                                                    <small class="accent-color-3">DUI Expert</small>
                                                    <br>
                                                    <span class="font-14" >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="row text-end mb-2 mt-2">
                                                <div class="offset-md-4 col-md-8">
                                                    <label class="btn-rejected w-100 d-block text-center radius-10 pt-1 pb-1"> Rejected</label>
                                                </div>
                                            </div>
                                            <div class="row xy-center">
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Accept</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="#" class="btn-primary w-100 d-block text-center p-1 mb-2 radius-10"> Deny</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('admin_attornies_details')}}" class="btn-primary w-100 d-block text-center p-1 radius-10"> View Details</a>
                                                </div>
                                            </div>
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

    </div>

@endsection
