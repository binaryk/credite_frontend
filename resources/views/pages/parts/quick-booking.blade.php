<div class="blog-sidebar quick-book">
  <h2 class="no-top-space">Quick booking Here</h2>
  <ul class="nav margin-bottom-40">
  <form name="form" class="booking-form" method="GET" action="{{route('quick_booking_submit')}} ">
  
   <div class="row">  
      @include('pages.parts.points',['type' => 'up_']) 
   </div> 

   <div class="row">
      @include('pages.parts.points',['type' => 'off_']) 
   </div>
   
  </ul>
    <div class="form-actions">
      <button type="button" class="btn default">Cancel</button>
      <button type="submit" href="" class="btn green action-get-form">Live Booking</button>
    </div>
 </form>
  <!-- CATEGORIES END -->
  <!-- END BLOG TAGS -->
</div>


<link rel="stylesheet" type="text/css" href="components/bootstrap-select/dist/css/bootstrap-select.min.css">

@section('custom-scripts')
@parent
<script src="{{ asset( 'components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset( 'custom/js/general/BookingForm.js') }}"></script>  
   
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places"></script>    

<script>
  $(".form_input").on("submit", function( event ) { 
     event.preventDefault();
     $.ajax({
              method: $(this).attr('method'),
              url: $(this).attr('action'),
              data: $(this).serialize(),
              dataType: "json",
              success: function(data){
               // do stuff
               console.log('success');
              },
              error: function(data){
               // do stuff
               console.log('error');
              }
       })
    });
</script>


@stop

