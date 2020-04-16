<?php
if (Request::segment(2)=='supplier') {
    $order = $gig;
} 
 ?>
@if(Auth::user()->id==$order->supplier_id||(Auth::user()->id==$order->customer_id))
<?php 
$user_id = $order->customer_id;
$supplier_id = $order->supplier_id;
// add review to service or gig
if ($order->type==1){
    $item_id =$order->request->service_id;
}else{
    $item_id =$order->application->gig_id;
}
if (Auth::user()->id==$order->supplier_id) {
    $review = $order->cus_review;
    $title = ($review)?trans('gigs.single_reviewed_msg'):trans('general.button_add_review');
    $review_type = 2;
}else{
    $review = $order->ser_review;
    $title = ($review)?trans('orders.dashboard_customer_orders_reviewd_msg'):trans('orders.dashboard_customer_orders_add_review');
    $review_type = 1;
}
?>
<div class="item-review">
    <h4>@if ($review) @lang('orders.dashboard_customer_orders_reviewd_msg') @else @lang('orders.dashboard_customer_orders_add_review') @endif</h4>
    <form action="{{($review)?url('api/review/edit/'.$review->id):url('api/review/add/'.$review_type)}}" class="reviewsform-{{$order->id}}" id="reviews-{{$order->id}}" data-id="{{$order->id}}">
        <input type="hidden" name="user_id" value="{{$order->customer_id}}"> <!-- customer -->
        <input type="hidden" name="supplier_id" value="{{$order->supplier_id}}"> <!-- supplier -->
        <input type="hidden" name="order_id" value="{{$order->id}}">
        <input type="hidden" name="item_id" value="{{$item_id}}"> <!-- gig or service -->
        <div class="d-flex justify-content-between flex-column review-rate">
            <label>@lang('orders.dashboard_customer_orders_info.rating')</label>
            <select name="rate" class="user-rating" data-readonly='{{($review)?"true":"false"}}'>
                <option value=""  {{($review&&$review->rate==0)?"selected":""}}></option>
                <option value="1" {{($review&&$review->rate==1)?"selected":""}}>1</option>
                <option value="2" {{($review&&$review->rate==2)?"selected":""}}>2</option>
                <option value="3" {{($review&&$review->rate==3)?"selected":""}}>3</option>
                <option value="4" {{($review&&$review->rate==4)?"selected":""}}>4</option>
                <option value="5" {{($review&&$review->rate==5)?"selected":""}}>5</option>
            </select>
            <p class="d-none help-block"></p>
        </div>
        <label for="" class="form-group has-float-label review-comment">
            <textarea name="comment" rows="1" class="form-control counted mt-5" placeholder="@lang('orders.dashboard_customer_orders_add_review')" {{($review)?'disabled':''}}>{{($review)?$review->comment:""}}</textarea>
            <span>@lang('orders.dashboard_customer_orders_add_review')</span>
            <p class="d-none help-block"></p>
            <p class="char">0/1000</p>
        </label>
        <button type="submit" class="btn btn-primary btn-block mt-5 submit {{($review)?'d-none':''}}">@lang('general.button_post_review')</button>
        <button type="button" onclick="$('#reviews-{{$order->id}} .user-rating').barrating('readonly',false);$('#reviews-{{$order->id}} .review-comment textarea').removeAttr('disabled');$('#reviews-{{$order->id}} .submit').removeClass('d-none');$(this).addClass('d-none')" class="btn btn-primary btn-block mt-5 {{($review)?'':'d-none'}}">@lang('general.button_edit_review')</button>
    </form>
</div>
<script type="text/javascript">
    $('.reviewsform-{{$order->id}}').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var msgData = form.serialize();
        var action = form.attr('action');
        var id = form.data('id');
        $.ajax({
            type: 'POST', 
            url: action, 
            headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
            data: msgData,
            success: function (message) {
                location.reload();
            },
            error: function (message) {
                reviewErrors = message.responseJSON.message;
                if (reviewErrors.rate) {
                    $('#reviews-'+id+' .review-rate').addClass('has-error');
                    $('#reviews-'+id+' .review-rate .help-block').removeClass('d-none').text(reviewErrors.rate);
                }
                if (reviewErrors.comment) {
                    $('#reviews-'+id+' .review-comment').addClass('has-error');
                    $('#reviews-'+id+' .review-comment .help-block').removeClass('d-none').text(reviewErrors.comment);
                }
                $('#sendbtn').text("@lang('general.button_send')").prop("disabled", false);
            }
        });
    });

</script>
@endif