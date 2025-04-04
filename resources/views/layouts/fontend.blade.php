<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$pageTitle ?? 'EMPTY'}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('fontend/css/plugins/pro6.min.css?v=')}}{{rand()}}">
    <link rel="stylesheet" type="text/css" href="{{asset('fontend/css/bootstrap.min.css?v=')}}{{rand()}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('fontend/js/plugins/slider/splide/css/splide.min.css?v=')}}{{rand()}}">
    <script type="text/javascript" src="{{asset('fontend/js/plugins/slider/splide/js/splide.min.js?v=')}}{{rand()}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('fontend/css/all.min.css?v=')}}{{rand()}}">
    <script type="text/javascript" src="{{asset('fontend/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('fontend/js/jquery.barrating.min.js')}}"></script>
</head>
<body class="ohide" itemscope="" itemtype="http://schema.org/WebPage" style="transform: none;" data-new-gr-c-s-check-loaded="14.1211.0" data-gr-ext-installed="">
    @include('parts.fontend.header-navigation')
    <main class="ps-main">
        <!--start:body-->
        <link href="{{asset('fontend/css/select2.css')}}" type="text/css" rel="stylesheet" />
        <script type="text/javascript"  src="{{asset('fontend/js/select2.full.min.js')}}"></script>
        <script> 
        jQuery(document).ready(function (){
            jQuery(".js-example-tags").select2({});
            jQuery('.js-example-basic-single').select2();
        });
        </script>
        <!--start:toolbarsearch-->

        

        @yield('content')

        {{-- @include('parts.fontend.receive') --}}

    </main>
</body>
@include('parts.fontend.footer')
<script type="text/javascript" src="{{asset('fontend/js/plugins/form-validator/jquery.validate.min.js')}}"></script>
<script defer type="text/javascript" src="{{asset('fontend/js/bootstrap.min.js')}}"></script>
<script defer type="text/javascript" src="{{asset('fontend/js/jquery.lazyload.min.js')}}"></script>
<script defer type="text/javascript" src="{{asset('fontend/js/plugins/sweetalert2.min.js?v=')}}{{rand()}}"></script>
<script type="text/javascript" src="{{asset('fontend//js/main.js?v=')}}{{rand()}}"></script>
    {{-- <script defer type="text/javascript" src="{{asset('fontend/js/plugins/function_cart.js?v=')}}{{rand()}}"></script> --}}
<script defer type="text/javascript" src="{{asset('fontend/js/function.js?v=')}}{{rand()}}"></script>
</html>