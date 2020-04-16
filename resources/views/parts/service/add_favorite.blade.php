<script type="text/javascript">
  $('body').on('click','.addtofavorite',function (e) {
        var item = $(this);
        id = item.data('id');
        $.post('{{url("en/favorite/add")}}',
                { _token:$('meta[name="csrf-token"]').attr('content'),
                  service_id: id,
                  user_id: {{@Auth::user()->id}} 
                })
        .done(function(content){
        	if (content.status) {
        		swal("@lang('general.alert.saved.title')", "@lang('general.alert.saved.body')" , "success");
                $(".addtofavorite[data-id='"+id+"']").addClass('deletefavorite').removeClass('addtofavorite').html('<i class="icon-heart"></i>@lang("general.button_delete")');
        	}else{
        		swal("@lang('general.alert.alreadySaved.title')", "@lang('general.alert.alreadySaved.body')", "warning");
        	}
        });
    });
</script>