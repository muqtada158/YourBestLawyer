@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Auth')

@section('content')

<div id="content">


    <section id="registration-form" class="design-section">
        <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1" style="background-image: url('{{asset('images/bg-design.png')}}');">
        </div>
        <div class="padding-section-medium registration-form-section design-section-2" id="auth">
            <div style="max-width:1000px; margin:auto;" class="row p-3 p-md-5 background-attorney">
                <h1 class="text-black font-80 text-break text-center">YourBest<span class="text-primary">Lawyer</span><span class="font-48">.com</span></h1>
                <p class="font-40 text-black pb-5 text-center">Empowering you through legal clarity!</p>
                <div class="container">
                    <div class="row">
                        <div class="offset-md-1 col-md-10">
                            <a href="{{route('register_view',['type'=>'attorney'])}}" class="btn btn-secondary-5 w-100 mt-5 ">
                                <img src="{{asset('images/svg/auth_attorney.svg')}}" class="sidebar-icon-default-color" alt="">
                                &nbsp; Register As Attorney
                            </a>
                            <a href="{{route('register_view',['type'=>'customer'])}}" class="btn btn-secondary-5 w-100 mt-3">
                                <img src="{{asset('images/svg/auth_consumer.svg')}}" class="sidebar-icon-default-color" alt="">
                                Register As Customer
                            </a>
                            <!--<a href="{{route('home')}}" class="btn btn-secondary-5 w-100 mt-3">-->
                            <!--    <img src="{{asset('images/svg/auth_home.svg')}}" class="sidebar-icon-default-color" alt="">-->
                            <!--    &nbsp; Visit Home-->
                            <!--</a>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-1 col-md-10 text-end mt-3">
                            <a class="text-primary fw-bold fs-5" href="{{route('login_view')}}">Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>

@endsection
