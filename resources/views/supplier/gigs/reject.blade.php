<script type="text/javascript">
  $('body').on('click','.rejectOrder',function () {
        var item = $(this);
        order_id = item.data('id');
        falier = item.data('falier');
        swal({
          title: "@lang('gigs.dashboard_supplier_gh_reject_title')",
          text: "@lang('gigs.dashboard_supplier_gh_reject_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(done) {
            if (done) {
              $.ajax({
                  url: '{{url("api/orders/reject")}}/'+order_id,
                  data:{"falier":falier},
                  type: 'POST',
                  headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                  success: function(result) {
                    $(this).remove();
                    swal("@lang('gigs.dashboard_rejected_success')", "@lang('gigs.dashboard_rejected_success_msg')", "success").then(function(refresh){
                      window.location = "{{ route('supplier_gigs') }}";
                    });
                  }
              });
            }
        });
    });
</script>