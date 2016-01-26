<div class="page-container">
	
	@include('templateadmin.parts.body.~sidebar')
	<div class="page-content-wrapper">
		<div class="page-content">
			@include('templateadmin.parts.body.~messages')
			@include('templateadmin.parts.body.~page-header')
			@yield('content')
		</div>
	</div>
	@include('templateadmin.parts.body.~quick-sidebar')
</div>
 