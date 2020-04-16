<script type="text/javascript">
    $('.del-review').on('click',function (e) {
        var item = $(this);
         id = item.data('id');
        swal({
          title: "@lang('reviews.delete_confirmation')",
          text: "@lang('reviews.delete_confirmation_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/review/delete")}}/'+id,
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    type: 'DELETE',
                    data: { _token:$('meta[name="csrf-token"]').attr('content')},
                    success: function(result) {
                        $('.review-'+id).remove();
                        swal("@lang('reviews.deleted')", "@lang('reviews.deleted_msg')", "success");

                    }
                });
          }
        });
    });
</script>