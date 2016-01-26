<div class="row">
    <div class="col-xs-12">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-requests"></i>Orders
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
                                From
                            </th>
                            <th>
                                To
                            </th>
                            <th>
                                Personal Data
                            </th>
                            <th>
                                Pick up date
                            </th>
                            <th>
                                Meet and greet
                            </th>
                            <th>
                                Return
                            </th>
                            <th>
                                Details
                            </th>
                            <th>
                                Created at
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $key => $request)
                            <tr data-id="{!! $request->id !!}">
                                <td>
                                    {!! $key !!}
                                </td>
                                <td class="active">
                                    {!! \Easy\Form\StringHelper::Items( [ $request->from, $request->from_nr] ) !!}
                                </td>
                                <td class="success">
                                    {!! \Easy\Form\StringHelper::Items( [ $request->to, $request->to_nr] ) !!}
                                </td>
                                <td class="warning">
                                    {!! \Easy\Form\StringHelper::Items( [ $request->name, $request->email, $request->phone] ) !!}
                                </td>
                                <td class="success">
                                    {!! $request->up_date_time !!}
                                </td>
                                <td class="success">
                                    {!! \Easy\Form\StringHelper::Checked($request->meet_and_greet) !!}
                                </td>
                                <td class="success">
                                    {!! \Easy\Form\StringHelper::Checked($request->return_50) !!}
                                </td>
                                <td class="success">
                                    {!! $request->details !!}
                                </td>
                                <td class="success">
                                    {!! $request->created_at !!}
                                </td>
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