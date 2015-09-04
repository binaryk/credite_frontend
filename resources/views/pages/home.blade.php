@extends('template.layout')
@section('custom-styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('components/select2/dist/css/select2.min.css') }}">
@stop
@section('slider')
   
@stop

@section('body-attributes')
  ng-controller = "BookingCtrl"
@stop

@section('content')

    <div class="row">
      <div class="col-md-3">
        @include('pages.parts.quick-booking')
      </div>
      <div class="col-md-9">
        @include('template.parts.body.~page-slider')
      </div>
    </div>

    
    @include('pages.parts.original-content')


@stop

@section('custom-scripts')
  <script src="{{ asset( 'components/select2/dist/js/select2.min.js') }}" ></script> 
  <script src="{{ asset( 'custom/js/angular/config.js') }}" ></script> 
  <script src="{{ asset( 'custom/js/angular/controllers/BookingCtrl.js') }}" ></script> 
  <script src="{{ asset( 'custom/js/general/HomePage.js') }}" ></script> 


  <script type="text/javascript">
    var _config = {
      r_get_airports       : "{{route('r_get_airports')}}" 
    }

    HomePage.init();
  </script>
@stop

