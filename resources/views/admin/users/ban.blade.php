<script type="text/javascript">
    $('.btnBan').on('click',function (e) {
        swal({
          title: "@lang('user.admin_users_profiles.ban_msg_confirmation')",
          text: "@lang('user.admin_users_profiles.ban_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                user_id = $(this).data('id');
                $.ajax({
                    url: '{{url("api/pending")}}?id='+user_id,
                    type: 'GET',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    success: function(result) {
                        // $('.editimg-'+user_id).remove();
                        swal("@lang('user.admin_users_profiles.ban_delete')", "@lang('user.admin_users_profiles.ban_delete_msg')", "success").then((ok)=>{
                            location.reload();
                        });

                    }
                });
          } 
        });
    });
</script>