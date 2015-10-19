<script src="{{ asset( 'assets/global/plugins/jquery.min.js' ) }}"></script>
<script src="{{ asset( 'components/jquery-ui/jquery-ui.min.js') }}" ></script> 
<script src="{{ asset( 'assets/global/plugins/bootstrap/js/bootstrap.min.js' ) }}"></script>
<script src="{{ asset( 'assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js' ) }}"></script>
<script src="{{ asset( 'assets/global/scripts/metronic.js' ) }}"></script>
<script src="{{ asset( 'assets/admin/layout/scripts/layout.js' ) }}"></script>

<script src="{{ asset( 'assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" ></script> 

<script src="{{ asset( 'components/toastr/toastr.min.js') }}" ></script> 
<script src="{{ asset( 'components/sweetalert/dist/sweetalert.min.js') }}" ></script> 

<script>
    jQuery(document).ready(function() {
        Metronic.init(); 
        Layout.init();
    });
</script>
<script>
    var token = $('meta[name="csrf_token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token,
            'X-XSRF-TOKEN': token
        },
        '_token' : token,
        async    : false
    }); 
    
</script>
 
@yield('custom-scripts')

<script src="{{ asset( 'custom/js/sweet.js') }}" ></script>
@include('templateadmin.parts.body.~ga')




