<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title','Your Best Lawyer')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon/android-chrome-192x192.png')}}">

    @include('layouts.style')

</head>
<body>
    @php
        $siteURL = 'http://localhost/';
    @endphp
    @include('layouts.header')

    @yield('content')
    <div id="loader-overlay" style="display: none;">
        <img src="{{asset('images/loader.gif')}}" alt="Loading..." class="loader-image" />
    </div>
    @include('layouts.footer')

    @include('layouts.script')

</body>
</html>
