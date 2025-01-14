@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Fee Intake')

@section('content')

<div id="content">

    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
            <h2 style="padding-top:75px;" class="text-white text-center font-accent">Attorney Portal</h2>
        </div>
        <div class="padding-section-medium registration-form-section design-section-2">
            <div class="customer-portal-section-without-grid p-3 p-md-5 background-attorney">
                <div class="customer-portal-content py-3">
                    <h1 class="text-center font-accent">Fee Intake</h1>

                    @foreach ($fees as $fee)
                        <h3 class="text-center font-accent fw-bold mt-4">{{$fee->title}}</h3>
                        @foreach ($fee->subCategories as $sub)
                            @if($sub->getLaywers->isNotEmpty())
                                <h5 class="text-center font-accent mt-4">{{$sub->title}}</h5>
                                <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; text-align: center; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Type of Attorney</th>
                                            <th>Expected Fee</th>
                                            <th>Flat Fee due to Yourbestlawyer.com</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sub->getLaywers as $lawyer)
                                            <tr>
                                                <td>{{$lawyer->title}}</td>
                                                <td>
                                                    @if ( $fee->count_as == "$")
                                                        {{$fee->count_as}}{{number_format($lawyer->min_amount,2)}} to {{$fee->count_as}}{{number_format($lawyer->max_amount,2)}}
                                                    @else
                                                        {{number_format($lawyer->min_amount,2)}}{{$fee->count_as}} to {{number_format($lawyer->max_amount,2)}}{{$fee->count_as}}
                                                    @endif
                                                </td>
                                                <td>${{number_format($lawyer->ybl_flat_fee,2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
    </section>

</div>
@endsection
