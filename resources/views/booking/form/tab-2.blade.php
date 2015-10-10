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
				<div class="col-md-6">
					{!! $data['steps']['records']['up_date'] !!}
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="hour">Hour</label>
						<input type="text" name="hour" value="2:30 PM" data-format="hh:mm A" class="form-control clockface_1"/>
					</div>
				</div>
			</div>
		</div>


		<div class="row images">
			<div class="col-md-8">
				{{--<div class="col-md-4">--}}
					{{--{!! $data['steps']['records']['nr_passegers'] !!}--}}
				{{--</div>--}}
				{{--<div class="col-md-4">--}}
					{{--{!! $data['steps']['records']['nr_luggages'] !!}--}}
				{{--</div>--}}
				{{--<div class="col-md-4">--}}
					{{--{!! $data['steps']['records']['nr_hand_luggages'] !!}--}}
				{{--</div>--}}
				<img src=" {!! asset('img/persons.png') !!} " width="70" height="40" alt="">
				<img src=" {!! asset('img/luggage_small.png') !!} " width="70" height="40" alt="">
				<img src=" {!! asset('img/luggage_big.png') !!} " width="70" height="40" alt="">
			</div>
		</div>
	<div class="row">
	</div>

		<div class="row">
			<div class="col-md-8">
				{!! $data['steps']['records']['details'] !!}
			</div>
			<div class="col-md-4">
				{!! $data['steps']['records']['meet_and_greet'] !!}
				{!! $data['steps']['records']['return_50'] !!}
			</div>
		</div>	
</div>