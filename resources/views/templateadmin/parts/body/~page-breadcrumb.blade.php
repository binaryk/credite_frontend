<ul class="page-breadcrumb">

<li>
	<i class="fa fa-home"></i>
	<a href="{{URL('/') }}">Home</a>  
@if( isset($breadcrumbs) )
	<i class="fa fa-angle-right"></i>
</li>
	@foreach($breadcrumbs as $key => $breadcrumb)
		<li>
			<a href="{{ route($breadcrumb['url'], $breadcrumb['ids']) }}">{{$breadcrumb['name']}}</a>
			@if( $key < count($breadcrumbs) - 1 )
				<i class="fa fa-angle-right"></i>
			@endif
		</li>
	@endforeach
	
	@yield('after-breadcrumb')

@endif

</ul>  

<style type="text/css">
	.active{
		border-top: 3px solid #3B9C96;
		margin-top: -3px;
	}
</style>