<div class="col-md-12">
  {!! $controls[$type . 'options'] !!}
</div>
<div class="col-md-12 {{ $type }}point3"> 
  {!! $controls[$type . 'postal_code'] !!}
</div>  
<div class="col-md-12 {{ $type }}point1">
  {!! $controls[$type . 'address'] !!}
</div> 
<div class="col-md-12 {{ $type }}point2">
  {!! $controls[$type . 'airport'] !!}
</div>  

@section('custom-scripts')
@parent

<script type="text/javascript"> 
  var parameters = {};
  parameters['type'] = "{!! $type !!}";
  var bf = new BookingForm(parameters);
  bf.init();

  var input = (document.getElementById('{{$type}}address'));
  var autocomplete = new google.maps.places.Autocomplete(input);


</script>


@stop