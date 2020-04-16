<script type="text/javascript">
    $('.deleteservice').on('click',function (e) {
      var item = $(this);
       service_id = item.data('id');
        swal({
          title: "@lang('service_category.dashboard_supplier_service_confirm_title')",
          text: "@lang('service_category.dashboard_supplier_service_confirm_text')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function (willDelete){
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/services")}}/'+service_id,
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    type: 'DELETE',
                    success: function(result) {
                        $('.service'+service_id).remove();
                        swal("@lang('service_category.dashboard_supplier_service_confirm_deleted')", "@lang('service_category.dashboard_supplier_service_confirm_deleted_msg')", "success");

                    }
                });
          }
        });
    });
</script>