@extends('template.layout')

@section('custom-styles')
@stop

@section('slider')
@stop
{{--
@section('body-attributes')
  ng-controller = "BookingCtrl"
@stop
--}}
@section('content')


    <div ng-view></div>

    
    {{--@include('pages.parts.original-content')--}}

@stop

@section('custom-scripts')
  <script src="{{ asset( 'custom/js/angular/config.js') }}" ></script> 

  
  <script src="{{ asset( 'custom/js/angular/controllers/BookingCtrl.js') }}" ></script> 
  <script src="{{ asset( 'custom/js/angular/controllers/IndexCtrl.js') }}" ></script> 
  <script src="{{ asset( 'custom/js/angular/controllers/FormCtrl.js') }}" ></script> 




  <script src="{{ asset( 'custom/js/general/HomePage.js') }}" ></script> 
  <script src="{{ asset( 'components/angular-route/angular-route.min.js') }}" ></script> 


  <script type="text/javascript">
    var _config = {
      r_get_airports       : "{{route('r_get_airports')}}" 
    }

    HomePage.init();
  </script>
@stop

