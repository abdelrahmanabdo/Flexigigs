<div class="item">
    <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList" data-target="#order-{{$order->id}}" aria-expanded="false">
        <div class="item-info-collapsed flex-row justify-content-between">
            <div class="col-3 d-flex flex-row justify-content-start align-items-center">
				<span>#{{$order->id}}</span>
				<span class="text-dark ml-4">{{$order->request->name}}</span>
			</div>
            <div class="col-2 d-flex justify-content-start">
				<div class="user w-100 d-flex justify-content-start">
					<div class="user-img-md mx-0 mr-2">
						<div class="user-img-sm-container">
							<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
						</div>
					</div>
					<div>
						<p>{{$order->supplier->username}}</p>
					</div>
				</div>
			</div>
            <div class="col-{{($order->status == 1)?'5':'3'}} d-flex flex-row justify-content-between flex-nowrap">
				<p>@lang('orders.dashboard_customer_orders_status.requested') {{Flexihelp::defult_date($order->created_at)}}</p>
                @if($order->status == 1)
				<p>{{$order->request->days_to_deliver}} @if ($order->request->price_unit=="hour") @lang('orders.dashboard_customer_orders_info.status.hours') @else @lang('orders.dashboard_customer_orders_info.status.days') @endif @lang('gigs.single_to_deliver')</p>
                @endif
			</div>
            <div class="col-{{($order->status == 1)?'2':'4'}} d-flex align-items-center justify-content-between p-0">
				<span class="mr-4">{{number_format($order->request->price)}} @lang('general.service_price_unit_EGP')</span>
				@if($order->status == 3)
                    @if ($order->ser_review)
                        <button type="button" class="btn btn-default confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_confirm_done')</button>
                    @else
                        <button type="button" class="btn btn-default cantconfirm" data-id="{{$order->id}}">@lang('general.button_confirm_done')</button>
                    @endif

				@elseif($order->status >= 3)
                    @if($order->request->service)
					<button type="button" class="btn btn-default  {{($order->supplier->availability==0)?'orderAgain':'notAvilable'}}" 
                        data-serviceid="{{$order->request->service_id}}"
                         data-categoryslug="{{$order->request->category->slug}}">@lang('general.button_order_again')</button>
                    @else
                    <span class="text-center">@lang('general.service_not_available')</span>
                    @endif
				@endif
				<i class="icon-angle-down  align-self-end"></i>
			</div>
        </div>
        <div class="item-info row">
            <div class="mr-auto col-lg-6 col-md-12">
                <h2>{{$order->request->name}}</h2>
                <p>{{Flexihelp::catname($order->request->parent_cat,app()->getLocale(),'array')}} - {{Flexihelp::catname($order->request->sub_cat,app()->getLocale(),'array')}}</p>
                <p>@lang('orders.dashboard_customer_orders_order_id') : #{{$order->id}}</p>
            </div>
            <div class="col-lg-6 col-md-12 text-right">
                @if($order->status >= 2 && $order->status < 4)
                    <a href="#" data-order_id="{{$order->id}}" class="reportconflect">@lang('general.button_report_conflict')</a>
                @endif
                @if($order->status == 3)
                    <button type="button" class="btn btn-default confirmOrder" data-id="{{$order->id}}">@lang('general.button_confirm_done')</button>
                @elseif($order->status >= 3)
                    @if($order->request->service)
                    <button type="button" class="btn btn-default {{($order->supplier->availability==0)?'orderAgain':'notAvilable'}}" data-serviceid="{{$order->request->service_id}}" data-categoryslug="{{$order->request->category->slug}}">@lang('general.button_order_again')</button>
                    @else
                    <span class="text-center">@lang('general.service_not_available')</span>
                    @endif
                @endif
                <i class="icon-angle-down"></i>
            </div>
        </div>
    </div>
    <div id="order-{{$order->id}}" class="item-content collapse" role="tabpanel">
        <div class="row pt-4">
            @if($order->order_hhmessage)
			<div class="col-12 mt-4">
				<div class="alert alert-dark rounded-0" role="alert">
                    {{$order->order_hhmessage}}
                </div>
			</div>
            @endif
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
                        <p>{{number_format($order->request->price)}} @lang('general.service_price_unit_EGP')</p>
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
                        <p>{{$order->order_status}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="item-requirment">
                    <label class="font-weight-bold">{{$order->request->question1}}</label>
                    <p>{{$order->request->answer1}}</p>
                </div>
                @if($order->request->question2)
                <div class="item-requirment">
                    <label class="font-weight-bold">{{$order->request->question2}}</label>
                    <p>{{$order->request->answer2}}</p>
                </div>
                @endif
                @if($order->request->question3)
                <div class="item-requirment">
                    <label class="font-weight-bold">{{$order->request->question3}}</label>
                    <p>{{$order->request->answer3}}</p>
                </div>
                @endif
                @if($order->request->notes)
                <div class="item-requirment">
                    <label class="font-weight-bold">@lang('gigs.single_notes')</label>
                    <p>{{$order->request->notes}}</p>
                </div>
                @endif
            </div>
            <div class="col-12 col-lg-4">
                @if($order->status == 0 && $order->falier == 0)
                <!-- <p>test</p> -->
                @elseif($order->status == 1 && $order->falier == 0 && !$order->payment) 
                <a href="{{route('proceed_to_payment',['order_id'=>$order->id])}}" class="btn btn-primary mt-2 text-capitalize col-12" data-id="{{$order->id}}">@lang('general.button_proceed_To_payment')</a>
                @elseif($order->status >= 3 && $order->falier == 0)
                    @include('reviews.form')
                @elseif($order->status >= 4 && $order->falier == 0)
                    @if($order->request->service)
                    <button type="button" class="btn btn-default  {{($order->supplier->availability==0)?'orderAgain':'notAvilable'}}" 
                        data-serviceid="{{$order->request->service_id}}"
                         data-categoryslug="{{$order->request->category->slug}}">@lang('general.button_order_again')</button>
                    @else
                    <span class="text-center">@lang('general.service_not_available')</span>
                    @endif
                @elseif($order->status >= 2 && $order->falier == 0)
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
								<button type="button" class="btn btn-outline-primary text-uppercase font-weight-bold w-50" data-dismiss="modal">cancel</button>
								<button type="button" class="btn btn-primary text-uppercase font-weight-bold w-50 claim_refund" data-id="{{$order->id}}">confirm</button>
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