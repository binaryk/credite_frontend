@extends('template.layout')

@section('custom-styles')
  <link rel="stylesheet" href="{!! asset('custom/scss/main.css') !!}">
@stop

@section('body-attributes')
@stop

@section('content')
@include('templateadmin.parts.body.~messages')
    <div ui-view></div>

@include('template.parts.~service')
@include('template.parts.~steps')
<div class="row">
        @include('template.parts.body.~new-page-slider')
    </div>

@stop


