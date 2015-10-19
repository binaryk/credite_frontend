<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
	<li class="sidebar-toggler-wrapper"><div class="sidebar-toggler"></div></li>
	<li class="sidebar-search-wrapper"> </li>
	<li class="sidebar-search-wrapper">@include('templateadmin.parts.body.~search-form')</li>
	<li class="start"> 
		<a href="javascript:;">
		<i class="icon-folder"></i>
		<span class="title">Users</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li>
				<a href=" {!! route('users-view') !!} "><i class="icon-users"></i> View users</a>
			</li> 
		</ul>
	</li>
	
</ul>