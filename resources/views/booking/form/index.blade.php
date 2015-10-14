@extends('template.layout')

@section('custom-styles')
<link rel="stylesheet" href="{{ asset( 'assets/global/plugins/icheck/skins/all.css' ) }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/uniform/css/uniform.default.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/global/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/css/components.css') }}"> 
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/layout/css/custom.css') }}">
<!-- date picker -->
<link rel="stylesheet" href="{{ asset('assets/global/plugins/clockface/css/clockface.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

<style type="text/css"> 
    .images img{
        margin-right: 10px;
    }
    .images{
        margin-bottom: 20px;
    }
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

  <!-- date pickers -->
  <script src=" {{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/clockface/js/clockface.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}} "></script>
  <script src=" {{asset('assets/admin/pages/scripts/components-pickers.js')}} "></script>
  <script src=" {{asset('assets/admin/pages/scripts/form-icheck.js')}} "></script>
  <script src=" {{asset('assets/global/plugins/icheck/icheck.min.js')}} "></script>
  <script src=" {{asset('custom/js/general/BookingForm.js')}} "></script>
  <script>
  jQuery(document).ready(function($) {
    FormWizard.init();
    ComponentsPickers.init(); 
    var bf = new BookingForm({});
    bf.init();

  });
  </script>
@stop

