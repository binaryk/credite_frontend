<!DOCTYPE html> 
<html lang="en" class="no-js" ng-app="app"> 
@include('template.parts.~head')
<body class="page-header-fixed page-quick-sidebar-over-content" @yield('body-attributes')>
    @include('template.parts.body.~top-bar')

    @include('template.parts.body.~page-header')
	@include('template.parts.body.~page-slider')
	@include('template.parts.body.~page-content')

 	@include('template.parts.body.~pre-footer')
 	@include('template.parts.body.~footer')
    @include('template.parts.body.~include-js') 
</body>
</html>