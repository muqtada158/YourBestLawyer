@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Media')

@section('content')

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
                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Media</h2>
                    <div class="container">

                        @forelse ($medias as $media)
                        <div class="row mt-3">
                            <div class="card card-border-bottom">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="row mt-2"> <h5 class="fw-bold mb-0 col-lg-6 font-accent">SR # {{$media->sr_no}}</h5> </div>
                                            @if (isset($media->getCaseMedia) AND $media->getCaseMedia !== null)
                                                @forelse ($media->getCaseMedia as $media)
                                                    @if ($media->type == 'image')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset($media->media) }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'video')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/video-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($media->type == 'document')
                                                        <div class="col-md-3">
                                                            <a href="{{ asset($media->media) }}"
                                                                target="__blank">
                                                                <img src="{{ asset('images/document-thumbnail.png') }}"
                                                                    alt=""
                                                                    class="w-100 mt-3 mb-3 form-image">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @empty
                                                    <p class="mt-4">No Media Uploaded...</p>
                                                @endforelse
                                            @else
                                                
                                            @endif
                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                            <div class="row text-center">
                                <p>No Media found</p>
                            </div>
                        @endforelse()
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pagination w-100">
                                    {{ $medias->links() }}
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
