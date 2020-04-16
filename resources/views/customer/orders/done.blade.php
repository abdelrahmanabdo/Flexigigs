<script type="text/javascript">
		$('body').on('click','.confirmOrder',function () {
        var item = $(this);
        order_id = item.data('id');
        status = item.data('status');
        swal({
          title: "@lang('orders.dashboard_customer_orders_done_confirmation')",
          text: "@lang('orders.dashboard_customer_orders_done_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(done) {
            if (done) {
              $.ajax({
                  url: '{{url("api/orders/status")}}/'+order_id,
                  data:{"status":status},
                  headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                  type: 'POST',
                  success: function(result) {
                    // $('.gig'+order_id).remove();
                    $(this).remove();
                    swal("@lang('orders.dashboard_customer_orders_done_success')!", "@lang('orders.dashboard_customer_orders_done_success_msg')", "success").then(function(refresh){
                      window.location = "{{ url(app()->getLocale().'/customer/dashboard/orders') }}";
                    });
                  }
              });
            }
        });
    });
</script>