@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Video Details')

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
                <h2 class="fw-bold font-28 mb-0 col-lg-6 font-accent">Personal Videos</h2>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="video">
                                    <iframe width="100%" height="750" src="https://www.youtube.com/embed/oJsn9bGXaMU" title="TREE OF LIFE - Vol. 2 - Beautiful Inspirational Orchestral Music Mix" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card radius-20 border-0">
                                    <div class="card-body">
                                        <h3 class="font-accent text-primary mt-2 mb-4">Experienced Lawyers</h3>
                                        <p class="font-accent mb-4 mt-2">
                                        Lorem ipsum dolor sit amet. Est dicta nihil non tempora illo et odio porro et voluptatem repellat sit tempore accusamus sit necessitatibus voluptatibus non sint eligendi. Ex laborum quis quo voluptas corrupti ut omnis ratione qui labore dolore hic laudantium autem et deleniti iusto id corrupti eligendi.
                                        Hic maxime esse ad molestiae earum ea nisi galisum ut architecto quia aut consequatur necessitatibus ea vero ullam qui eius commodi. A blanditiis sint et minus voluptatem qui eligendi totam.
                                        Sit omnis minima ut quae nihil ut iste expedita et soluta debitis non delectus nemo et numquam cupiditate. Hic incidunt molestias ut inventore expedita est sapiente architecto a eligendi voluptatem est commodi fuga ab consequatur voluptate? Qui dolor similique qui voluptatibus dolor et culpa modi sit tempora nihil et nihil perspiciatis.
                                        </p>

                                        <div class="row mt-4">
                                            <div class="col-md-4 mt-2">
                                                <div class="card border-0">
                                                    <div class="card-title bg-primary mb-0">
                                                        <p class="font-accent font-20 text-center text-white mt-3">Novice Lawyer</p>
                                                    </div>
                                                    <div class="card-body back-image-card-1 py-5">
                                                        <p class="mt-2 mb-2 text-white text-center video-card-text">
                                                            Ranges from $2,500 to $5,000 Covers entire case from beginning to end, not including Jury Trial Covers MVD Hearing
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <div class="card border-0">
                                                    <div class="card-title bg-primary mb-0">
                                                        <p class="font-accent font-20 text-center text-white mt-3">Experienced Lawyer</p>
                                                    </div>
                                                    <div class="card-body back-image-card-2 py-5">
                                                        <p class="mt-2 mb-2 text-white text-center video-card-text">
                                                        Ranges from $5,000.00 to $8,500.00 Covers entire case from beginning to end, not including Jury Trial Covers MVD Hearing
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <div class="card border-0">
                                                    <div class="card-title bg-primary mb-0">
                                                        <p class="font-accent font-20 text-center text-white mt-3">Expert Lawyer</p>
                                                    </div>
                                                    <div class="card-body back-image-card-3 py-5">
                                                        <p class="mt-2 mb-2 text-white text-center video-card-text">
                                                        Ranges from $8,500.00 to $13,000.00 Covers entire case from beginning to end, not including Jury Trial Covers MVD Hearing
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
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
