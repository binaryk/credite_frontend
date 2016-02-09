@section('custom-scripts')
    @parent

    <script src=" {{asset('custom/js/fisa/FormWizardFisa.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}} "></script>
    <script src=" {{asset('assets/admin/pages/scripts/form-icheck.js')}} "></script>
    <script src=" {{asset('assets/global/plugins/icheck/icheck.min.js')}} "></script>
    <script>
        jQuery(document).ready(function($) {
            FormWizardFisa.init();
        });
    </script>
    </script>
@endsection