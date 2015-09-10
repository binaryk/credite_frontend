@if( isset($breadcrumbs) )
	<ul class="breadcrumb">
			@foreach($breadcrumbs as $key => $breadcrumb)
				<li>
					<a href="{{ URL($breadcrumb['url'], $breadcrumb['ids']) }}">{{$breadcrumb['name']}}</a>
				</li>
			@endforeach
			@yield('after-breadcrumb')
	</ul>   
@endif