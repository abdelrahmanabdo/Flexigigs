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
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('customer.parts.sidecard')
            @include('customer.refund.search')
        </div>
        <div class="col-md-8">
            <div class="refund_nav item w-100 d-flex align-items-center justify-content-between">
				<h3 class="font-weight-bold text-capitalize m-0" style="font-size: 1.75rem;">@lang('general.refund.orders_refund')</h3>
				<a href="{{route('customer_orders')}}" class="btn btn-primary rounded">@lang('general.button_back_to_orders')</a>
			</div>
			<div class="tab-content mt-4" id="dashboardTabsContent">
	            @if(count($orders))
                <div class="tab-pane fade show active" id="HH_Refund" role="tabpanel">
					<div id="HH_Refund_Container" class="mt-5">
                        <div id="refundList" data-children=".item">
							@foreach($orders as $order)
							<div class="item refund_item">
								<!-- refund triger -->
								<div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList" data-target="#refund-{{$order->id}}" aria-expanded="true">
									<div class="item-info-collapsed row refund_item_collapsed">
                                        <div class="col-2 col-lg-1">
											<p class="font-weight-bold">#{{$order->id}}</p>
										</div>
										<div class="col-5 col-md-4 col-lg-3 pr-0">
											<p class="font-weight-bold text-capitalize">{{($order->type==1)?$order->request->name:$order->application->title}}</p>
										</div>
										<div class="col-5 col-md-6 col-lg-3 p-0">
											<div class="user">
												<div class="user-img-sm m-0 mr-2">
													<div class="user-img-sm-container">
														<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
													</div>
												</div>
												<div>
													<a href="{{route('customer_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
														<p class="font-weight-bold">{{$order->supplier->username}}</p>
													</a>
												</div>
											</div>
										</div>
										<div class="col-6 col-lg-2 p-0">
											<p class="text-capitalize">@lang('general.refund.refernceNo') HD79jG35</p>
										</div>
										<div class="col-6 col-lg-3">
                                            <div class="row d-flex flex-row justify-content-end align-items-center">
                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">{{($order->type==1)?Flexihelp::fixprice($order->request,'service')->total_transaction:Flexihelp::fixprice($order->application,'gig')->total_transaction}} @lang('general.service_price_unit_EGP')</p>
                                                <p class="text-capitalize text-black">{{$order->refund_status}}</p>
                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info row refund_item_info">
										<div class="col-10 text-left">

											<h2 class="font-weight-bold text-capitalize text-dark">{{($order->type==1)?$order->request->name:$order->application->title}}</h2>
											<p class="text-capitalize text-dark">logo design - Design</p>
											<p class="text-capitalize text-dark">@lang('general.refund.order') #{{$order->id}}</p>
										
										</div>
										<div class="col-2 text-right">
											<i class="icon-angle-down mr-2 d-inline-block"></i>
										</div>
                                    </div>
								</div>
								<!-- refund triger end -->
								<!-- refund content -->
								<div id="refund-{{$order->id}}" class="item-content collapse py-4 refund_item_content" role="tabpanel">
									<div class="container">
										<div class="row">
											@if($order->claim_refund == 1)
											<div class="col-12 alert alert-secondary rounded-0 d-flex align-items-center" role="alert">
												<p class="m-0 text-dark mr-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, obcaecati!</p>
												<img src="{{asset('images/fawry.png')}}" height="30px" alt="fawry logo">
											</div>
											@endif
											<div class="col-12 col-lg-6 d-flex flex-column align-items-start justify-content-between">
												@if($order->claim_refund == 2)
												<div class="refund_item_content_done d-flex align-items-start justify-content-start w-100 py-3">
													<div class="mr-2">
														<i class="fas fa-check-circle fa-3x text-primary"></i>
													</div>
													<div>
														<h5 class="font-weight-bold text-capitalize m-0">@lang('general.refund.fawry_number')</h5>
														<p>
															you recived your mony cash through fawry on {{date('d/m/Y at h:i a',strtotime($order->updated_at))}}
														</p>
													</div>
												</div>
												@else
												<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
													<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.refernceNo')</span>
													<span class="badge badge-primary rounded m-0">{{$order->fawryRefNo}}</span>
												</div>
												<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
													<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.fawry_number')</span>
													<span class="badge badge-primary rounded m-0">{{$order->fawry_number}}</span>
												</div>
												@endif

												<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
													<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.amount')</span>
													<span class="text-uppercase text-primary text-right font-weight-bold">{{($order->type==1)?Flexihelp::fixprice($order->request,'service')->total_transaction:Flexihelp::fixprice($order->application,'gig')->total_transaction}} @lang('general.service_price_unit_EGP')</span>
												</div>
												<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
													<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.payment_method')</span>
													<span class="text-secondary text-right text-capitalize">{{(strtolower($order->payment_method)=='fawry')?trans('general.cash_througth_fawry'):trans('general.cash_througth_card')}}</span>
												</div>
												<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
													<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.status.title')</span>
													<span class="text-secondary text-right text-capitalize">{{$order->refund_status}}</span>
												</div>
											</div>
										</div>
									
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
                </div>
				@else
				<div class="item text-center noResult">
					<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
				</div>
				@endif
            </div>
        </div>
    </div>
</section>
@endsection