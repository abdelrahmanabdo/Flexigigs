@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header alt py-4">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('service_details',[$order->request->service->id])}}">{{$order->request->service->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.button_request')</li>
        </ol>
    </nav>
    <div class="container my-4">

        <p>@lang('orders.requests.proceed_to_payment.title')</p>
    </div>
</div>
<section id="service-request">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
				
				<div class="side py-4 px-2">
					<div class="container">
						<div class="row">
							<div class="col-12 mb-3">
								<h2 class="font-weight-bold">@lang('orders.requests.proceed_to_payment.payment')</h2>
							</div>
							<div class="col-12 mb-3 d-flex flex-column align-items-start justify-content-start">
								<h4 class="font-weight-bold lato-bold">{{trans_choice('orders.requests.payment_card.pay_total', $order->request->service->price_data->total_handling, ['total_number' => $order->request->service->price_data->total_handling])}}</h4>
								<p class="text-dark m-0">{{($order->request->service->price_unit === "hour")?$order->request->service->price_data->formated_price." X ".$order->request->service->days_to_deliver." = ".$order->request->service->price_data->formated_price:$order->request->service->price_data->formated_price}} @lang('general.request_service_fees')</p>
								<p class="text-dark m-0">{{trans_choice('orders.requests.payment_card.handeling_fees', $order->request->service->price_data->handling, ['fees_number' => $order->request->service->price_data->handling])}}</p>
								<img class="my-4 img-fluid" style="border-radius: 10px;" src="{{asset('images/fawry.png')}}">
							</div>
							<div class="col-12 mb-3">
								<a href="{{url($fawryLink)}}" class="btn btn-primary w-100">@lang('orders.button_continue_payment')</a>
							</div>
							<div class="col-12 mb-3">
								<h5>4 testing only</h5>
                        		<a href="{{route('payment_callback',['order_id'=>$order->id,'semulate'=>true])}}" class="btn btn-success w-100">success payment</a>
                        		<a href="{{route('payment_callback',['order_id'=>$order->id,'semulate'=>false])}}" class="btn btn-danger w-100">falier payment</a>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div class="col-md-8">
				<div class="side p-0">
					<div class="container">
						<div class="side-head row m-0">
							<div class="col-12 p-3 border border-top-0 border-left-0 border-right-0">
								<h2 class="text-dark text-capitalize">{{$order->request->name}}</h2>
								<p class="m-0 text-dark">{{Flexihelp::catname($order->request->parent_cat,app()->getLocale(),'array')}} - {{Flexihelp::catname($order->request->sub_cat,app()->getLocale(),'array')}}</p>
								<p class="m-0 text-dark">@lang('orders.dashboard_customer_orders_order_id') : #{{$order->id}}</p>
							</div>
						</div>
						<div class="side-content row m-0 py-4">
						
							<div class="col-12 col-md-6">
								<div class="user d-flex align-items-center justify-content-start">
									<div class="user-img-md m-0 mr-3">
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
									<div class="d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 py-3">
										<p class="m-0 font-weight-bold">@lang('orders.dashboard_customer_orders_info.price')</p>
										<p class="m-0 text-primary">{{number_format($order->request->price)}} @lang('general.service_price_unit_EGP')</p>
									</div>
									<div class="d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 py-3">
										<p class="m-0 font-weight-bold">@lang('orders.dashboard_customer_orders_info.date_requiested')</p>
										<p class="m-0 text-secondary">{{Flexihelp::defult_date($order->created_at)}}</p>
									</div>
									<div class="d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 py-3">
										<p class="m-0 font-weight-bold">@lang('orders.dashboard_customer_orders_info.deadline')</p>
										<p class="m-0 text-secondary">{{$order->request->days_to_deliver}}  @if ($order->request->price_unit=="hour") @lang('orders.dashboard_customer_orders_info.status.hours') @else @lang('orders.dashboard_customer_orders_info.status.days') @endif</p>
									</div>
									<div class="d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 py-3">
										<p class="m-0 font-weight-bold">@lang('orders.dashboard_customer_orders_info.status.title')</p>
										<p class="m-0 text-secondary">{{$order->order_status}}</p>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="item-requirment mb-3">
									<label class="font-weight-bold mb-2">{{$order->request->question1}}</label>
									<p class="text-secondary font-weight-normal m-0">{{$order->request->answer1}}</p>
								</div>
								@if($order->request->question2)
								<div class="item-requirment mb-3">
									<label class="font-weight-bold mb-2">{{$order->request->question2}}</label>
									<p class="text-secondary font-weight-normal m-0">{{$order->request->answer2}}</p>
								</div>
								@endif
								@if($order->request->question3)
								<div class="item-requirment mb-3">
									<label class="font-weight-bold mb-2">{{$order->request->question3}}</label>
									<p class="text-secondary font-weight-normal m-0">{{$order->request->answer3}}</p>
								</div>
								@endif
								@if($order->request->notes)
								<div class="item-requirment mb-3">
									<label class="font-weight-bold mb-2">@lang('ordestatus.requested.customer_note')</label>
									<p class="text-secondary font-weight-normal m-0">{{$order->request->notes}}</p>
								</div>
								@endif
							</div>

						</div>		
					</div>
				</div>
            </div>
        </div>
    </div>
</section>
@endsection