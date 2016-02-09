<table class="bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Mesaj</th>
        <th>Data</th>
    </tr>
    </thead>
    @foreach($solicitari as $k => $solicitare)
        <tr>
            <td>{!! $k !!}</td>
            <td>{!! $solicitare->details !!}</td>
            <td>{!! $solicitare->created_at  !!}</td>
        </tr>
    @endforeach

</table>

