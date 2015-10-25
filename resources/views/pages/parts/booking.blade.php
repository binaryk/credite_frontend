<div class="portlet box blue ">
<div class="portlet-title">
  <div class="caption">
    Booking	
  </div>
  <div class="tools">
    <a href="" class="collapse" data-original-title="" title="">
    </a>
    <a href="" class="remove" data-original-title="" title="">
    </a>
  </div>
</div>
<div class="portlet-body form">
  <form action="{!! route('boking_submit') !!}" role="form" lpformnum="16" method="POST">
    <div class="form-body">
    <div class="col-md-12">
    	<div class="col-md-8">
	      <div class="form-group has-success">
	        {!! $controls['from'] !!}
	      </div>
    	</div>
    	<div class="col-md-4">
	      <div class="form-group has-success">
	        {!! $controls['from_nr'] !!}
	      </div>
    	</div>
    </div>
    <div class="col-md-12">
      <div class="col-md-8">
      	<div class="form-group has-success">
     	  {!! $controls['to'] !!}
    	</div>
      </div>
      <div class="col-md-4">
	      <div class="form-group has-success">
	        {!! $controls['to_nr'] !!}
	      </div> 
      </div>
    </div> 
    </div>
    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

    <div class="clearfix"></div>
    <div class="form-actions">
      <button type="submit" class="btn red">Submit</button>
    </div>
  </form>
</div>
</div>