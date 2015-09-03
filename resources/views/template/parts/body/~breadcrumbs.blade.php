<ul class="breadcrumb">
<li>
	<a href="{{URL('/') }}">Home</a>  
</li>
	@if( isset($breadcrumbs) )
		@foreach($breadcrumbs as $key => $breadcrumb)
			<li>
				<a href="{{ URL($breadcrumb['url'], $breadcrumb['ids']) }}">{{$breadcrumb['name']}}</a>
			</li>
		@endforeach
		@yield('after-breadcrumb')
	@endif
</ul>   