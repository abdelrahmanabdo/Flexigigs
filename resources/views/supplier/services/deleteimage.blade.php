<script type="text/javascript">
    $('.deleteimg').on('click',function (e) {
        var item = $(this);
         img_id = item.data('id');
        swal({
          title: "@lang('service_category.dashboard_supplier_image_confirm_title')",
          text: "@lang('service_category.dashboard_supplier_image_confirm_text')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/servicesimg")}}/'+img_id,
                    type: 'DELETE',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    success: function(result) {
                        $('.editimg-'+img_id).remove();
                        if (!result.photos) {
                          $('#edit'+result.service_id+'-service .custom-file-input').attr('required',true);
                        }
                        swal("@lang('service_category.dashboard_supplier_image_confirm_deleted')", "@lang('service_category.dashboard_supplier_image_confirm_deleted_msg')", "success");

                    }
                });
          }
        });
    });
</script>