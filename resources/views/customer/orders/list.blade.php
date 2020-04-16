@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-6">
				<h1 class="text-uppercase text-primary m-0 text-left">headhunter dashboard</h1>
			</div>
			<div class="col-6">
				<nav aria-label="breadcrumb" role="navigation">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
						<li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<?php
$links = "";
 /*foreach($orders as $order){
    if ($order->status >= 2) {
        if (!$order->ser_review) {
            if ($order->type == 1 && $order->request){
                $links.= '<a href="#order-'.$order->id.'" class="alert-link">#'.$order->id.' '.$order->request->name.'</a> , ';
            }elseif($order->type == 2 && $order->application){ 
                $links.='<a href="#order-'.$order->id.'" class="alert-link">#'.$order->id.' '.$order->application->title.'</a> , '; 
            }
        }
    }
}*/ ?>
<section class="container">
	@if ($links)
		<div class="alert alert-warning rounded-0" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>					
			<p style="font-size: 1.3rem;">
				 @lang('orders.dashboard_customer_orders_opinion_msg') <?=$links?>. @lang('orders.dashboard_customer_orders_opinion_click')
			</p>
		</div>
	@endif
    <div class="row">
        <div class="col-md-4">
            @include('customer.parts.sidecard')
            @include('customer.orders.search')
        </div>
        <div class="col-md-8">
            @include('customer.parts.nav')
			<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_my_orders')</p>

            <div class="refund_nav item w-100 d-flex align-items-center justify-content-between bg-transparent px-0 pt-0">
                <a href="{{route('customer_refund')}}" class="btn btn-primary rounded">@lang('general.refund.title')</a>
			</div>
            @if(count($orders))
            <div class="tab-content" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="myOrders" role="tabpanel">
                    <div id="ordersList" data-children=".item">
                        @foreach($orders as $order)
                            @if ($order->type == 1 && $order->request)
                                @include('customer.orders.item.service_order')
                            @elseif ($order->type == 2 && $order->application)
                                @include('customer.orders.item.gig_order')
                            @endif
                        @endforeach

                        <!-- Modal orderagain-->
                        <div class="modal fade" id="orderagainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-light text-dark">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">@lang('orders.dashboard_customer_orders_order_again')</h5>
                                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center lead">
                                            @lang('orders.dashboard_customer_orders_order_again_msg')
                                        </p>
                                    </div>
                                    <div class="modal-footer pt-0 pb-0">
                                        <div class="container">
                                            <div class="row">
                                                <button type="button" class="col-sm-6 btn btn-outline-primary btn-sm text-uppercase" data-dismiss="modal">@lang('general.button_cancel') </button>
                                                <a href="#" class="col-sm-6 btn btn-primary btn-sm text-uppercase confirmbtn">@lang('general.button_confirm')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal with no Gighunter available -->
                        <div class="modal fade" id="noGigHunter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-light text-dark">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabe">@lang('orders.dashboard_customer_orders_order_again')</h5>
                                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center lead">
                                            @lang('orders.dashboard_customer_orders_gh_not_available_title')
                                        </p>
                                        <p class="text-center lead">@lang('orders.dashboard_customer_orders_gh_not_available')</p>
                                    </div>
                                    <div class="modal-footer pt-0 pb-0">
                                        <div class="container">
                                            <div class="row">
                                                <button type="button" class="col-sm-6 btn btn-outline-primary btn-sm text-uppercase" data-dismiss="modal">@lang('general.button_cancel') </button>
                                                <a href="#" class="col-sm-6 btn btn-primary btn-sm text-uppercase confirmbtn">@lang('general.button_view_similar_services')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
            {{$orders->links()}}
            </div>
            @else
            <div class="item text-center noResult">
				<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
			</div>
            @endif
        </div>
    </div>
</section>
<script type="text/javascript">
	$(document).on('click', "#ordersList .item .item-trigger .item-info .btn-default[type='button'], #ordersList .item .item-trigger .item-info-collapsed .btn-default[type='button']", function(e){
		e.stopPropagation();
	})
    $('body').on('click','.orderAgain',function () {
        var item = $(this);
        serviceid = item.data('serviceid');
        $('#orderagainModal .confirmbtn').attr('href','{{url(app()->getLocale()."/request/service")}}/'+serviceid);
        $('#orderagainModal').modal('show');
    });
    $('body').on('click','.notAvilable',function () {
        var item = $(this);
        categoryslug = item.data('categoryslug');
        $('#noGigHunter .confirmbtn').attr('href','{{url(app()->getLocale()."category")}}/'+categoryslug);
        $('#noGigHunter').modal('show');
    });
    $('.cantconfirm').click(function () {
        swal({title: "@lang('general.cantconfirm.title')",
              text: "@lang('general.cantconfirm.desc')",
              icon: "warning",
              dangerMode: true,});
    });
</script>
@include('customer.orders.done')
@include('customer.orders.conflect')
@include('customer.orders.extend_deadline')
@include('customer.orders.claim_refund')
@endsection