@extends('template.layout')

{{-- Web site Title --}}
@section('title') {{{ trans('site/user.login') }}} :: @parent @stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="page-header">
            <h2> Intră în contul tău </h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Login</div>--}}
                    {{--<div class="panel-body">--}}

                        @include('errors.list')

                        <form class="form-horizontal" role="form" method="POST" action="{{ URL::to('/auth/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Adresa de email</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Parola</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Retine-ma
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Intra
                                    </button>

                                    <a href="{{ URL::to('/password/email') }}">Ai uitat parola ?</a>
                                </div>
                            </div>
                        </form>
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection
