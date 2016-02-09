@section('custom-styles')
    @parent

    <link rel="stylesheet" href="{{ asset( 'assets/global/plugins/icheck/skins/all.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/layout/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/layout/css/custom.css') }}">
@endsection