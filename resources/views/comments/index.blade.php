@extends('template.layout')
@section('title') Reviews :: @parent @stop
@section('content')
    @include('comments.blog')
@stop

@section('custom-scripts')
    @parent
    <script src="{!! asset('custom/ts/Validation.js') !!}"></script>
    <script src="{!! asset('custom/ts/Reviews.js') !!}"></script>
    <script>
        $(document).ready(function(e){
            var validate = (new Reviews({ endPoit: "{!! route('comment.submit') !!}" })).init();
        });
    </script>
@endsection

@section('custom-styles')
    @parent
    <link rel="stylesheet" href="{!! asset('custom/scss/validation.css') !!}">
@endsection