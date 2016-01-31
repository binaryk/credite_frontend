<table>
	<tr>
		<td style="padding:10px">
			<p>
				You made this order on site <a href="http://www.norwitchtransfer.uk">www.norwitchtransfer.uk</a> :<br/>
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
					<td style="text-align:left; padding-left:4px"><b>{!! $data['time_string'] .' , '. $data['diff'] !!}</b><td>
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
				<tr>
					<td style="text-align:left; padding-right:4px">Pay cash: <td>
					<td style="text-align:left; padding-left:4px"><b>{!! $data['pay_cash'] == '1' ? 'Yes' : 'No' !!}</b><td>
				<tr>
			</table>
		</td>
	</tr>
</table>