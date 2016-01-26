<table>
	<tr>
		<td style="padding:10px">
			<p>
				<h3>Admin response is:</h3> <b></b>,<br/>
			</p>
		</td>
	</tr>
	<tr>
		<td style="padding:10px">
			<table>
				<tr>
					<td style="text-align:left; padding-right:4px">Price: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $response->price !!}</b><td>
				<tr>
				@if($response->message)
					<tr>
						<td style="text-align:left; padding-right:4px">Message: <td>
						<td style="text-align:left; padding-left:4px"><b>{!! $response->message !!}</b><td>
					<tr>
				@endif
                <tr>
                    <td style="text-align:left; padding-right:4px">Click if you agree: <td>
                    <td style="text-align:left; padding-left:4px"><b>
                            <a href="{!! route('booking.from_request',['request' => $data->id,'response' => $response->id]) !!}">accept</a>
                        </b><td>
                <tr>
			</table>
		</td>
	</tr>
</table>
<hr>
<table>
	<tr>
		<td style="padding:10px">
			<p>
				<h3>Your request is:</h3> <b></b>,<br/>
			</p>
		</td>
	</tr>
	<tr>
		<td style="padding:10px">
			<table>
				<tr>
					<td style="text-align:left; padding-right:4px">From: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['from'] .' '.$data['from_nr'] !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">To: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['to'] . ' '. $data['to_nr'] !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Email: <td>
					<td style="text-align:left; padding-left:4px"><b><a href="mailto:{!! $data['email'] !!}" target="blank">{!! $data['email'] !!}</a></b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Name: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['name'] !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Phone: <td>
					<td style="text-align:left; padding-left:4px"><b><a href="tel:{!! $data['phone'] !!}">{!! $data['phone'] !!}</a></b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Up Date/Hour: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['up_date_time'] !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Details: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['details'] !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Meet and greet: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['meet_and_greet'] == '1' ? 'Yes' : 'No' !!}</b><td>
				<tr>
				<tr>
					<td style="text-align:left; padding-right:4px">Return 50%: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['return_50'] == '1' ? 'Yes' : 'No' !!}</b><td>
				<tr>
			</table>
		</td>
	</tr>
</table>