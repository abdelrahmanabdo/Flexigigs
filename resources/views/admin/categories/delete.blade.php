<script type="text/javascript">
    $('.deleteCat').on('click',function (e) {
        var cat = $(this);
        id = cat.data('deleteid');
        type = cat.data('type');
        if(type === 'parent'){
            swal("@lang('service_category.dashboard_admin_category_warning_title')", "@lang('service_category.dashboard_admin_category_warning_text')", "danger");
        }else{
            swal({
              title: "@lang('service_category.dashboard_admin_category_confirm_title')",
              text: "@lang('service_category.dashboard_admin_category_confirm_text')",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then(function(willDelete) {
              if (willDelete) {
                $.ajax({
                    url: '{{url("api/category")}}/'+id,
                    type: 'DELETE',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    data: { _token:$('meta[name="csrf-token"]').attr('content')},
                    success: function(result) {
                      $('.category-'+id).remove();
                      swal("@lang('service_category.dashboard_admin_category_delete_title')", "@lang('service_category.dashboard_admin_category_delete_msg')", "success").then(function(deleting){
                        if (deleting) {
                         window.location = "{{ url(app()->getLocale().'/admin/categories') }}";
                        }
                      });
                    }
                });
              } else {
                swal("@lang('service_category.dashboard_admin_category_save_item')");
              }
            });
           
        }
    });
</script>