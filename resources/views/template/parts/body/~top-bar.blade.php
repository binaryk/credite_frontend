<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-6 col-sm-6 additional-shop-info">
                <ul class="list-unstyled list-inline">
                    <li><i class="fa fa-phone"></i><span>+44 456 6717</span></li>
                    <li><i class="fa fa-envelope-o"></i><span>info@norwitchtransfer.uk</span></li>
                </ul>
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
            @if(!Auth::check())
                    <li><a href="{{ url('auth/login') }}">Log In</a></li>
                    <li><a href="{{ url('auth/register') }}">Registration</a></li>
            @else
                    <li><a href="{{ url('auth/login') }}">My page</a></li>
                    @if(Auth::user()->admin == '1')
                    <li><a href="{{ route('administration') }}">Administration</a></li>
                    @endif
                    <li><a href="{{ url('auth/logout') }}">Logout</a></li>
            @endif
                </ul>
            </div>

            <!-- END TOP BAR MENU -->
        </div>
    </div>        
</div>
<!-- END TOP BAR -->