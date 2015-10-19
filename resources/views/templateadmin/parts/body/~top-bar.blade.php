<div class="page-header -i navbar navbar-fixed-top">
    <div class="page-header-inner">
        {{--<div class="page-logo">
            <a href="{{ URL('/') }}">
               <img src="{{ asset('assets/admin/layout/img/logo.png') }}" class="logo-default">
            </a>
            <div class="menu-toggler sidebar-toggler hide"></div>
        </div> --}} 
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
         <div class="top-menu" style="float: left !important;">
            <ul class="nav navbar-nav pull-left">
                @include('templateadmin.parts.body.~user-login')
            </ul>
        </div> 
    </div>
</div>
<div class="clearfix"></div>