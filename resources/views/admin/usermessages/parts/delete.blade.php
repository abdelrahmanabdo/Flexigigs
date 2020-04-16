<script type="text/javascript">
    $('body').on('click','.del-message',function (e) {
        var item = $(this);
         message_id = item.data('id');
        swal({
          title: "@lang('messages.messages.delete_confirmation')",
          text: "@lang('messages.messages.delete_confitmation_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/message/delete")}}/'+message_id,
                    type: 'DELETE',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    success: function(result) {
                        swal("@lang('messages.messages.deleted')", "@lang('messages.messages.deleted_msg')", "success").then(function (deleted) {
                        	location.reload();
                        });
                    }
                });
	        }
        });
    });
</script>