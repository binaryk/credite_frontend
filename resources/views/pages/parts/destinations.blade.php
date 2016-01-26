<div class="blog-sidebar quick-book">
  <div class="row">
    <div class="col-md-6">
        <ul class="tabbable faq-tabbable">
        <h2>Airports</h2>
            @foreach($airports as $key => $airport)
          <li id="link_places_{!!$airport->id!!}" class="tooltip_link" title="<a data-id='link_places_{!! $airport->id !!}' href='#' class='tooltip_switch'> Switch destinations! </a>">
              <a href="{{ route('booking.destination',['destination' => $airport->id, 'type' => 'airports', 'switched' => '0']) }}" class="link">
                  <span class="from">{!! $airport['from'] !!}</span>
                  -
                  <span class="to">{!! $airport['to'] !!}</span>
                  <span class="price">{!! $airport['price'] !!} &pound;</span>
              </a>
          </li>
        @endforeach
       </ul>
      
    </div>
    <div class="col-md-6">
      <ul class="tabbable faq-tabbable">
       <h2>Ports</h2>
          @foreach($ports as $key => $port)
            <li id="link_ports_{!!$port->id!!}" class="tooltip_link" title="<a data-id='link_ports_{!! $port->id !!}' href='#' class='tooltip_switch'> Switch destinations! </a>">
                <a href="{{ route('booking.destination',['destination' => $port->id, 'type' => 'ports', 'switched' => '0']) }}" class="link">
                    <span class="from">{!! $port['from'] !!}</span>
                    -
                    <span class="to">{!! $port['to'] !!}</span>
                    <span class="price">{!! $port['price'] !!} &pound;</span>
                </a>
            </li>
          @endforeach 
      </ul>
    </div>
  </div>
</div>


@section('custom-scripts')
@parent
<script src="{{ asset( 'custom/js/general/BookingForm.js') }}"></script>  
   
@stop

