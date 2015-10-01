@extends('template.layout')

@section('custom-styles')
<style type="text/css">
  div[class*='up_point'],
  div[class*='off_point']{
    display: none;
  }
</style>
@stop

@section('slider')
@stop

@section('body-attributes')
@stop

@section('content')

    <div ui-view></div>
    
    <div class="row">
      <div class="col-md-6">
        @include('pages.parts.destinations')
      </div>
      <div class="col-md-6" id="slider">
        @include('template.parts.body.~page-slider')
      </div>
    </div>

@stop

@section('custom-scripts')

  <script src="{{ asset( 'custom/js/general/HomePage.js') }}" ></script> 


  <script type="text/javascript">
    var _config = {
      r_get_airports       : "{{route('r_get_airports')}}" ,
      r_get_form           : "{{ route('r_get_form') }} "
    }

    HomePage.init();
  </script>
@stop

