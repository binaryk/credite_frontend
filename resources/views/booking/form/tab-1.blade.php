<div class="tab-pane active" id="tab1">
	<h3 class="block"> {!! $help !!} </h3>

	<div class="row">
		<div class="col-md-6 from-address">
			{!! $data['steps']['records']['from'] !!}
		</div>
		<div class="col-md-6 to-address">
			{!! $data['steps']['records']['to'] !!}
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 from-nr" style="display: none;">
			{!! $data['steps']['records']['from_nr'] !!}
		</div>
		<div class="col-md-6 to-nr pull-right" style="display: none;">
			{!! $data['steps']['records']['to_nr'] !!}
		</div>
	</div>
</div>