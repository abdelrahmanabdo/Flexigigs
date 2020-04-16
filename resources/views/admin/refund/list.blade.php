@extends('layouts.home')
@section('title', trans('general.dashboard_my').' | '.trans('general.dashboard_nav_earnings'))
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route("home")}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_my')</li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_earnings')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.refund.search')
        </div>
        <div class="col-md-8">
        	<form action="{{route('changeToRefund')}}" method="POST">
                {{ csrf_field() }}

	            <div class="refund_nav item w-100 d-flex align-items-center justify-content-between">
					<h3 class="font-weight-bold text-capitalize m-0" style="font-size: 1.75rem;">@lang('general.refund.orders_refund')</h3>
					<a href="{{route('admin_orders')}}" class="btn btn-primary rounded">@lang('general.button_back_to_orders')</a>
				</div>
				@if(@$_GET['claim_refund']==1)
				<div class="refund_nav item w-100 d-flex align-items-center justify-content-between">
					<h3 class="font-weight-bold text-capitalize m-0 position-relative" style="font-size: 1.75rem;">
						<div class="custom-controls-stacked">
	                        <label class="custom-checkbox m-0">
	                                <input type="checkbox" class="custom-control-input" id="selectall">
	                                <span class="custom-control-indicator" style="top: initial !important;"></span>
	                                <span class="custom-control-description font-weight-bold text-capitalize" style="font-size: 1.4rem;">@lang('general.select_all')</span>
	                        </label>
						</div>
					</h3>
					<button type="submit" class="btn btn-outline-primary rounded">@lang('general.button_change_selected_to_refunded')</button>
				</div>
	            @endif
				<div class="tab-content mt-4" id="dashboardTabsContent">
	                @if(count($orders))
	                <div class="tab-pane fade show active" id="HH_Refund" role="tabpanel">

						<div id="HH_Refund_Container" class="mt-5">
	                        <div id="refundList" data-children=".item">
	                        	@php $i=0; @endphp
	                        	@foreach($orders as $order)
	                        	<!-- to refunded dynamic -->
								<div class="item refund_item">
									<!-- refund triger -->

									<div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList" data-target="#refund-{{$order->id}}" aria-expanded="true">
										<div class="item-info-collapsed row refund_item_collapsed">
											<div class="pl-3">
												<div class="custom-controls-stacked">
													<label class="custom-checkbox m-0 position-relative">
														<input type="checkbox" class="custom-control-input" name="order_id[{{$i}}]" value="{{$order->id}}">
														<span class="custom-control-indicator" style="top: initial !important;"></span>
													</label>
												</div>
											</div>
											<div class="col-12 d-lg-none d-md-block d-block"></div>
	                                        <div class="col-2 col-lg-1 p-lg-0">
												<p class="font-weight-bold">#{{$order->id}}</p>
											</div>
											<div class="col-5 col-md-4 col-lg-2 p-lg-0">
												<p class="font-weight-bold text-capitalize">
													{{($order->type==1)?$order->request->name:$order->application->title}}
												</p>
											</div>
											<div class="col-5 col-md-6 col-lg-3 pr-lg-0">
												<div class="row">
													<div class="user col-6">
														<div class="user-img-sm m-0 mr-2">
															<div class="user-img-sm-container">
																<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
															</div>
														</div>
														<div>
															<a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
																<p class="font-weight-bold">{{$order->supplier->username}}</p>
															</a>
														</div>
													</div>
													<div class="user col-6">
														<div class="user-img-sm m-0 mr-2">
															<div class="user-img-sm-container">
																<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
															</div>
														</div>
														<div>
															<a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
																<p class="font-weight-bold">{{$order->customer->username}}</p>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-6 col-lg-2 p-0 text-center">
												<p class="text-capitalize">{{$order->payment_method}}</p>
											</div>
											<div class="col-6 col-lg-3">
	                                            <div class="row d-flex flex-row justify-content-end align-items-center">
	                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">{{($order->type==1)?$order->request->price_data->handling:$order->application->price_data->handling}} @lang('general.service_price_unit_EGP')</p>
	                                                <p class="text-capitalize text-black">{{$order->refund_status}}</p>
	                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="item-info row refund_item_info">
											<div class="col-1">
												<div class="custom-controls-stacked">
													<label class="custom-checkbox m-0 position-relative">
														<input type="checkbox" class="custom-control-input" name="order_id[{{$i}}]" value="{{$order->id}}">
														<span class="custom-control-indicator" style="top: initial !important;"></span>
													</label>
												</div>
											</div>
											<div class="col-9 text-left pl-0">
												<h2 class="font-weight-bold text-capitalize text-dark">{{($order->type==1)?$order->request->name:$order->application->title}}</h2>
												<p class="text-capitalize text-dark">@lang('general.refund.order') #{{$order->id}}</p>
											</div>
											<div class="col-2 text-right">
												<i class="icon-angle-down mr-2 d-inline-block"></i>
											</div>
	                                    </div>
									</div>
									<!-- refund triger end -->
									<!-- refund content -->
									<div id="refund-{{$order->id}}" class="item-content collapse pt-4 refund_item_content" role="tabpanel">
										<div class="container">
											<div class="row">

												<div class="col-lg-6 col-12 d-flex flex-column align-items-center justify-content-{{($order->claim_refund==1)?'between':'start'}} px-2">
													<div class="refund_item_content_done d-flex align-items-start justify-content-between w-100 py-3">
														<div class="user m-0">
															<div class="user-img-sm m-0 mr-2">
																<div class="user-img-sm-container">
																	<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
																</div>
															</div>
															<div>
																<a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
																	<p class="font-weight-bold">{{$order->supplier->username}}</p>
																	<div class="br-wrapper br-theme-fontawesome-stars">
																		<?=Flexihelp::get_stars('supplier',2)?>
																	</div>
																</a>
															</div>
														</div>
														<div class="user m-0">
															<div class="user-img-sm m-0 mr-2">
																<div class="user-img-sm-container">
																	<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
																</div>
															</div>
															<div>
																<a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
																	<p class="font-weight-bold">{{$order->customer->username}}</p>
																	<div class="br-wrapper br-theme-fontawesome-stars">
																		<?=Flexihelp::get_stars('customer',2)?>
																	</div>
																</a>
															</div>
														</div>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.amount')</span>
														<span class="text-uppercase text-primary text-right font-weight-bold">{{($order->type==1)?$order->request->price_data->handling:$order->application->price_data->handling}}  @lang('general.service_price_unit_EGP')</span>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.date_requested')</span>
														<span class="text-secondary text-right text-capitalize">{{Flexihelp::defult_date($order->created_at)}}</span>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.deadLine')</span>
														<span class="text-danger text-right text-capitalize">{{Flexihelp::defult_date($order->delivery_at)}}</span>
													</div>
												</div>
												<div class="col-lg-6 col-12 d-flex flex-column align-items-center justify-content-{{($order->claim_refund==1)?'between':'start'}}">
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">Headhunter mobile</span>
														<span class="text-secondary text-right text-capitalize">{{$order->customer->phone}}</span>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.payment_method')</span>
														<span class="text-secondary text-right text-capitalize">{{$order->payment_method}}</span>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.status.title')</span>
														<span class="text-secondary text-right text-capitalize">{{$order->refund_status}}</span>
													</div>
													@if($order->claim_refund == 1)
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.refernceNo')</span>
														<span class="badge badge-primary m-0">{{$order->fawryRefNo}}</span>
													</div>
													<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
														<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.fawryServiceNo')</span>
														<span class="badge badge-primary m-0">{{$order->fawry_number}}</span>
													</div>
													@endif
												</div>
											</div>
											@if($order->claim_refund == 1)
											<div class="row justify-content-end py-4">
												<button type="button" class="btn btn-outline-primary rouded p-3 torefund"data-id="{{$order->id}}">@lang('general.button_change_to_refunded')</button>
											</div>
											@endif
										</div>
									</div>
								</div>
	                        	@php $i++; @endphp
								@endforeach
	                        	
							</div>
						</div>
			           
	                </div>
                    <div class="row mt-4">
                    	
                        {{$orders->links('vendor.pagination.withexport')}}
                    </div>
	                @else
						<div class="item text-center noResult">
							<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
						</div>
					@endif
	            </div>
        	</form>
        	<div class="modal fade export-modal" tabindex="-1" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form  onSubmit="$('.export-modal').modal('hide');" method="get" action="{{route('exportorder')}}" target="_blank">
                            {{csrf_field()}}
                            <input type="hidden" name="refund" value="true">
                            <input type="hidden" name="customer" value="{{ request()->has('customer') ? request()->get('customer') : '' }}">
                            <input type="hidden" name="type" value="{{ request()->has('type') ? request()->get('type') : '' }}">
                            <input type="hidden" name="claim_refund" value="{{ request()->has('claim_refund') ? request()->get('claim_refund') : '' }}">
                            <input type="hidden" name="date_from" value="{{ request()->has('date_from') ? request()->get('date_from') : '' }}">
                            <input type="hidden" name="date_to" value="{{ request()->has('date_to') ? request()->get('date_to') : '' }}">
                            <div class="modal-header">
                                <h5 class="modal-title">export data</h5>
                                <button type="reset" class="close"  aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                                <button class="btn btn-primary btn-block" type="submit" id="sendbtn">@lang('general.button_download')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	$('.custom-checkbox').each(function(i, el){
		$(el).click(function(e){
			e.stopPropagation();
		});
	});
	$('#selectall').change(function () {
		if(this.checked) {
			$('.custom-control-input').prop('checked', true);
	    }else{
			$('.custom-control-input').prop('checked', false);
	    }
	});

</script>
@include('admin.refund.refund')
@endsection