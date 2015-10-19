<li class="dropdown dropdown-user">
	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
	<img src="{{ asset('assets/admin/layout/img/avatar3.jpg') }}" class="img-circle">
	<span class="username username-hide-on-mobile"> {{ Auth::user()->name }} </span>
	<i class="fa fa-angle-down"></i></a>
	<ul class="dropdown-menu" role="menu">
		<li class="title"><a href="#"><span><i class="icon-film"></i><b>Profile</b></span></a></li>
		<li  class="divider"></li>
		<li> <a href="#">Users page</a></li>
	</ul>

</li> 