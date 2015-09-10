@extends('template.layout')

@section('custom-styles')
<link rel="stylesheet" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/uniform/css/uniform.default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/global/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/css/components.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/custom.css') }}">

<style type="text/css"> 

</style>
@stop
 

@section('body-attributes')
@stop

@section('content')

  @include('booking.form.wizard')

@stop

@section('custom-scripts')
  <script src=" {{asset('assets/admin/pages/scripts/form-wizard.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/select2/select2.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}} "></script>
  <script>
  jQuery(document).ready(function($) {
    FormWizard.init();
  });
  </script>
@stop

