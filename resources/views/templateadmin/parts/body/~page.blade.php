<div class="page-container">
	
	@include('templateadmin.parts.body.~sidebar')
	<div class="page-content-wrapper">
		<div class="page-content">
			@include('templateadmin.parts.body.~page-header')
			@include('templateadmin.parts.body.~messages')
			@yield('content')
		</div>
	</div>
	@include('templateadmin.parts.body.~quick-sidebar')
</div>
 