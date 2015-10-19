<!DOCTYPE html> 
<html lang="en" class="no-js" ng-app="app"> 
@include('templateadmin.parts.~head')
<style type="text/css">
	#mydiv {  
	    position:absolute;
	    top:0;
	    left:0;
	    width:100%;
	    height:100%;
	    z-index:1000;
	    background-color:grey;
	    opacity: .8;
	 }

	.ajax-loader {
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    margin-left: -32px; /* -1 * image width / 2 */
	    margin-top: -32px;  /* -1 * image height / 2 */
	    display: block;     
	}
</style>
<body class="page-header-fixed page-quick-sidebar-over-content" @yield('body-attributes') > 

    @include('templateadmin.parts.body.~top-bar')
    @include('templateadmin.parts.body.~page') 
 	@include('templateadmin.parts.body.~footer')
    @include('templateadmin.parts.body.~include-js') 
</body>
</html>