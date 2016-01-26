@extends('template.layout')

@section('custom-styles')
  <link rel="stylesheet" href="{!! asset('components/tooltipster/css/tooltipster.css') !!}">
  <link rel="stylesheet" href="{!! asset('custom/scss/main.css') !!}">
<style type="text/css">
    .comment{
        background-image: url({!! asset('img/comm.jpg') !!}) !important;
    }
</style>
@stop

@section('slider')
@stop

@section('body-attributes')
@stop

@section('content')
@include('templateadmin.parts.body.~messages')
    <div ui-view></div>

    <div class="row">
      <div class="col-md-6">
        @include('pages.parts.destinations')
      </div>
      <div class="col-md-6" id="slider">
        @include('pages.parts.booking')
        @include('template.parts.body.~page-slider')
      </div>
    </div>

@stop

@section('custom-scripts')

  <script src="{{ asset( 'custom/js/general/HomePage.js') }}" ></script>
  <script src="{{ asset( 'components/tooltipster/js/jquery.tooltipster.min.js') }}" ></script>


  <script type="text/javascript">
    var _config = {
      r_get_airports       : "{{route('r_get_airports')}}" ,
      r_get_form           : "{{ route('r_get_form') }} "
    }

    HomePage.init();
    $(document).ready(function() {
        $('.tooltip_link').tooltipster({
            contentAsHTML: true,
            interactive: true,
            theme: 'tooltipster-white',
            functionInit: function (origin, content) {
            }
        });
        $(document).on('click','.tooltip_switch', function(e){
            var selector = '#' + $(this).data('id');
            var from     = $(selector).find('span.from').html();
            var to       = $(selector).find('span.to').html();
            var link     = $(selector).find('a.link');
            var href_     = link.attr('href');
            var switched = href_.split('/')[href_.split('/').length - 1];
            new_switched = switched == '0' ? '1' : '0';
            href_        = href_.replace('/'+switched,'/'+new_switched);
            link.attr('href', href_);
            $(selector).find('span.from').html(to)
            $(selector).find('span.to').html(from)
        });
    });
  </script>
@stop

