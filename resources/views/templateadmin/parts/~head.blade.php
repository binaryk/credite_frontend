<head>
<meta charset="utf-8"/>
<title>Credite</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="" name="proiect norwitchtransfer">
<meta content="" name="Binaryk">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="csrf_token" content="{!! csrf_token() !!}"/>

<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/pace/themes/pace-theme-barber-shop.css') }}">

<link rel="stylesheet"  href="{{ asset('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/uniform/css/uniform.default.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}">

@yield('before-plugins')
<link rel="stylesheet" href="{{ asset( 'assets/global/css/components.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/global/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/admin/layout/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset( 'assets/admin/layout/css/themes/light2.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('components/toastr/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('components/sweetalert/dist/sweetalert.css') }}">
 

@yield('custom-styles')
<link rel="shortcut icon" href="{!! asset('favicon_') !!}">
