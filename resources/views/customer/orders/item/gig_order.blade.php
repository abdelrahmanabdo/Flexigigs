<div class="item">
    <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList" data-target="#order-{{$order->id}}" aria-expanded="false">
        <div class="item-info-collapsed">
			<div class="col-3 d-flex flex-row justify-content-start align-items-center">
				<span>#{{$order->id}}</span>
				<span class="text-dark ml-4">{{$order->application->title}}</span>
			</div>
            <div class="col-2 d-flex justify-content-start">
				<div class="user w-100 d-flex">
					<div class="user-img-sm m-0">
						<div class="user-img-sm-container">
							<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
						</div>
					</div>
					<div>
						<p>{{$order->supplier->username}}</p>
					</div>
				</div>
            </div>
			<div class="col-{{($order->status == 2)?'3':'5'}} d-flex flex-row justify-content-between flex-nowrap">
				<p>@lang('orders.dashboard_customer_orders_info.requested') {{Flexihelp::defult_date($order->created_at)}}</p>
				@if($order->status != 2)
                <p>@lang('orders.dashboard_customer_orders_info.deadline') {{Flexihelp::defult_date($order->application->deadline)}}</p>
                @endif
            </div>
            <div class="col-{{($order->status == 2)?'4':'2'}} d-flex align-items-center justify-content-between p-0">
                <span class="pr-4">{{number_format($order->application->price)}} @lang('general.service_price_unit_EGP')</span>
                @if($order->status == 3)
					@if ($order->ser_review)
					<button type="button" class="btn btn-default confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_confirm_done')</button>
					@else
					<button type="button" class="btn btn-default cantconfirm" data-id="{{$order->id}}">@lang('general.button_confirm_done')</button>
					@endif
				@endif
				<i class="icon-angle-down align-self-end"></i>
			</div>
        </div>
        <div class="item-info row">
            <div class="mr-auto col-lg-6 col-md-12">
                <h2>{{$order->application->title}}</h2>
                @if($order->application->skills)
                <p>@foreach($order->application->skills as $skill){{@$skill->category->name}} - @endforeach</p>
                @endif
                <p>@lang('orders.dashboard_customer_orders_order_id') #{{$order->id}}</p>
            </div>
            <div class="col-lg-6 col-md-12 text-right">
                @if($order->status >= 2 && $order->status < 4)
                    <a href="#" data-order_id="{{$order->id}}" class="reportconflect">@lang('general.button_report_conflict')</a>
                @endif
                @if($order->status == 2)
                    @if ($order->ser_review)
                        <button type="button" class="btn btn-default confirmOrder" data-id="{{$order->id}}">@lang('general.button_confirm_done')</button>
                    @else
                        <button type="button" class="btn btn-default cantconfirm">@lang('general.button_confirm_done')</button>
                    @endif
                @endif
                <i class="icon-angle-down"></i>
            </div>
        </div>
    </div>
    <div id="order-{{$order->id}}" class="item-content collapse" role="tabpanel">
        @if($order->order_hhmessage)
		<div class="col-12 mt-4">
			<div class="alert alert-dark rounded-0" role="alert">
                {{$order->order_hhmessage}}
            </div>
		</div>
        @endif
        <div class="row pt-5">
            <div class="col-12 col-lg-4">
                <div class="user">
                    <div class="user-img-md mx-0 mr-2">
						<div class="user-img-md-container">
							<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
						</div>
					</div>
                    <div>
                        <a href="{{route('supplier_profile',['username'=>$order->supplier->username])}}" title="">
                            <p>{{$order->supplier->username}}</p>
                        </a>
                        <?=Flexihelp::get_stars('supplier',$order->supplier->id)?>
                    </div>
                </div>
                <div class="item-status">
                    <div class="d-flex justify-content-between">
                        <label>@lang('orders.dashboard_customer_orders_info.price')</label>
                        <p>{{number_format($order->application->price)}} @lang('general.service_price_unit_EGP')</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('orders.dashboard_customer_orders_info.date_requiested')</label>
                        <p>{{Flexihelp::defult_date($order->created_at)}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('orders.dashboard_customer_orders_info.deadline')</label>
                        <p>{{Flexihelp::defult_date($order->delivery_at)}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('orders.dashboard_customer_orders_info.status.title')</label>
                        <p> {{$order->order_status}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="item-requirment">
                    <label class="font-weight-bold">@lang('orders.dashboard_customer_orders_info.description')</label>
                    <p>{{$order->application->description}}</p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                @if($order->status == 0 && $order->falier == 0)
                <!-- <p>test</p> -->
                @elseif($order->status == 1 && $order->falier == 0 && !$order->payment && !$order->delivery_status->created_exed_24hh)
                <a href="{{route('proceed_to_payment',['order_id'=>$order->id])}}" class="btn btn-primary mt-2 text-capitalize col-12" data-id="{{$order->id}}">@lang('general.button_proceed_To_payment')</a>
                @elseif($order->status >= 3 && $order->falier == 0)
                    @include('reviews.form')
                @elseif($order->status == 2 && $order->falier == 0)
                    <button class="btn btn-primary mt-2 text-uppercase col-12 extend_deadline" data-id="{{$order->id}}">@lang('general.extend_deadline')</button>
                    @if($order->delivery_status->after_4days)
                    <button class="btn btn-outline-danger mt-2 text-uppercase col-12" type="button" data-toggle="modal" data-target="#claim-refund-{{$order->id}}">@lang('general.claim_refund')</button>                   
                    <div class="modal fade bd-example-modal-lg" id="claim-refund-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="claim-refund-{{$order->id}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg bg-white" role="document">
                            <div class="modal-content bg-white">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark text-uppercase" id="claim-refund-{{$order->id}}Label">claim refund</h5>
                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-dark h4">are you sure you want to cancel ypur order and recive the service refund?</p>
                                <p class="text-dark h4">IF you confirm you can follow yout refund process from the refunds tab.</p>
                            </div>
                            <div class="modal-footer d-flex align-items-center justify-content-between m-0 pt-0">
                                <button type="button" class="btn btn-outline-primary text-uppercase font-weight-bold w-50" data-dismiss="modal">@lang('general.button_cancel')</button>
                                <button type="button" class="btn btn-primary text-uppercase font-weight-bold w-50  claim_refund" data-id="{{$order->id}}">@lang('general.claim_refund')</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endif  
                @else
                @endif
            </div>
        </div>
    </div>
</div>