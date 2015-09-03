<div class="portlet portlet-sortable box green-haze">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>
            	<label class="control-label" for="{{$name}}">
					@if($feedback == Easy\Form\Base::FEEDBACK_SUCCESS)
						<i class="fa fa-check"></i>
					@elseif($feedback == Easy\Form\Base::FEEDBACK_WARNING)
						<i class="fa fa-bell-o"></i>
					@elseif($feedback == Easy\Form\Base::FEEDBACK_ERROR)
						<i class="fa fa-times-circle-o"></i>
					@endif
					{!! $caption !!}
				</label>
        </div>
        <div class="actions">
            <a href="#" class="btn btn-default btn-sm">
            <i class="fa fa-pencil"></i> Editează </a>
            <a href="#" data-id = "{!!$name!!}" class="btn btn-default btn-sm delete_area">
            <i class="fa fa-remove"></i> Șterge </a> 
            <a class="btn btn-sm btn-icon-only btn-default fullscreen" href="#"></a>
        </div>
    </div>
    <div class="portlet-body"> 
         <div class="form-group{{$feedback ? ' has-' . $feedback : ''}}">
             	<div class="form-group">
					<div class="col-md-12 note-block">
						{!! Form::textarea($name, $value, $attributes) !!} 
					</div>
				</div>
				<div class="clearfix"></div>
			@if($help)
				<p class="help-block">{{$help}}</p>
			@endif
		</div>

    </div>
</div> 