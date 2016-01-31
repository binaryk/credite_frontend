@extends('emails.template.email-base')

@section('rand-1')
Hi, {!! $data['name'] !!}!
@stop