<script type="text/javascript">
    $('.btnActive').on('click',function (e) {
        swal({
          title: "@lang('user.admin_users_profiles.active_msg_confirmation')",
          text: "@lang('user.admin_users_profiles.active_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                user_id = $(this).data('id');
                $.ajax({
                    url: '{{url("api/varify")}}?id='+user_id,
                    type: 'GET',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    success: function(result) {
                        // $('.editimg-'+user_id).remove();
                        swal("@lang('user.admin_users_profiles.active_active')", "@lang('user.admin_users_profiles.active_active_msg')", "success")
                        .then((ok)=>{
                            location.reload();
                        });

                    }
                });
          }
        });
    });
</script>