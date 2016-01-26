@extends('emails.template.email-base')

@section('rand-1')
In atenţia dvs.<br/>
Stimate client,
 <p> Ați primit o invitație de la utilizatorul: <strong> {!! $user->name !!}</strong>, ce deține email-ul: <strong> {!! $user->email !!} </strong> pe aplicația WiseStartup, pentru a o accepta accesați link-ul de mai jos: </p>
<p> <a href="{!! url('auth/invitation/' .$user->id. '/'.$invitation->token) !!} ">acceptă invitația.</a></p>
@stop
