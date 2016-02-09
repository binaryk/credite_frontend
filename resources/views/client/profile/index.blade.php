@extends('template.layout')
@include('client.profile.css')
@include('client.profile.js')


@section('content')
    @include('client.profile.info')
    @include('client.profile.date-bd')
@stop
