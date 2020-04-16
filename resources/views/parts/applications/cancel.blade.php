<script type="text/javascript">
    
    $('.cancel-application').on('click',function (e) {
        var item = $(this);
        swal({
          title: "@lang('gigs.dashboard_supplier_apps_cancel_confirmation')",
          text: "@lang('gigs.dashboard_supplier_apps_cancel_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
          if (willDelete) {
              application_id = item.data('id');
              $.ajax({
                  url: '{{url("api/application/delete")}}/'+application_id,
                  type: 'DELETE',
                  headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                  data: { _token:$('meta[name="csrf-token"]').attr('content')},
                  success: function(result) {
                    swal("@lang('gigs.dashboard_supplier_apps_canceled')", "@lang('gigs.dashboard_supplier_apps_canceled_msg')", "success").then((refresh)=>{
                      reloadAsGet();
                    });
                  }
              });
          }
        });
    });
</script>