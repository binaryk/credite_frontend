<script src="{!! asset('custom/ts/Validation.js') !!}"></script>
<script src="{!! asset('custom/ts/Response.js') !!}"></script>
<script>
    $(document).ready(function(e){
        var validate = (new Response({ endPoit: "{!! route('admin_requests_response_post',['id' => $request->id]) !!}" })).init();
    });
</script>



@section('custom-styles')
    @parent
    <link rel="stylesheet" href="{!! asset('custom/scss/validation.css') !!}">
@endsection