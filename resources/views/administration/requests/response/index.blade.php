@extends('templateadmin.layout')

@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('administration.requests.response.details')
                @include('administration.requests.response.message')
            </div>
        </div>
@stop
@section('custom-scripts')
    @parent
    @include('administration.requests.response.script')
@endsection