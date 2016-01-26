<div class="col-md-6">
    <h3>Details</h3>
    <ul>
        <li>
            From: <b> {!! \Easy\Form\StringHelper::Items( [ $request->from, $request->from_nr] ) !!}</b>
        </li>
        <li>
            To: <b> {!! \Easy\Form\StringHelper::Items( [ $request->to, $request->to_nr] ) !!}</b>
        </li>
        <li>
            Customer: <b> {!! \Easy\Form\StringHelper::Items( [ $request->name, $request->email, $request->phone] ) !!}</b>
        </li>
        <li>
            Up date: <b> {!! $request->up_date_time !!}</b>
        </li>
        <li>
            Meet and greet: <b> {!! \Easy\Form\StringHelper::Checked($request->meet_and_greet) !!}</b>
        </li>
        <li>
            Return: <b> {!! \Easy\Form\StringHelper::Checked($request->return_50) !!}</b>
        </li>
        <li>
            Details: <b> {!! $request->details !!}</b>
        </li>
        <li>
            Created at: <b> {!! $request->created_at !!}</b>
        </li>
        </tr>
    </ul>
</div>
<div class="col-md-6">
    <h3>Responses</h3>
    <ul>
        @foreach($request->responses as $k => $response)
        <li>
            Price: <b>{!! $response->price !!}</b>
            <br>
            Message: <b>{!! $response->message !!}</b>
        </li>
        @endforeach
    </ul>
</div>