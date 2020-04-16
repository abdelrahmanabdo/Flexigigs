<script type="text/javascript">
	$('body').on('click','.claim_refund',function () {
    var order_id = $(this).data('id');
    $.ajax({
        url: '{{url("api/orders/refund")}}/'+order_id,
        data:{"claim_refund":1},
        headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
        type: 'POST',
        success: function(result) {
          // $('.gig'+order_id).remove();
          $('#claim-refund-'+order_id).modal('hide');
          swal("@lang('orders.dashboard_customer_claim_refund_success')!", "@lang('orders.dashboard_customer_claim_refund_msg_success')", "success").then(function(refresh){
            @if(Request::segment(2)=="customer")
            window.location = "{{ url(app()->getLocale().'/customer/dashboard') }}/refund?order_id="+order_id;
            @else
            window.location = "{{ url(app()->getLocale().'/admin/dashboard') }}/refund?order_id="+order_id;
            @endif
          });
        }
    });
  });
</script>