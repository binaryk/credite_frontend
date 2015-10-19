<div class="checkbox">
	<label>
		{{Form::checkbox($name, $value, $checked, $attributes + $angular )}} {{$caption}}
	</label>
</div>
@if($help)
	<p class="help-block">{{$help}}</p>
@endif