<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$pageTitle ?? 'EMPTY'}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('fontend/css/plugins/pro6.min.css?v=')}}{{rand()}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('fontend/css/plugins/bootstrap-grid.min.css?v=')}}{{rand()}}" rel="stylesheet" type="text/css" media="all" />
	<link href="{{asset('fontend/css/plugins/checkout.vendor.min.css?v=')}}{{rand()}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('fontend/css/plugins/style.plugins.css?v=')}}{{rand()}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('fontend/css/plugins/checkouts.css?v=')}}{{rand()}}" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="{{asset('fontend/js/plugins/jquery-3.6.0.min.js?v=')}}{{rand()}}"></script>
	<script defer type="text/javascript" src="{{asset('fontend/js/plugins/notification/sweetalert2/sweetalert2.min.js?v=')}}{{rand()}}"></script>
	<script type="text/javascript" src="{{asset('fontend/js/plugins/form-validator/jquery.validate.min.js?v=')}}{{rand()}}"></script>
	<script type="text/javascript" src="{{asset('fontend/js/plugins/checkout.vendor.min.js?v=')}}{{rand()}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<meta name="google-site-verification" content="K3ldzLvT3ybHbawArhcw62PDK9C6wsV-0WmiW_35nmA" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty/lib/noty.css">
    <script src="https://cdn.jsdelivr.net/npm/noty"></script>
</head>
<body>
    @yield('content')    
</body>
<script type="text/javascript" src="{{asset('fontend/js/checkout.js?v=')}}{{rand()}}"></script>
</html>