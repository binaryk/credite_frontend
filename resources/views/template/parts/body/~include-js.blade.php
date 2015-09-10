<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>      
<script src="{{asset('assets/frontend/layout/scripts/back-to-top.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}" type="text/javascript"></script><!-- pop up -->
<script src="{{asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js')}}" type="text/javascript"></script><!-- slider for products -->

<!-- BEGIN RevolutionSlider -->  
<script src="{{asset('assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js')}}" type="text/javascript"></script> 
<script src="{{asset('assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js')}}" type="text/javascript"></script> 
<script src="{{asset('assets/frontend/pages/scripts/revo-slider-init.js')}}" type="text/javascript"></script>
<!-- END RevolutionSlider -->

<script src="{{asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/frontend/layout/scripts/layout.js')}}" type="text/javascript"></script>

<script src="{{ asset( 'components/angular/angular.min.js') }}" ></script> 
<script src="{{ asset( 'components/angular-animate/angular-animate.min.js') }}" ></script> 


<script type="text/javascript">
    jQuery(document).ready(function() {
        Metronic.init();
        Layout.init();    
        Layout.initOWL();
        RevosliderInit.initRevoSlider();
        Layout.initTwitter();
        //Layout.initFixHeaderWithPreHeader(); /* Switch On Header Fixing (only if you have pre-header) */
        //Layout.initNavScrolling(); 
        var token = $('meta[name="csrf_token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token,
                'X-XSRF-TOKEN': token
            },
            '_token' : token,
            async    : false
        });

        $('#flash-overlay-modal').modal();
        $('div.alert').not('.alert-danger').delay(3000).slideUp(300);
    });
</script>
@yield('custom-scripts')



