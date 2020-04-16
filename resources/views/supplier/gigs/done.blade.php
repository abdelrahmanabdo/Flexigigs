<script type="text/javascript">
	$('body').on('click','.btn-done',function () {
        var item = $(this);
        status_num = item.data('status');
        order_id = item.data('id');
        check_title = item.data('title');
        check_desc = item.data('desc');
        message_title = item.data('message-title');
        message_desc = item.data('message-desc');
        swal({
          // title: "@lang('gigs.dashboard_supplier_gigs_done_confirmation')",
          // text: "@lang('gigs.dashboard_supplier_gigs_done_msg')",
          title: check_title,
          text: check_desc,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(done) {
            if (done) {
              $.ajax({
                  url: '{{url("api/orders/status")}}/'+order_id,
                  data:{"status":status_num},
                  type: 'POST',
                  headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                  success: function(result) {
                    // $('.gig'+order_id).remove();
                    $(this).remove();
                    // swal("@lang('gigs.dashboard_supplier_gigs_done_success')", "@lang('gigs.dashboard_supplier_gigs_done_success_msg')", "success").then(function(refresh){
                    swal(message_title, message_desc, "success").then(function(refresh){
                    @if(Request::segment(2)=="supplier")
                      window.location = "{{ route('supplier_gigs') }}";
                    @else
                      window.location = "{{ route('admin_orders') }}";
                    @endif
                    });
                  }
              });
            }
        });
    });
</script>