@extends('template.layout')

@section('custom-styles')
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/icheck/skins/all.css' ) }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/css/components.css') }}"> 
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/custom.css') }}">
@stop
 

@section('body-attributes')
ng-controller = 'BookingCtrl'
@stop

@section('content')

  @include('identificarea_nevoii.wizard')

@stop

@section('custom-scripts')
  <script src=" {{asset('assets/admin/pages/scripts/form-wizard.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}} "></script>
  <script src=" {{asset('assets/admin/pages/scripts/form-icheck.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/icheck/icheck.min.js')}} "></script>
  <script src=" {{asset('custom/js/general/BookingForm.js')}} "></script>
  <script src=" {{asset('custom/js/angular/controllers/BookingCtrl.js')}} "></script>
  <script src=" {{asset('custom/ts/Stripe.js')}} "></script>
  <script src="https://checkout.stripe.com/checkout.js"></script>
  <script>
    var stripe;
    jQuery(document).ready(function($) {
    FormWizard.init();
    var bf = new BookingForm({});
  });
  </script>
@stop

