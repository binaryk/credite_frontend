@extends('template.layout')

@section('custom-styles')
  <link rel="stylesheet" href="{!! asset('components/tooltipster/css/tooltipster.css') !!}">
<style type="text/css">
  div[class*='up_point'],
  div[class*='off_point']{
    display: none;
  }
    .tooltipster-white {
        border-radius: 5px;
        border: 2px solid #F1F1F1;
        border-radius: 7px;
        background: #003147;
        color: #ccc;
    }
  .tooltipster-white a {
      color: #007FBB;
      font-weight: bold;
  }
  .tooltipster-white  .tooltipster-content{
      font-family: Arial, sans-serif;
      font-size: 14px;
      line-height: 16px;
      padding: 8px 10px;
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

