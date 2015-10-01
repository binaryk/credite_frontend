<div class="blog-sidebar quick-book">
  <div class="row">
    <div class="col-md-6">
      <ul class="tabbable faq-tabbable">
        <h2>Airports</h2> 
        @foreach(Config::get('airports') as $key => $airport)
          <li><a href="{{ route('booking.destination',['destination' => $key, 'type' => 'airports']) }}"> {!! $airport !!} </a></li>  
        @endforeach
       </ul>
      
    </div>
    <div class="col-md-6">
      <ul class="tabbable faq-tabbable">
       <h2>Ports</h2>
          @foreach(Config::get('ports') as $key => $port)
            <li><a href="{{ route('booking.destination',['destination' => $key, 'type' => 'ports']) }}"> {!! $port !!} </a></li>  
          @endforeach 
      </ul>
    </div>
  </div>
</div>


@section('custom-scripts')
@parent
<script src="{{ asset( 'custom/js/general/BookingForm.js') }}"></script>  
   
@stop

