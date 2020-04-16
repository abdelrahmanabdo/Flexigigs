<script type="text/javascript">
  $('body').on('click','.deletefavorite',function (e) {
        var item = $(this);
        id = item.data('id');
        swal({
          title: "@lang('service_category.dashboard_admin_service_confirm_title')",
          text: "@lang('service_category.dashboard_admin_service_confirm_text')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function (willDelete) {
          if (willDelete) {
            $.post('{{url("en/favorite/delete")}}',
                    { _token:$('meta[name="csrf-token"]').attr('content'),
                      service_id: id,
                      user_id: {{Auth::user()->id}} 
                    })
            .done(function(content){
              if (content.status) {
                swal("@lang('general.alert.delete.title')", "@lang('general.alert.delete.body')", "success");
                }else{
                    swal("@lang('general.alert.alradyDeleted.title')", "@lang('general.alert.alradyDeleted.body')", "warning");
                }
                @if (Request::segment(3)=="dashboard")
                $("#service-"+content.delete.service_id).empty();
                @else
                $(".deletefavorite[data-id='"+id+"']").addClass('addtofavorite').removeClass('deletefavorite').html('<i class="icon-heart"></i>@lang("general.button_favorites")');
                @endif
            });
          }
        });
    });
</script>