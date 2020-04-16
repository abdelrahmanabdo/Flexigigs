<script type="text/javascript">
    $('body').on('click','.torefund',function () {
        var item = $(this);
        order_id = item.data('id');
        swal({
          title: "@lang('orders.dashboard_admin_change_to_refund_confirmation')",
          text: "@lang('orders.dashboard_admin_change_to_refund_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(done) {
            if (done) {
              $.ajax({
                  url: '{{route("changeToRefund")}}',
                  data:{"order_id[]":order_id,'_token':$('meta[name="csrf-token"]').attr('content')},
                  type: 'POST',
                  success: function(result) {
                    swal("@lang('orders.dashboard_admin_change_to_refund_success')", "@lang('orders.dashboard_admin_change_to_refund_success_msg')", "success").then(function(refresh){
                      location.reload();
                    });
                  }
              });
            }
        });
    });
</script>