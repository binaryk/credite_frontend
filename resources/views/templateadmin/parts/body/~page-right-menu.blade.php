@if( isset($right_menu) )
<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
Acțiuni <i class="fa fa-angle-down"></i>
</button>
@endif  
<ul class="dropdown-menu pull-right" role="menu">
	@if( isset($right_menu) )  
		@foreach($right_menu as $key => $menu)
			<li>
				<a class="{{ $menu['class'] }}"> {{$menu['caption']}}</a> 
			</li>
		@endforeach
	@endif  
</ul>