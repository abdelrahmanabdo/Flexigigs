<div class="modal fade bd-example-modal-lg extend_deadline-modal" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg bg-white" role="document">
        <div class="modal-content bg-white">
            <form id="extend_deadline" onreset="$('.extend_deadline-modal').modal('hide');$('#extend_deadline')[0].reset();" method="post">
                {{csrf_field()}}
                <input type="hidden" name="id">
                <div class="modal-header">
                  <h5 class="modal-title">@lang('general.extend_deadline')</h5>
                  <button type="reset" class="close text-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                  <div class="form-group m-0">
                    <div class="d-flex flex-column justify-content-between">
                      <div class="d-flex align-items-center justify-content-between">
                        <input type="text" name="delivery_at" required id="deadlineDatePicker" class="form-control datepicker pl-0" placeholder="@lang('gigs.dashboard_customer_posts_project.deadline')">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between m-0 pt-0">
                  <button class="btn btn-outline-primary text-uppercase font-weight-bold w-50" type="reset">@lang('general.button_cancel')</button>
                  <button class="btn btn-primary text-uppercase font-weight-bold w-50" type="submit">@lang('general.button_confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
		$('body').on('click','.extend_deadline',function () {
        var item = $(this);
        var order_id = item.data('id');
        $('.extend_deadline-modal input[name="id"]').val(order_id);
        $('.extend_deadline-modal').modal('show');
        $('body').on('submit','#extend_deadline',function () {
          event.preventDefault();
          var deadlineDatePicker = $('#deadlineDatePicker').val();
          $.ajax({
            url: '{{url("api/orders/extend")}}/'+order_id,
            data:{"delivery_at":deadlineDatePicker},
            headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
            type: 'POST',
            success: function(result) {
              $(this).remove();
              swal("@lang('orders.dashboard_customer_orders_done_success')!", "@lang('orders.dashboard_customer_orders_done_success_msg')", "success").then(function(refresh){
                window.location = "{{route('customer_orders')}}";
              });
            }
          });
        });
    });
</script>