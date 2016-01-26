<link rel="stylesheet" href="{!! asset('packages/datatables/css/1.10.4/datatable.css') !!}" />
<script src="{!! asset('packages/datatables/js/1.10.4/datatable.js') !!}"></script>
<script>
    $(document).ready(function(){
//       var dt = $('#terrains').DataTable();

        $('.validation').click(function(){
            var id = $(this).closest('tr').data('id');
            console.log(id);
            
            $.ajax({
                method: "POST",
                url: "{!! route('comment.validation') !!}",
                data: {id: id}
            }).done(function(res){
              console.log(res);
              location.reload();
            })
        })
    });
</script>