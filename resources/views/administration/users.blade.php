
@extends('templateadmin.layout')

@section('content')

<div class="row">
	<div class="col-xs-12"> 
		<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-comments"></i>Users
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
										 Name
									</th>
									<th>
										 Email
									</th>
									<th>
										 Phone
									</th>
									<th>
										 Created at
									</th>
									<th>
										 Last visit
									</th>
									<th>
										 Orders
									</th>
								</tr>
								</thead>
								<tbody>
								@foreach($users as $key => $user)
								<tr>
									<td>
										 {!! $key !!}
									</td>
									<td class="active">
										 {!! $user->name !!}
									</td>
									<td class="success">
										 {!! $user->email !!}
									</td>
									<td class="warning">
										 {!! $user->phone !!}
									</td>
									<td class="success">
										 {!! $user->created_at !!}
									</td>
									<td class="success">
										 {!! $user->updated_at !!}
									</td>
									<td class="danger">
										 <a href="#">View orders</a>
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
@stop