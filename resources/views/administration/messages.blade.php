
@extends('templateadmin.layout')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-comments"></i>Reviews
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Author
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Message
                                </th>
                                <th>
                                    Created at
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $key => $comment)
                                <tr data-id="{!! $comment->id !!}">
                                    <td>
                                        {!! $key !!}
                                    </td>
                                    <td class="active">
                                        {!! $comment->author !!}
                                    </td>
                                    <td class="success">
                                        {!! $comment->email !!}
                                    </td>
                                    <td class="warning">
                                        {!! $comment->title !!}
                                    </td>
                                    <td class="success">
                                        {!! $comment->message !!}
                                    </td>
                                    <td class="success">
                                        {!! $comment->created_at !!}
                                    </td>
                                    <td class="danger validation"><a>{!! \Easy\Form\StringHelper::Checked($comment->valid) !!}</a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@stop
@section('custom-scripts')
    @parent
    @include('administration.script')
@endsection