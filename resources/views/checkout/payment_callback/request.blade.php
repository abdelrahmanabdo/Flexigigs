@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<section class="mb-0" id="service-order-confirm">
	<div class="container">
		<div class="row">
			<div class="text-center col-lg-2" id="confirmation-icon">
				<i class="fas fa-check fa-6x bg-primary text-white pl-4 pr-4 pt-4 pb-4 mt-lg-4 rounded-circle"></i>
			</div>
			<div class="text-left col-lg-10" id="confirmation-msg">
				<h1 class="text-primary text-uppercase font-weight-bold mt-0 mb-4">@lang('orders.requests.success_confirm.msg')</h1>
				<p class="text-dark text-capitalize font-weight-light mt-4 mb-4 h4">@lang('orders.requests.success_confirm.sub_msg')</p>
				<p class="tex-dark text-capitalize mt-4 mb-5">
					<b class="mr-4">@lang('orders.requests.success_confirm.order_number')</b> {{$order->id}}
				</p>
				<a href="{{(Auth::user()->hasRole('admin'))?route('admin_orders',['order_id'=>$order->id]):route('customer_orders',['order_id'=>$order->id])}}" class="text-primary text-capitalize float-right">
					@lang('orders.requests.success_confirm.go_to_order_page') <i class="icon-angle-right ml-3"></i>
				</a>
			</div>
		</div>
	</div>
</section>
@endsection