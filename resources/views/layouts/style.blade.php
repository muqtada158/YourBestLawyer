<!-- Core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link href="{{asset('css/tablet.css')}}" rel="stylesheet" type="text/css" media="screen and (min-width: 768px) and (max-width: 1280px)">
<link href="{{asset('css/mobile.css')}}" rel="stylesheet" type="text/css" media="screen and (max-width: 767px)">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

{{-- file pond css--}}
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.css">
@stack('css')
<style>
    div:where(.swal2-container) h2:where(.swal2-title) {
    position: relative;
    max-width: 100%;
    margin: 0;
    padding: 1em 1em 0 !important;
    color: inherit;
    font-size: 1.875em;
    font-weight: 600;
    text-align: center;
    text-transform: none;
    word-wrap: break-word;
    font-family: 'Poppins';
    line-height: normal;
}
</style>
