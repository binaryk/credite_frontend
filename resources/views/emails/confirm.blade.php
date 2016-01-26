@extends('emails.template.email-base')
@section('rand-1')
In atenţia dvs.<br/>
Stimate client,
@stop
@section('body') 
Click <a href="{{ url('account/confirm/' . $token) }}">aici</a> pentru a activa contul.
@stop


 

