@extends('templateadmin.layout')

@section('content')
    @include('administration.requests.requests')
    @include('administration.requests.orders')
@stop
@section('custom-scripts')
    @parent
    @include('administration.requests.script')
@endsection