<div class="tab-pane" id="tab2">
	<h3 class="block">{!! $help !!}</h3>
		<div class="row">
			<div class="col-md-6">
				{!! $data['steps']['records']['email'] !!}
			</div>
			<div class="col-md-6">
				{!! $data['steps']['records']['name'] !!}
			</div>
		</div>

		<div class="row"> 
			<div class="col-md-6">
				{!! $data['steps']['records']['phone'] !!}
			</div>
			<div class="col-md-6">
				{!! $data['steps']['records']['resident_phone'] !!}
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				{!! $data['steps']['records']['up_date'] !!}
			</div>
			<div class="col-md-8">
				<div class="col-md-4">
					{!! $data['steps']['records']['nr_passegers'] !!}
				</div>
				<div class="col-md-4">
					{!! $data['steps']['records']['nr_luggages'] !!}
				</div>
				<div class="col-md-4">
					{!! $data['steps']['records']['nr_hand_luggages'] !!}
				</div>
			</div>
		</div> 

		<div class="row">
			<div class="col-md-4">
				{!! $data['steps']['records']['details'] !!}
			</div>
		</div>	
</div>